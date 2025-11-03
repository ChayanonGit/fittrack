<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\FitnessCourse; // ✅ เพิ่มบรรทัดนี้
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
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
    function applyWhereToFilterByTerm(Builder $query, string $word): void
{
    $query->where('code', 'LIKE', "%{$word}%")
          ->orWhere('name', 'LIKE', "%{$word}%");

    // ตรวจสอบว่ามีคอลัมน์ price ก่อน
    if (in_array('price', $query->getModel()->getFillable()) && is_numeric($word)) {
        $query->orWhereRaw('CAST(price AS CHAR) LIKE ?', ["%{$word}%"]);
    }
}
    public function list(Request $request): View
    {
        // 1️⃣ ถ้ามี query ใหม่ (search)
        if ($request->has('term')) {
            session(['category_search_term' => $request->input('term')]);
        }

        // 2️⃣ เตรียม criteria จาก input หรือ session
        $term = $request->input('term') ?? session('category_search_term', '');
        $criteria = $this->prepareCriteria(['term' => $term]);

        // 3️⃣ ใช้ search() จาก SearchableController
        $query = $this->search($criteria);

        // 4️⃣ Paginate + append query string
        $categories = $query->paginate(self::MAX_ITEMS)->appends(['term' => $term]);

        // 5️⃣ ส่งไป Blade
        return view('category.list', [
            'criteria' => $criteria,
            'category' => $categories,
        ]);
    }

    public function resetSearch(): RedirectResponse
    {
        session()->forget('category_search_term');
        return redirect()->route('category.list');
    }

    // ฟังก์ชัน reset search

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

        try {
            if (isset($data['code']) && Category::where('code', $data['code'])->exists()) {
                return redirect()->back()->withInput()->with('error', "Code {$data['code']} ซ้ำ! กรุณาใช้ code ใหม่");
            }
            $category = Category::create($data);

            // Success SweetAlert
            return redirect(
                session()->get('bookmarks.categories.create-form', route('category.list'))
            )->with('success', "Category {$category->code} ถูกสร้างเรียบร้อยแล้ว!");
        } catch (\Illuminate\Database\QueryException $excp) {
            // Error SweetAlert
            return redirect()->back()->withInput()->with('error', $excp->errorInfo[2]);
        }
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


    public function update(ServerRequestInterface $request, string $CateCode): RedirectResponse
    {
        $category = $this->find($CateCode);
        $data = $request->getParsedBody();

        try {
            // ตรวจสอบ duplicate สำหรับ record อื่น
            if (
                isset($data['code']) &&
                Category::where('code', $data['code'])
                ->where('id', '!=', $category->id)
                ->exists()
            ) {
                return redirect()->back()->withInput()->with([
                    'error' => "Code {$data['code']} ซ้ำ! กรุณาใช้ code ใหม่"
                ]);
            }

            // เติมค่าจาก form
            $category->fill($data);

            // อัปโหลดไฟล์ถ้ามี
            $uploadedFiles = $request->getUploadedFiles();
            if (isset($uploadedFiles['img'])) {
                $file = $uploadedFiles['img'];
                if ($file->getError() === UPLOAD_ERR_OK) {
                    $filename = $file->getClientFilename();
                    $file->moveTo(storage_path('app/public/img_cat/' . $filename));
                    $category->img = $filename;
                }
            }

            // บันทึกข้อมูล
            $category->save();

            return redirect()->route('category.list')
                ->with('success', " {$category->code} อัพเดทสำเร็จ!");
        } catch (QueryException $excp) {
            // ส่ง session สำหรับ SweetAlert error
            return redirect()->back()->withInput()->with('error', $excp->errorInfo[2]);
        }
    }


    function delete(string $CateCode): RedirectResponse
    {
        $category = $this->find($CateCode);

        $category->delete();
        $successMessage = "{$category->code} Delete Success!";

        try {
            $category->delete();
            return redirect(
                session()->get('bookmarks.category.list', route('category.list'))
            )
                ->with('success', $successMessage);
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
