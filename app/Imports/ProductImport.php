<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Import the Storage facade

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Assuming your Excel file has a column named 'image'
        $imagePath = Storage::disk('public')->put('products', $row['image']);

        return new Product([
            'name' => $row['name'],
            'slug' => Str::slug($row['slug']),
            'description' => $row['description'],
            'image' => $imagePath,
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'brand_id' => $row['brand_id'], // Assuming this is provided in the Excel file
        ]);
    }
}
