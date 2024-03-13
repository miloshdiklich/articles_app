<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
	public function run(): void
	{
		Schema::disableForeignKeyConstraints();
		\DB::table('users')->truncate();
		Schema::enableForeignKeyConstraints();
		
		User::insert([
			[
				'name' => 'Jon Doe',
				'email' => 'jd@mail.com',
				'password' => bcrypt('Test123'),
				'role_id' => 1,
				'created_at' => \Date::now(),
				'updated_at' => \Date::now()
			],
			[
				'name' => 'Jane Smith',
				'email' => 'js@mail.com',
				'password' => bcrypt('Test123'),
				'role_id' => 1,
				'created_at' => \Date::now(),
				'updated_at' => \Date::now()
			],
			[
				'name' => 'Alex Jackson',
				'email' => 'aj@mail.com',
				'password' => bcrypt('Test123'),
				'role_id' => 2,
				'created_at' => \Date::now(),
				'updated_at' => \Date::now()
			],
			[
				'name' => 'Karen Fritz',
				'email' => 'kf@mail.com',
				'password' => bcrypt('Test123'),
				'role_id' => 2,
				'created_at' => \Date::now(),
				'updated_at' => \Date::now()
			]
		]);
	}
}
