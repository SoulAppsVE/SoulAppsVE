<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Client;

class CustomerSeeder extends Seeder {


	public function run(){
			
		\Eloquent::unguard();


        \DB::table('clients')->truncate();

        $client = Client::create(
            array(
                'first_name' => 'Comprador',
                'last_name' => '',
                'company_name' => 'N/A',
                'phone' => 'N/A',
                'address' => 'N/A',
                'client_type' => 'customer',
            )
        );

        $client = Client::create(
            array(
                'first_name' => 'Proveedor',
                'last_name' => '',
                'company_name' => 'N/A',
                'phone' => 'N/A',
                'address' => 'N/A',
                'client_type' => 'purchaser',
            )
        );       

    }

}