<?php

use Vinelab\NeoEloquent\Schema\Blueprint;
use Vinelab\NeoEloquent\Facade\Neo4jSchema;
use Vinelab\NeoEloquent\Migrations\Migration;

class CreateHostsLabel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Neo4jSchema::label('Host', function(Blueprint $label) {
			$label->unique('id');
			$label->index('host_name');
			$label->index('host_definition');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Neo4jSchema::label('Host', function(Blueprint $label) {
			$label->dropUnique('id');
			$label->dropIndex('host_name');
			$label->dropIndex('host_definition');
		});
	}

}
