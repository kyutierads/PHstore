<?php

namespace App\Imports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class BrandImportClass implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Brand([
            'name' => $row['name'],
            'slug' => Str::slug($row['slug']), // Generate a slug from the name
            'description' => $row['description'],
            // 'image' => $row['image'], // Make sure you handle image upload and storage
        ]);
    }
}

