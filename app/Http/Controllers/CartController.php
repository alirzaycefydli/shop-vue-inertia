<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Cart\AllCartProducts;
use App\Actions\Cart\CreateCartItem;
use App\Actions\Cart\DeleteCartItem;
use App\Actions\Cart\UpdateCartItem;
use App\Http\Resources\CartItemResource;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class CartController extends Controller
{
    public function index(AllCartProducts $action): Response
    {
        return Inertia::render('Cart/Index', [
            'products' => CartItemResource::collection($action->handle(auth()->user())),
        ]);
    }

    public function store(Product $product, CreateCartItem $action): void
    {
        $action->handle($product, auth()->user());
        session()->flash('messages', ['type' => 'success', 'message' => 'Product added to cart!']);
    }

    public function update(Request $request, CartItem $cartItem, UpdateCartItem $action): void
    {
        if ($request->user()->cannot('update', $cartItem)) {
            abort(403);
        }

        $action->handle($cartItem, $request->quantity);
    }

    public function destroy(Request $request, CartItem $cartItem, DeleteCartItem $action): void
    {
        if ($request->user()->cannot('delete', $cartItem)) {
            abort(403);
        }

        $action->handle($cartItem);
        session()->flash('messages', ['type' => 'success', 'message' => 'Product deleted from your cart!']);
    }
}
