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


    function applyWhereToFilterByTerm(Builder $query, string $word): void
    {
        $query->where('code', 'LIKE', "%{$word}%")
            ->orWhere('name', 'LIKE', "%{$word}%");

        if (is_numeric($word)) {
            $query->orWhereRaw('CAST(price AS CHAR) LIKE ?', ["%{$word}%"]);
        }
    }
    public function viewshop(ServerRequestInterface $request): View
    {
        $criteria = $this->prepareCriteria($request->getQueryParams());

        $query = $this->search($criteria);

        $shop = $query->paginate(8)->withQueryString();

        $categories = Category::all();



        session()->put('bookmarks.products.list', url()->full());

        return view('shop.view-shop', [
            'criteria' => $criteria,
            'shop' => $shop,

            'categories' => $categories,

        ]);
    }


    public function viewclass(ServerRequestInterface $request): View
    {
       
        $criteria = $this->prepareCriteria($request->getQueryParams()); // ['name' => 'Yoga']

  
        $query = FitnessCourse::query();;

        return view(
            'shop.view-class',
            [
                'criteria' => $criteria,
                'class' => $query->paginate(self::MAX_ITEMS),
            ]
        );
    }

    public function classenroll(ServerRequestInterface $request): View
    {
       
        $criteria = $this->prepareCriteria($request->getQueryParams()); // ['name' => 'Yoga']
       
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
