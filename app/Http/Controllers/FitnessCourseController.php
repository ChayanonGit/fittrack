<?php

namespace App\Http\Controllers;

use App\Models\FitnessCourse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\View\View;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

class FitnessCourseController extends SearchableController
{
    const MAX_ITEMS = 5;

    #[\Override]
    function getQuery(): Builder
    {
        return FitnessCourse::orderBy('code');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    function applyWhereToFilterByTerm(Builder $query, string $word): void
    {
        $query->where('code', 'LIKE', "%{$word}%")
            ->orWhere('name', 'LIKE', "%{$word}%");

        if (is_numeric($word)) {
            $query->orWhereRaw('CAST(price AS CHAR) LIKE ?', ["%{$word}%"]);
        }
    }
    public function list(Request $request): View
    {
        Gate::authorize('viewAny', FitnessCourse::class);

        // ดึง query string เพื่อ filter
        if ($request->has('term')) {
            session(['fitnessclass_search_term' => $request->input('term')]);
        }

        // 2️⃣ เตรียม criteria จาก input หรือ session
        $term = $request->input('term') ?? session('fitnessclass_search_term', '');
        $criteria = $this->prepareCriteria(['term' => $term]);

        // 3️⃣ ใช้ search() จาก SearchableController
        $query = $this->search($criteria);

        // 4️⃣ Paginate + append query string
        $class = $query->paginate(self::MAX_ITEMS)->appends(['term' => $term]);

        // ส่งข้อมูลไป Blade
        return view('fitnessclass.list', [
            'criteria' => $criteria,
            'class' => $class,
        ]);
    }


    public function createform()
    {
        Gate::authorize('create', FitnessCourse::class);

        return view('fitnessclass.create-class');
    }

    public function create(ServerRequestInterface $request): RedirectResponse
    {
        Gate::authorize('create', FitnessCourse::class);

        try {
            $data = $request->getParsedBody();
            $uploadedFiles = $request->getUploadedFiles();

            if (isset($uploadedFiles['img'])) {
                $file = $uploadedFiles['img'];
                $filename = $file->getClientFilename();

                // ตรวจสอบโฟลเดอร์ก่อนย้ายไฟล์
                $destination = storage_path('app/public/img_class/');
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $file->moveTo($destination . $filename);

                $data['img'] = $filename;
            }

            $classes = FitnessCourse::create($data);
            return redirect(
                session()->get('bookmarks.categories.create-form', route('fitnessclass.list'))
            )->with('status', "Class {$classes->code} was created.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }


    function Updateclass(string $classCode): View
    {
        Gate::authorize('update', FitnessCourse::class);

        $class = $this->find($classCode);

        return view('fitnessclass.update-class', [
            'class' => $class,
        ]);
    }


    function update(ServerRequestInterface $request, string $classCode,): RedirectResponse
    {
        $class = $this->find($classCode);

        Gate::authorize('update', FitnessCourse::class);

        try {
            $class->fill($request->getParsedBody());
            $class->save();

            $uploadedFiles = $request->getUploadedFiles();

            if (isset($uploadedFiles['img'])) {
                $file = $uploadedFiles['img'];

                if ($file->getError() === UPLOAD_ERR_OK) {
                    $filename = $file->getClientFilename();

                    // ย้ายไฟล์ไป storage
                    $file->moveTo(storage_path('app/public/img_cat/' . $filename));

                    // อัปเดตชื่อไฟล์ใน DB
                    $class->img = $filename;
                }
            }
            $class->save();
            return redirect()
                ->route('fitnessclass.list')
                ->with('status', "Category {$class->code} was updated.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    function delete(string $ClassCode): RedirectResponse
    {

        $class = $this->find($ClassCode);

        $class->delete();

        try {
            $class->delete();

            return redirect(
                session()->get('bookmarks.category.list', route('fitnessclass.list'))
            )
                ->with('status', "class {$class->code} was deleted.");
        } catch (QueryException $excp) {
            // We don't want withInput() here.
            return redirect()->back()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }
}
