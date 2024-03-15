<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can log in to dashboard', function () {
	
	$roleId = rand(1, 2);
	
	$user = \App\Models\User::factory()->create([
		'name' => 'Karen Fritz',
		'email' => 'kf@mail.com',
		'password' => bcrypt('password123'),
		'role_id' => $roleId
	]);
	
	$this->postJson('/api/login', [
		'email' => $user->email,
		'password' => 'password123'
	]);
	
	$this->assertAuthenticated();
	
});
