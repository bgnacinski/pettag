<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Breeds extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "int",
                "constraint" => 11,
                "auto_increment" => true,
                "unique" => true
            ],
            "pet" => [
                "type" => "varchar",
                "constraint" => 50
            ],
            "name" => [
                "type" => "varchar",
                "constraint" => 255,
                "unique" => true
            ]
        ]);

        $this->forge->addPrimaryKey("id");

        $this->forge->createTable("breeds");
    }

    public function down()
    {
        $this->forge->dropTable("breeds");
    }
}
