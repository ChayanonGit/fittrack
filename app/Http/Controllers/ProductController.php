<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\View\View;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;


class ProductController extends SearchableController
{

    const MAX_ITEMS = 5;

    #[\Override]
    function getQuery(): Builder
    {
        return Product::orderBy('code');
    }

    /**
     * Display a listing of the resource.
     */
    function prepareCriteria(array $criteria): array
    {
        return parent::prepareCriteria($criteria); // ใช้ของแม่คลาส
    }

    /**
     * ใช้สำหรับกำหนดการค้นหาด้วย term
     */
    function applyWhereToFilterByTerm(Builder $query, string $word): void
    {
        $query->where('code', 'LIKE', "%{$word}%")
            ->orWhere('name', 'LIKE', "%{$word}%");

        if (is_numeric($word)) {
            $query->orWhereRaw('CAST(price AS CHAR) LIKE ?', ["%{$word}%"]);
        }
    }

    /**
     * แสดงหน้ารายการสินค้า
     */
    public function list(ServerRequestInterface $request): View
    {
        Gate::authorize('viewAny', Product::class);

        $criteria = $this->prepareCriteria($request->getQueryParams());

        $query = $this->search($criteria);

        $products = $query->paginate(8)->withQueryString();

        // เก็บ URL ปัจจุบันไว้ใน session สำหรับกลับมาหน้านี้
        session()->put('bookmarks.products.list', url()->full());

        return view('products.list', [
            'criteria' => $criteria,
            'products' => $products,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function createform(): View
    {
        Gate::authorize('create', Product::class);

        // $category = $categorycontroller->getQuery()->get();
        $category = Category::all();
        return view('products.create-form', [
            'category' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(ServerRequestInterface $request, CategoryController $categoryController): RedirectResponse
    {
        Gate::authorize('create', Product::class);

        try {
            $data = $request->getParsedBody();
            $category = $categoryController->find($data['category']); // ดึง Category
            if (Product::where('code', $data['code'])->exists()) {
                return redirect()->back()->withInput()->with('error', "Code {$data['code']} มีอยู่แล้ว!");
            }
            // อัปโหลดไฟล์รูป
            $uploadedFiles = $request->getUploadedFiles();

            if (isset($uploadedFiles['img'])) {
                $file = $uploadedFiles['img'];
                $filename = $file->getClientFilename();

                $destination = storage_path('app/public/img_product/');
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $file->moveTo($destination . $filename);
                $data['img'] = $filename;
            }

            // สร้าง Product แล้ว associate กับ Category
            $product = new Product();
            $product->fill($data);
            $product->category()->associate($category); // set category_id
            $product->save();

            return redirect(session()->get('bookmarks.products.create-form', route('products.list')))
                ->with('success', "Product {$product->code} ถูกสร้างเรียบร้อยแล้ว!");
        } catch (QueryException $excp) {
            // ส่ง session สำหรับ SweetAlert error
            return redirect()->back()->withInput()->with('error', $excp->errorInfo[2]);
        }
    }


    /**
     * Display the specified resource.
     */
    function showUpdateForm(request $request, string $productCode): View
    {
        Gate::authorize('update', Product::class);

        $fromCategory = $request->query('from_category');
        $product = Product::with('category')->where('code', $productCode)->firstOrFail();
        $category = Category::all();
        return view('products.update-form', [
            'product' => $product,
            'category' => $category,
            'fromCategory' => $fromCategory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    function update(ServerRequestInterface $request, string $productCode, CategoryController $categoryController): RedirectResponse
    {
        Gate::authorize('update', Product::class);

        $product = $this->find($productCode);
        $data = $request->getParsedBody();
        $category = $categoryController->find($data['category']);


        $fromCategory = $data['from_category'] ?? null;

        try {
            if (isset($data['code']) && Product::where('code', $data['code'])->where('id', '!=', $product->id)->exists()) {
                return redirect()->back()->withInput()->with('error', "Code {$data['code']} มีอยู่แล้ว!");
            }
            $product->fill($data);
            $product->category()->associate($category);
            $product->save();

            if ($fromCategory) {
                return redirect()
                    ->route('category.view-product', ['category' => $fromCategory])
                    ->with('success', "Category {$category->code} อัพสำเร็จ!");
            }
            return redirect()
                ->route('products.list', [
                    'product' => $product->code,
                ])
                ->with('success', " {$product->code} อัพเดทสำเร็จ!");
        } catch (QueryException $excp) {
            // ส่ง session สำหรับ SweetAlert error
            return redirect()->back()->withInput()->with('error', $excp->errorInfo[2]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    function delete(string $productCode, Request $request): RedirectResponse
    {


        $product = $this->find($productCode);

        try {
            $product->delete();

            $successMessage = "{$product->code} Delete Success!";
            if ($request->has('from_category')) {
                return redirect()
                    ->route('category.view-product', ['category' => $request->input('from_category')])
                    ->with('success', $successMessage);
            }

            return redirect(
                session()->get('bookmarks.products.list', route('products.list'))
            )
                ->with('success', $successMessage);
        } catch (QueryException $excp) {
            return redirect()->back()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }
}
