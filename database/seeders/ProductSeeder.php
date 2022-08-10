<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $product = [
            [
                'image'          =>  'avatar.png',
                'name'          =>  'baju',
                'description'   =>  'baju tidur',
                'price'         =>  '400000',
            ],
            [
                'image'          =>  'avatar.png',
                'name'          =>  'celana',
                'description'   =>  'celana jeans',
                'price'         =>  '200000',
            ],
        ];



        foreach ($product as $key => $value) {

            Product::create($value);

        }
    }
}
