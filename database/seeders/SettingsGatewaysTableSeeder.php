<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsGatewaysTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        
        \DB::table('settings_gateways')->insert(array (
            0 => 
            array (
                'id' => 1,
                'is_paypal' => 1,
                'is_stripe' => 1,
            ),
        ));
        
        
    }
}