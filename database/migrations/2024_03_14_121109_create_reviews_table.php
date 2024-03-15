<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('reviews', function (Blueprint $table) {
			$table->id();

			$table->foreignIdFor(\App\Models\Article::class);
			$table->foreignIdFor(\App\Models\User::class);
			
			$table->tinyInteger('approved')->nullable();
			
			$table->timestamps();
		});
	}
	
	public function down(): void
	{
		Schema::dropIfExists('reviews');
	}
};
