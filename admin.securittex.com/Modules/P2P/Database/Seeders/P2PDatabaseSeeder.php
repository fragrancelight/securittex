<?php

namespace Modules\P2P\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\P2P\Database\Seeders\AdminSettingSeederTableSeeder;

class P2PDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSettingSeederTableSeeder::class);
    }
}
