<?php

namespace App\Database\Seeds;

use App\Models\BreedsModel;
use CodeIgniter\Database\Seeder;

class BreedsSeeder extends Seeder
{
    public function run()
    {
        // dogs
		$model = new BreedsModel();
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.thedogapi.com/v1/breeds',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'x-api-key: '.env("key.thedogapi")
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$breeds_json = json_decode($response, true);

		foreach($breeds_json as $breed){
			$new_breed = [
				"pet" => "dog",
				"name" => $breed["name"]
			];

			$model->save($new_breed);
		}

		// cats
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.thecatapi.com/v1/breeds',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'x-api-key: '.env("key.thecatapi")
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$breeds_json = json_decode($response, true);

		foreach($breeds_json as $breed){
			$new_breed = [
				"pet" => "cat",
				"name" => $breed["name"]
			];

			$model->save($new_breed);
		}
    }
}
