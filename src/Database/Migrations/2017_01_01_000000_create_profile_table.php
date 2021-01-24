<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;


class CreateProfileTable extends Migration {
	
	protected $connection = 'oka6_admin';
	
	public function up() {
		Schema::connection($this->connection)
			->table('profile', function (Blueprint $collection) {
				$collection->background(["id"]);
				$collection->background(["name"]);
				$collection->background(["resources"]);
				$collection->background(["type"]);
				$collection->background(["created_at"]);
				$collection->background(["updated_at"]);
			});
	}
	
	public function down() {
		Schema::connection($this->connection)->dropIfExists('profile');
	}
}
