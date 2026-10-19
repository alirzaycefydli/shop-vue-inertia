<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Addresses\GetUserAddresses;
use App\Actions\Addresses\ResolveCheckoutAddress;
use App\Actions\Cart\AllCartProducts;
use App\Actions\Payments\CreateStripeCheckout;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CartItemResource;
use Inertia\Inertia;

final class CheckoutController extends Controller
{
    public function index(AllCartProducts $action, GetUserAddresses $userAddressesAction)
    {
        if (auth()->user()) {
            $products = CartItemResource::collection($action->handle(auth()->user()));
            $addresses = $userAddressesAction->handle();
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

        $session = $stripeAction->handle($request->input('items'), $address->id);

        return Inertia::location($session->url);
    }
}
