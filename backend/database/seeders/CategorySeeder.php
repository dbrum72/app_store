<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder {

    public function run(): void {

        Category::create(['name' => 'Hardwares', 'tree' => 'Hardwares']);
        Category::create(['name' => 'Softwares', 'tree' => 'Softwares']);
        Category::create(['name' => 'HDs', 'tree' => 'Hardwares->Hds', 'parent_id' => '1']);
        Category::create(['name' => 'SSDs', 'tree' => 'Hardwares->SSDs', 'parent_id' => '1']);
        Category::create(['name' => 'Memórias', 'tree' => 'Hardwares->Memórias', 'parent_id' => '1']);
        Category::create(['name' => 'Teclados', 'tree' => 'Hardwares->Teclados', 'parent_id' => '1']);
        Category::create(['name' => 'S.O.', 'tree' => 'Softwares->S.O.', 'parent_id' => '2']);
        Category::create(['name' => 'Periféricos', 'tree' => 'Periféricos']);
    }   
}
