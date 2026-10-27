<?php

test('guest user can access the login page', function () {
    $this->actingAsGuest()
        ->get(route('login'))
        ->assertOk();
});


test('can login with valid credentials', function () {
    $user = createTestUser();

    $response = $this->post(route('login.store'), [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);
    
    $this->assertAuthenticatedAs($user);
    
    $response->assertRedirect(route('home'));
});

test('cannot login with incorrect email', function () {
    $response = $this->post(route('login.store'), [
        'email' => 'wrong@example.com',
        'password' => 'password',
    ]);

    $this->assertGuest();
    $response->assertRedirect()
        ->assertSessionHasErrors('email');
});

test('cannot login with incorrect password', function () {
    createTestUser();

    $response = $this->post(route('login.store'), [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
    $response->assertRedirect()
        ->assertSessionHasErrors('email');
});

test('cannot login with empty credentials',function(){
    $this->post(route('login.store'))
        ->assertRedirect()
        ->assertSessionHasErrors(['email', 'password']);
});

test('cannot login with invalid email address',function(){
    $this->post(route('login.store'), [
        'email' => 'test@',
        'password' => 'password',
    ])
        ->assertRedirect()
        ->assertSessionHasErrors('email');
});

test('authenticated user visits a guest-only login page and gets redirected', function () {
$this->actingAs(createTestUser())
        ->get(route('login'))
        ->assertRedirect(route('home'));
});

test('authenticated user can logout', function(){
    $this->actingAs(createTestUser());

    $this->post(route('logout'))
        ->assertRedirect(route('home'));

    $this->assertGuest();
});

test('unauthenticated user cannot logout', function(){
    $this->post(route('logout'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('remember me checkbox creates remember token',function(){
    $user = createTestUser();

    $this->post(route('login.store'), [
        'email' => 'test@example.com',
        'password' => 'password',
        'remember'=> true
    ]);

    $this->assertAuthenticatedAs($user);

    expect($user->refresh()->remember_token)
        ->not()->toBeNull();
});

test('repeated failed attempts trigger throttle',function(){
    $user = createTestUser();

    foreach (range(1, 5) as $attempt) {
        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertRedirect()
          ->assertSessionHasErrors('email');
    }

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertTooManyRequests();

    $this->assertGuest();
});

test('can successfully login after failed attempts',function(){
    $user = createTestUser();

    foreach (range(1, 4) as $attempt) {
        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertRedirect()
          ->assertSessionHasErrors('email');
    }

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('home'));

    $this->assertAuthenticatedAs($user);
});

test('allows requests again after the rate limit expires', function(){
    $user = createTestUser();

    foreach (range(1, 5) as $attempt) {
        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertRedirect()
          ->assertSessionHasErrors('email');
    }

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertTooManyRequests();

    $this->travel(1)->minute();

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertRedirect()
      ->assertSessionHasErrors('email');

    $this->assertGuest();
});