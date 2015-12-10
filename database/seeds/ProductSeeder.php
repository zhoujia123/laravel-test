<?php

/**
 * Created by PhpStorm.
 * User: zhoujia05
 * Date: 2015/12/2
 * Time: 9:46
 */
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Product;

class ProductSeeder extends Seeder {


    public function run()
    {
        DB::table('products')->delete();

        for($i = 0; $i < 5; $i++){

            Product::create([
                'body' => '商品'.$i,
                'detail' => '这是一个消费产品'.$i,
                'total_fee' => $i,
            ]);
        }
    }


}