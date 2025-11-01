<?php

namespace App\Http\Controllers;

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
        // ดึง query string เพื่อ filter
        $criteria = $request->query(); // ['name' => 'Yoga']

        // Query Builder ของ Category
        $query = Product::query();

        // ตัวอย่าง filter ตามชื่อ
        if (!empty($criteria['name'])) {
            $query->where('name', 'like', '%' . $criteria['name'] . '%');
        }

        // Paginate 5 ต่อหน้า
        $shop = $query->paginate(self::MAX_ITEMS);

        // ส่งข้อมูลไป Blade
        return view('shop.view-shop', [
            'criteria' => $criteria,
            'shop' => $shop,
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
