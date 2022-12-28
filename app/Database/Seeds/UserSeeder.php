<?php

namespace App\Database\Seeds;

use App\Models\UsersModel;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            "email_address" => "test@pettag.com",
            "password" => "dsadsadsa",
            "phone_number" => "+48 123 456 789",
        ];

        $model = new UsersModel();

        $model->save($data);
    }
}
