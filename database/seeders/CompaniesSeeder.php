<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        try {
            Helper::syncCompanies();
        } catch (\Exception $e) {
            $this->command->error('Error: ' . $e->getMessage() . '\n');
        }
    }
}
