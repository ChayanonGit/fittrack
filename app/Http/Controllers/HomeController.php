<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FitnessCourse;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\View\View;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends SearchableController
{
    const MAX_ITEMS = 5;

    #[\Override]
    function getQuery(): Builder
    {
        return Product::orderBy('code');
    }

    public function Home()
    {
        return view('fittrack.home');
    }



    public function viewshop(Request $request)
    {
        $criteria = $request->query();

        // ดึง products ตาม filter
        $query = Product::query();
        if (!empty($criteria['name'])) {
            $query->where('name', 'like', '%' . $criteria['name'] . '%');
        }
        $shop = $query->paginate(self::MAX_ITEMS);

        // ดึง category ทั้งหมด
        $categories = Category::all();

        return view('shop.view-shop', [
            'criteria' => $criteria,
            'shop' => $shop,
            'categories' => $categories, // ส่งไป Blade ด้วย
        ]);
    }


    public function viewclass(ServerRequestInterface $request): View
    {
        // ดึง query string เพื่อ filter
        $criteria = $this->prepareCriteria($request->getQueryParams()); // ['name' => 'Yoga']

        // Query Builder ของ Category
        $query = FitnessCourse::query();;

        return view(
            'shop.view-class',
            [
                'criteria' => $criteria,
                'class' => $query->paginate(self::MAX_ITEMS),
            ]
        );
    }
}
