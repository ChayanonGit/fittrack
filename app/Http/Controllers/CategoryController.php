<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends SearchableController
{
    const MAX_ITEMS = 5;

    #[\Override]
    function getQuery(): Builder
    {
        return Category::orderBy('code');
    }

    public function List(Request $request): View
    {
        // ดึง query string เพื่อ filter
        $criteria = $request->query(); // ['name' => 'Yoga']

        // Query Builder ของ Category
        $query = Category::query();

        // ตัวอย่าง filter ตามชื่อ
        if (!empty($criteria['name'])) {
            $query->where('name', 'like', '%' . $criteria['name'] . '%');
        }

        // Paginate 5 ต่อหน้า
        $category = $query->paginate(self::MAX_ITEMS);

        // ส่งข้อมูลไป Blade
        return view('category.list', [
            'criteria' => $criteria,
            'category' => $category,
        ]);
    }


    public function createform()
    {
        return view('category.create-form');
    }

    public function create(ServerRequestInterface $request): RedirectResponse
    {
        $data = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();

        if (isset($uploadedFiles['img'])) {
            $file = $uploadedFiles['img'];
            $filename = $file->getClientFilename();
            $file->moveTo(storage_path('app/public/img_cat/' . $filename));

            $data['img'] = $filename;
        }

        $category = Category::create($data);

        return redirect(
            session()->get('bookmarks.categories.create-form', route('category.list'))
        )->with('status', "Category {$category->code} was created.");
    }



    function showUpdateForm(string $cateCode): View
    {

        $category = $this->find($cateCode);

        return view('category.update-form', [
            'category' => $category,
        ]);
    }


    public function edit(string $id)
    {
        //
    }


    function update(ServerRequestInterface $request, string $CateCode,): RedirectResponse
    {
        $category = $this->find($CateCode);


        try {
            $category->fill($request->getParsedBody());
            $category->save();

            $uploadedFiles = $request->getUploadedFiles();

            if (isset($uploadedFiles['img'])) {
                $file = $uploadedFiles['img'];

                if ($file->getError() === UPLOAD_ERR_OK) {
                    $filename = $file->getClientFilename();

                    // ย้ายไฟล์ไป storage
                    $file->moveTo(storage_path('app/public/img_cat/' . $filename));

                    // อัปเดตชื่อไฟล์ใน DB
                    $category->img = $filename;
                }
            }
            $category->save();
            return redirect()
                ->route('category.list')
                ->with('status', "Category {$category->code} was updated.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }

    function delete(string $CateCode): RedirectResponse
    {
        $category = $this->find($CateCode);

        $category->delete();

        try {
            $category->delete();

            return redirect(
                session()->get('bookmarks.category.list', route('category.list'))
            )
                ->with('status', "Category {$category->code} was deleted.");
        } catch (QueryException $excp) {
            // We don't want withInput() here.
            return redirect()->back()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }
    function product_delete(string $ProductCode): RedirectResponse
    {
        $product = $this->find($ProductCode);
        dd($product);
        $product->delete();

        try {
            $product->delete();

            return redirect(
                session()->get('bookmarks.category.list', route('category.list'))
            )
                ->with('status', "Category {$product->code} was deleted.");
        } catch (QueryException $excp) {
            // We don't want withInput() here.
            return redirect()->back()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }
    function viewProducts(
        ServerRequestInterface $request,
        ProductController $ProductController,
        String $productCode,
    ): view {
        $category = $this->find($productCode);
        $criteria = $ProductController->prepareCriteria($request->getQueryParams());
        $query = $ProductController->filter(
            $category->products(),
            $criteria,
        )
            ->withCount('category');
        return view('category.view-product', [
            'category' => $category,
            'criteria' => $criteria,
            'product' => $query->paginate($ProductController::MAX_ITEMS),
        ]);
    }
}
