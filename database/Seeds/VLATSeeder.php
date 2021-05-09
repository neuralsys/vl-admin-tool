<?php
namespace Vuongdq\VLAdminTool\Database\Seeds;
use Illuminate\Database\Seeder;

class VLATSeeder extends Seeder
{
    /**
     * Run the database Seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MenuTableSeeder::class);
        $this->call(LangTableSeeder::class);
        $this->call(TranslationFileTableSeeder::class);
        $this->call(TranslationTableSeeder::class);
    }
}
