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
use Illuminate\Database\Eloquent\Relations\Relation;

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

    #[\Override]
    function applyWhereToFilterByTerm(Builder $query, string $word): void
    {
        parent::applyWhereToFilterByTerm($query, $word);
        $query->orWhere('code', 'LIKE', "%{$word}%");
    }
    #[\Override]
    function prepareCriteria(array $criteria): array
    {
        return [
            ...parent::prepareCriteria($criteria),
            'minPrice' => (($criteria['minPrice'] ?? null) === null)
                ? null
                : (float) $criteria['minPrice'],
            'maxPrice' => (($criteria['maxPrice'] ?? null) === null)
                ? null
                : (float) $criteria['maxPrice'],
        ];
    }

    function filterByPrice(
        Builder|Relation $query,
        ?float $minPrice,
        ?float $maxPrice
    ): Builder|Relation {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }
    #[\Override]
    function filter(Builder|Relation $query, array $criteria): Builder|Relation
    {
        $query = parent::filter($query, $criteria);
        $query = $this->filterByPrice(
            $query,
            $criteria['minPrice'],
            $criteria['maxPrice'],
        );

        return $query;
    }

    public function viewshop(ServerRequestInterface $request): View
    {

        $criteria = $this->prepareCriteria($request->getQueryParams());


        $query = $this->search($criteria)->with('category');


        $shop = $query->paginate(self::MAX_ITEMS);


        $categories = Category::all();

        return view('shop.view-shop', [
            'criteria' => $criteria,
            'shop' => $shop,
            'categories' => $categories,
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
