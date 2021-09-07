<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IncomingMaterial extends Migration
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
			'created_by' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'material_id' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'work_id' => [
				'type' => 'INT',
				'constraint' => '15',
			],
			'evidence' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'status' => [
				'type' => 'INT',
				'constraint' => '5',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('incoming_material');
	}

	public function down()
	{
		$this->forge->dropTable('incoming_material');
	}
}
