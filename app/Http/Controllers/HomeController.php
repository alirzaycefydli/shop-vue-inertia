<?php

namespace App\Http\Controllers;

use App\Actions\Home\LatestProducts;
use App\Http\Resources\ProductCardResource;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class HomeController extends Controller
{
    /**
     * @param LatestProducts $action
     * @return Response|ResponseFactory
     */
    public function index(LatestProducts $action): Response|ResponseFactory
    {
        //dd($action->handle());
        return Inertia::render('Home', [
            'products' => ProductCardResource::collection($action->handle()),
        ]);
    }
}
