<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Material extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'created_at'       => [
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
			'work_id' => [
				'type' => 'INT',
				'constraint' => 5,
				'null' => true,
			],
			'material_name' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'total' => [
				'type' => 'INT',
				'constraint' => '10',
			],
		]);
		$this->forge->addKey('Id', true);
		$this->forge->createTable('menu');
	}

	public function down()
	{
		$this->forge->dropTable('menu');
	}
}
