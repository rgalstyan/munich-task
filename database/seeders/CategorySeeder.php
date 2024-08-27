<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'title'       => 'Category 1',
                'description' => 'Category 1 description',
            ],
            [
                'title'       => 'Category 2',
                'description' => 'Category 2 description',
            ],
            [
                'title'       => 'Category 3',
                'description' => 'Category 3 description',
            ],
            [
                'title'       => 'Category 4',
                'description' => 'Category 4 description',
            ],
            [
                'title'       => 'Category 5',
                'description' => 'Category 5 description',
            ],
        ];
        DB::beginTransaction();
        foreach ($categories as $category) {
            Category::query()->create($category);
        }
        DB::commit();
    }
}
