<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء بيانات تجريبية للـ About
        About::create([
            'name' => 'About Us',
            'position' => 'About Us',
            'title' => 'About Us',
            'description' => 'About Us',
            'image' => '/uploads/store/abouts/about-image.jpg',
            'details' => [
                'vision' => 'To be the leading company in the field of technology',
                'mission' => 'To provide innovative and exceptional solutions',
                'values' => ['Innovation', 'Quality', 'Reliability', 'Transparency']
            ]
        ]);
    }
} 