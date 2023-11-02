<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Alimentos',
            ],
            [
                'name' => 'Bebidas',
            ],
            [
                'name' => 'Higiene',
            ],
            [
                'name' => 'Limpeza',
            ],
            [
                'name' => 'Eletrônicos',
            ],
            [
                'name' => 'Eletrodomésticos',
            ],
            [
                'name' => 'Móveis',
            ],
            [
                'name' => 'Roupas',
            ]
        ]);
    }
}