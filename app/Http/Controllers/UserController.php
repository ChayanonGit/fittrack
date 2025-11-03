<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use GuzzleHttp\Psr7\ServerRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class UserController extends SearchableController
{
    const int MAX_ITEMS = 10;

    #[\Override]
    function getQuery(): Builder
    {
        return User::orderBy('role');
    }

    #[\Override]
    function applyWhereToFilterByTerm(Builder $query, string $word): void
    {

        $query->where('name', 'LIKE', "%{$word}%")
            ->orWhere('email', 'LIKE', "%{$word}%")
            ->orWhere('role', 'LIKE', "%{$word}%");
    }




    public function list(ServerRequestInterface $request): View
    {
        
        Gate::authorize('view', User::class);
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria);
        // $users = User::orderBy('role')->get();
        return view('users.list', [
            'criteria' => $criteria,
            'users' => $query->paginate(self::MAX_ITEMS),
        ]);
    }


    public function showCreateForm(): View
    {

        Gate::authorize('create', User::class);
        $users = User::all();
        return view('users.create-form', [
            'users' => $users,
        ]);
    }

    public function create(ServerRequestInterface $request,): RedirectResponse
    {
         Gate::authorize('create', User::class);

        $data = $request->getParsedBody();
        $user = new User();
        $user->fill($data);
        $user->email = $data['email'];
        $user->role = $data['role'];;




        try {
            $user->save();
            return redirect(
                session()->get('bookmarks.users.view', route('users.list'))
            )


                ->with('status', "User was created.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }

    function view(string $email): View
    {
        $data = $this->getQuery()->where('email', $email)->firstOrFail();

        return view('users.view', [
            'users' => $data,
        ]);
    }
    function selfView(): View
    {
        $data = Auth::user();

        return view('users.view-selves', [
            'users' => $data,
        ]);
    }

    function showUpdateSelf(): View
    {
        $data = Auth::user();
        Gate::authorize('updateselves', $data);

        return view('users.update-selves-form', [
            'users' => $data,

        ]);
    }

    function updateSelf(ServerRequestInterface $request): RedirectResponse
    {
        $users = Auth::user();
        assert($users instanceof User);
        Gate::authorize('updateselves', $users);

        $data = $request->getParsedBody();

        if (isset($data['email']) && !empty($data['email']) && $data['email'] !== $users->email) {
            $users->email = $data['email'];
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $users->password = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $users->fill($data);
        $users->role = $data['role'];


        try {
            $users->save();

            return redirect()
                ->route('users.view-selves')
                ->with('status', " Update Successfully.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }
    function showUpdateForm(string $email): View
    {
        $role = user::all();
        $data = $this->getQuery()->where('email', $email)->firstOrFail();
        return view('users.update-form', [
            'users' => $data,
            'role' => $role,
        ]);
    }

    function update(ServerRequestInterface $request, string $email): RedirectResponse
    {
        $data = $request->getParsedBody();

        $users = $this->getQuery()->where('email', $email)->first();
        Gate::authorize('update', $users);
        if (isset($data['email']) && !empty($data['email']) && $data['email'] !== $users->email) {
            $users->email = $data['email'];
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $users->password = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $users->fill($data);
        $users->role = $data['role'];




        try {
            $users->save();


            return redirect()
                ->route('users.view', [
                    'user' => $data['email'] ?? $email,
                ])
                ->with('success', " Update Successfully.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }

    function delete(string $email): RedirectResponse
    {
        $users = $this->getQuery()->where('email', $email)->first();;
        // Gate::authorize('delete', $users);


        try {
            $users->delete();


            return redirect(
                session()->get('bookmarks.users.view', route('users.list'))
            )
                ->with('status', "Delete Successfully.");
        } catch (QueryException $excp) {
            // We don't want withInput() here.
            return redirect()->back()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }
}
