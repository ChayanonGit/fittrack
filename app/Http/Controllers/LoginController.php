<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Psr\Http\Message\ServerRequestInterface;

class LoginController extends Controller
{
    //


    function showLoginForm(): View
    {
        return view('logins.form');
    }

    function logout(): RedirectResponse
    {

        Auth::logout();

        session()->invalidate();

        // regenerate CSRF token

        session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have logged out successfully!');
    }

    public function signup(ServerRequestInterface $request,): RedirectResponse
    {
        $data = $request->getParsedBody();
        $user = new User();
        $user->fill($data);
        $user->email = $data['email'];
        $user->role = "USER";




        try {
            $user->save();
            return redirect(
                session()->get('bookmarks.users.view', route('home'))
            )


                ->with('success', " {$user->name} Sign Up Success!");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }
    function authenticate(ServerRequestInterface $request): RedirectResponse
    {

        // get credentials from user.
        $data = $request->getParsedBody();

        $credentials = [

            'email' => $data['email'],

            'password' => $data['password'],

        ];

        // authenticate by using method attempt()
        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect()->intended(route('home'));
        }

        // if cannot authenticate redirect back to loginForm with error message.
        return redirect()->back()->withErrors([

            'credentials' => 'The provided credentials do not match our records.',

        ]);
        $validator = Validator::make(

            $request->getParsedBody(),

            [

                'email' => 'required',

                'password' => 'required',

            ],
        );

        if (

            $validator->passes() &&

            Auth::attempt(

                $validator->safe()->only(['email', 'password']),

            )

        ) {

            // regenerate the new session ID

            session()->regenerate();

            // redirect to the requested URL or

            // to route products.list if does not specify

            return redirect()->intended(route('home'))
                ->with('success', 'Login successful!');
        }
        $validator

            ->errors()

            ->add(

                'credentials',

                'The provided credentials do not match our records.',

            );

        return redirect()

            ->back()

            ->withErrors($validator)
            ->with('error', 'Login failed! Please check your credentials.');
    }
}
