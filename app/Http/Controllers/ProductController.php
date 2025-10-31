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
    public function list(ServerRequestInterface $request): View
    {
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria);

        return view('products.list', [
            'criteria' => $criteria,
            'products' => $query->paginate(self::MAX_ITEMS),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createform(): View
    {
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
        $data = $request->getParsedBody();
        $category = $categoryController->find($data['category']);


        try {
            $product = new Product();
            $product->fill($data);
            $product->category()->associate($category);
            $product->save();

            return redirect(
                session()->get('bookmarks.products.create-form', route('products.list'))
            )
                ->with('status', "Product {$product->code} was created.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    function showUpdateForm(string $productCode): View
    {

        $product = Product::where('code', $productCode)->firstOrFail();
        $category = Category::all();

        return view('products.update-form', [
            'product' => $product,
            'category' => $category,

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
        $product = $this->find($productCode);
        $data = $request->getParsedBody();
        $category = $categoryController->find($data['category']);




        try {
            $product->fill($data);
            $product->category()->associate($category);
            $product->save();

            return redirect()
                ->route('products.list', [
                    'product' => $product->code,
                ])
                ->with('status', "Product {$product->code} was updated.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],

            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);

        try {
            $product->delete();

            return redirect(
                session()->get('bookmarks.products.list', route('products.list'))
            )
                ->with('status', "Product {$product->code} was deleted.");
        } catch (QueryException $excp) {

            return redirect()->back()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }
}
