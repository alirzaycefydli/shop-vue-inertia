<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\Categories\NavigationCategories;
use App\Http\Resources\CategoryResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Middleware;

final class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            'user' => fn () => $request->user()
                ? $request->user()->only('id', 'name', 'email')
                : null,
            'search' => fn () => $request->has('search')
                ? $request->search
                : '',
            'navigation_categories' => fn () => CategoryResource::collection(
                app(NavigationCategories::class)->handle()
            ),
            'cart_count' => fn () => $request->user()
                ? $request->user()->cart?->cartItem->count() ?? 0
                : 0,
            'wishlist_count' => fn () => $request->user()
                ? $request->user()->wishlists?->count() ?? 0
                : 0,
            'errors' => fn () => Inertia::always(
                $request->session()->get('errors')
                    ? $request->session()->get('errors')->getBag('default')->getMessages()
                    : (object) []
            ),
            'messages' => fn () => Inertia::always(
                $request->session()->get('messages')
            ),
        ];
    }
}
