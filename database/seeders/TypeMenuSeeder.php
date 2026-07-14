<?php

namespace Database\Seeders;

use App\Models\TypeMenu;
use Illuminate\Database\Seeder;

class TypeMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['id' => 1, 'name' => 'Menú 1'],
            ['id' => 2, 'name' => 'Menú 2'],
            ['id' => 3, 'name' => 'Naturista'],
            ['id' => 4, 'name' => 'Menú Especial'],
        ];

        foreach ($types as $type) {
            TypeMenu::updateOrCreate(
                [
                    'id' => $type['id'],
                ],
                [
                    'name' => $type['name'],
                ]
            );
        }
    }
}
