<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

final class AuthenticateUser
{

    /**
     * Validate and authenticate the user.
     *
     * @param Request $request
     *
     * @return User|null
     *
     * @throws ValidationException
     */
    public function authenticate(Request $request): User|null
    {
        $credentials = Validator::make($request->only('email', 'password','remember'), [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                Password::min(8)
            ],
            'remember' => ['boolean'],
        ])->validate();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return null;
        }

        if ($user &&
            Hash::check($credentials['password'], $user->password)) {
            return $user;
        }
    }
}
