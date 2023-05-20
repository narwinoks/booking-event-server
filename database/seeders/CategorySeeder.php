<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = new Category();
        $model->name = "Music";
        $model->slug = Str::slug("Music");
        $model->save();

        $model = new Category();
        $model->name = "Sport";
        $model->slug = Str::slug("Sport");
        $model->save();

        $model = new Category();
        $model->name = "Exhibition";
        $model->slug = Str::slug("exhibition");
        $model->save();

        $model = new Category();
        $model->name = "Seminar";
        $model->slug = Str::slug("Seminar");
        $model->save();

        $model = new Category();
        $model->name = "Theater";
        $model->slug = Str::slug("Theater");
        $model->save();
    }
}
