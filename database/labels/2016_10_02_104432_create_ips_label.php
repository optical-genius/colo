<?php

use Vinelab\NeoEloquent\Schema\Blueprint;
use Vinelab\NeoEloquent\Facade\Neo4jSchema;
use Vinelab\NeoEloquent\Migrations\Migration;

class CreateIpsLabel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Neo4jSchema::label('Ip', function(Blueprint $label) {
			$label->unique('id');
			$label->index('ip_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Neo4jSchema::label('Ip', function(Blueprint $label) {
			$label->dropUnique('id');
			$label->dropIndex('ip_name');
		});
	}

}
