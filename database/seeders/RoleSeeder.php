<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
	public function run(): void
	{
		\DB::table('roles')->truncate();
		
		Role::insert([
			[
				'name' => 'author'
			],
			[
				'name' => 'reviewer'
			]
		]);
	}
}
