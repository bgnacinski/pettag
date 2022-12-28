<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            "email_address" => [
                "type" => "varchar",
                "constraint" => 512,
                "unique" => true
            ],
            "password" => [
                "type" => "text"
            ],
            "phone_number" => [
                "type" => "varchar",
                "constraint" => 20,
                "null" => true
            ],
            "auth_key" => [
                "type" => "varchar",
                "constraint" => 512
            ],
            "permission_level" => [
                "type" => "enum",
                "constraint" => ["regular", "privileged"]
            ],
            "created_at" => [
                "type" => "varchar",
                "constraint" => 50
            ],
            "updated_at" => [
                "type" => "varchar",
                "constraint" => 50
            ]
        ]);

        $this->forge->addPrimaryKey("id");

        $this->forge->createTable("users");
    }

    public function down()
    {
        $this->forge->dropTable("users");
    }
}
