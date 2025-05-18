<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Resource::create([
            'title' => 'Guía para manejar la ansiedad',
            'type' => 'article',
            'category' => 'ansiedad',
            'content_url' => '/storage/resources/ansiedad-1.pdf',
        ]);
    }
}
