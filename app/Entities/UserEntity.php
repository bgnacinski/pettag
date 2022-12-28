<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UserEntity extends Entity
{
    protected $datamap = [
        "id" => "id",
        "email_address" => "email_address",
        "password" => "password",
        "phone_number" => "phone_number",
        "auth_key" => "auth_key",
        "permission_level" => "permission_level",
        "created_at" => "created_at"
    ];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        "id" => "int"
    ];
}
