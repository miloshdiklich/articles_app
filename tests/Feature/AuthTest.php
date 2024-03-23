<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (){
	$this->roleId = rand(1, 2);
	$this->user = \App\Models\User::factory()->create([
		'password' => bcrypt('password123'),
		'role_id' => $this->roleId
	]);
});

test('user can log in to dashboard', function () {
	
	$this->postJson('/api/login', [
		'email' => $this->user->email,
		'password' => 'password123'
	]);
	
	$this->assertAuthenticated();
	
});

test('auth user can log out', function () {
	$this->actingAs($this->user);
	$this->assertAuthenticatedAs($this->user);
	
	$this->postJson('/api/logout');
	$this->assertGuest('web');
});

test('non auth user is unauthorized to log out', function () {
	$this->assertGuest('web');
	$this->postJson('/api/logout')
		->assertUnauthorized();
});
