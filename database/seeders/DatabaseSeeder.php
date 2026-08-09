<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(AdvertisementsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(LevelsTableSeeder::class);
        $this->call(NewsletterSettingsTableSeeder::class);
        $this->call(SettingsAuthTableSeeder::class);
        $this->call(SettingsCommissionTableSeeder::class);
        $this->call(SettingsCurrencyTableSeeder::class);
        $this->call(SettingsFooterTableSeeder::class);
        $this->call(SettingsGatewaysTableSeeder::class);
        $this->call(SettingsGeneralTableSeeder::class);
        $this->call(SettingsMediaTableSeeder::class);
        $this->call(SettingsPublishTableSeeder::class);
        $this->call(SettingsSecurityTableSeeder::class);
        $this->call(SettingsSeoTableSeeder::class);
        $this->call(SettingsWithdrawalTableSeeder::class);
    }
}
