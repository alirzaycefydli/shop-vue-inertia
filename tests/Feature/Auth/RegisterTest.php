<?php

test('guest user can access the register page', function () {
    $this->actingAsGuest()
        ->get(route('register'))
        ->assertOk();
});

test('can create an account', function () {
    $response = $this->post(route('register.store'), [
        'name'=> 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    
    $response->assertRedirect(route('home'));
    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'test@example.com',
    ]);
    $this->assertDatabaseCount('users', 1);
    $this->assertAuthenticated();
});

test('authenticated user visits a guest-only register page and gets redirected', function () {
    $this->actingAs(createTestUser())
        ->get(route('login'))
        ->assertRedirect(route('home'));
});

test('cannot create an account with empty credentials', function(){
    $response = $this->post(route('register.store'));

    $this->assertGuest();
    $response->assertRedirect()
        ->assertSessionHasErrors(['name', 'email', 'password']);
});


test('cannot create an account with incorrect password confirmation', function(){
    $response = $this->post(route('register.store'), [
        'name'=> 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'wrong-password',
    ]);

    $this->assertGuest();
    $response->assertRedirect()
        ->assertSessionHasErrors('password');
});

test('cannot create an account with invalid email', function(){
    $response = $this->post(route('register.store'), [
        'name'=> 'John Doe',
        'email' => 'test.example',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertRedirect()
        ->assertSessionHasErrors('email');
});

test('cannot create an account with duplicated email', function(){
    createTestUser();
    $response = $this->post(route('register.store'), [
        'name'=> 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertRedirect()
        ->assertSessionHasErrors('email');
    $this->assertDatabaseCount('users', 1);
});

test('cannot create an account with too short password', function(){
    $response = $this->post(route('register.store'), [
        'name'=> 'John Doe',
        'email' => 'test@example.com',
        'password' => 'pass',
        'password_confirmation' => 'pass',
    ]);

    $this->assertGuest();
    $response->assertRedirect()
        ->assertSessionHasErrors('password');
});

test('cannot create an account without a name', function(){
    $response = $this->post(route('register.store'), [
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertRedirect()
        ->assertSessionHasErrors('name');
});

test('authenticated user redirected from registration page', function(){
    $this->actingAs(createTestUser());

    $this->get(route('register'))
        ->assertRedirect(route('home'));
});