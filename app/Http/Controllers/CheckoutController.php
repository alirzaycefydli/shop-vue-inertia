<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Addresses\GetUserAddresses;
use App\Actions\Addresses\ResolveCheckoutAddress;
use App\Actions\Cart\AllCartProducts;
use App\Actions\Cart\GetGuestUserCartItems;
use App\Actions\Payments\CreateStripeCheckout;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\GuestCartItemResource;
use Inertia\Inertia;

final class CheckoutController extends Controller
{
    public function index(AllCartProducts $action, GetUserAddresses $userAddressesAction, GetGuestUserCartItems $guestAction)
    {
        if (auth()->user()) {
            $products = CartItemResource::collection($action->handle(auth()->user()));
            $addresses = $userAddressesAction->handle();
        } else {
            $products = GuestCartItemResource::collection($guestAction->handle());
            $addresses = null;
        }

        if (! $products->count()) {
            return redirect()->route('products.index');
        }

        return inertia('Checkout/Index',
            [
                'products' => $products ?? null,
                'addresses' => $addresses ?? null,
            ]
        );
    }

    public function store(CheckoutRequest $request, ResolveCheckoutAddress $resolveAddressAction, CreateStripeCheckout $stripeAction)
    {
        $address = $resolveAddressAction->handle($request->input('address'));

        $session = $stripeAction->handle( $address->id);

        return Inertia::location($session->url);
    }
}
