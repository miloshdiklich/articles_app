<?php

use function Pest\Laravel\get;

it('returns successful response for home page', function (){
	get('/')
		->assertStatus(200);
});
