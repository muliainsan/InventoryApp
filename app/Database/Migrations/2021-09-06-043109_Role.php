<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Role extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'deleted_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'role' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('role');
	}

	public function down()
	{
		$this->forge->dropTable('role');
	}
}
