<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration {
	
	protected $connection = 'oka6_admin_session';
	
	public function up() {
		Schema::connection($this->connection)
			->table('sessions', function (Blueprint $collection) {
				$collection->background(["id"]);
				$collection->background(["user_id"]);
				$collection->background(["ip_address"]);
				$collection->background(["last_activity"]);
				$collection->background(["created_at"]);
				$collection->background(["updated_at"]);
			});
		
	}
	
	public function down() {
		Schema::connection($this->connection)->dropIfExists('sessions');
	}
}
