<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Cart\AllCartProducts;
use App\Actions\Cart\CreateCartItem;
use App\Actions\Cart\CreateGetGuestUserCartItem;
use App\Actions\Cart\DeleteCartItem;
use App\Actions\Cart\DeleteGuestCartItem;
use App\Actions\Cart\GetGuestUserCartItems;
use App\Actions\Cart\UpdateCartItem;
use App\Actions\Cart\UpdateGuestCartItem;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\GuestCartItemResource;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class CartController extends Controller
{
    public function index(AllCartProducts $action, GetGuestUserCartItems $guestAction): Response
    {
        if (auth()->user()) {
            $data = CartItemResource::collection($action->handle(auth()->user()));
        } else {
            $data = GuestCartItemResource::collection($guestAction->handle());
        }
        return Inertia::render('Cart/Index', [
            'products' => $data,
        ]);
    }

    public function store(Product $product, CreateCartItem $action, CreateGetGuestUserCartItem $guestAction): void
    {
        if (auth()->user()) {
            $action->handle($product, auth()->user());
        } else {
            $guestAction->handle($product);
        }

        session()->flash('messages', ['type' => 'success', 'message' => 'Product added to cart!']);
    }

    public function update(Request $request, string $id, UpdateCartItem $action, UpdateGuestCartItem $guestAction): void
    {
        if (auth()->user()) {
            $cartItem = CartItem::findOrFail($id);

            if ($request->user()->cannot('update', $cartItem)) {
                abort(403);
            }

            $action->handle($cartItem, $request->quantity);
        } else {
            $guestAction->handle($id, $request->quantity);
        }

    }

    public function destroy(Request $request, string $id, DeleteCartItem $action, DeleteGuestCartItem $guestAction): void
    {
        if (auth()->user()) {
            $cartItem = CartItem::findOrFail($id);

            if ($request->user()->cannot('delete', $cartItem)) {
                abort(403);
            }

            $action->handle($cartItem);
        } else {
            $guestAction->handle($id);
        }
        session()->flash('messages', ['type' => 'success', 'message' => 'Product deleted from your cart!']);
    }
}
