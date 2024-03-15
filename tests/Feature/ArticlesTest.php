<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('author can post an article', function () {
	
	$role = \App\Models\Role::factory()->create([
		'name' => 'author'
	]);
	
	$user = \App\Models\User::factory()->create([
		'name' => 'Jon Doe',
		'email' => 'jd@mail.com',
		'role_id' => $role->id
	]);
	
	$article = \App\Models\Article::factory()->create();
	
	$response = $this->postJson('/api/articles', [
		'title' => $article->title,
		'description' => $article->description,
		'email' => $user->email
	]);
	
	$response
		->assertStatus(201)
		->assertJson([
			'data' => [
				'title' => $article->title,
				'description' => $article->description
			]
		]);
});

test('author can see their articles with reviews', function (){
	$role = \App\Models\Role::factory()->create([
		'name' => 'author'
	]);
	
	$user = \App\Models\User::factory()->create([
		'name' => 'Jon Doe',
		'email' => 'jd@mail.com',
		'role_id' => $role->id
	]);
	
	$articles = \App\Models\Article::factory()
		->count(2)
		->hasAttached($user)
		->create();
	
	$this->actingAs($user);
	
	$this->get('/api/articles')
		->assertStatus(200)
		->assertJson(fn(\Illuminate\Testing\Fluent\AssertableJson $json) =>
			$json->hasAll(['data', 'message'])
		);
	
});

test('reviewer can see posted articles with pending status', function () {

	$role = \App\Models\Role::factory()->create([
		'name' => 'reviewer'
	]);

	$user = \App\Models\User::factory()->create([
		'name' => 'Karen Fritz',
		'email' => 'kf@mail.com',
		'password' => bcrypt('password123'),
		'role_id' => $role->id
	]);

	$this->actingAs($user);

	$response = $this->get('/api/articles/review');

	$response
		->assertStatus(200)
		->assertJsonIsArray('data');

});
