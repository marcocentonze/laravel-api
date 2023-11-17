<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Fullstack', 'Frontend', 'Backend', 'API'];

        foreach ($types as $typeName) {
            Type::firstOrCreate([
                'slug' => Str::slug($typeName, '-')
            ], [
                'name' => $typeName
            ]);
        }
    }
}
