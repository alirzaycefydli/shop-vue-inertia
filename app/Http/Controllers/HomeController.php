<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Home\LatestProducts;
use App\Http\Resources\ProductCardResource;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

final class HomeController extends Controller
{
    public function index(LatestProducts $action): Response|ResponseFactory
    {
        return Inertia::render('Home', [
            'products' => ProductCardResource::collection($action->handle()),
        ]);
    }
}
