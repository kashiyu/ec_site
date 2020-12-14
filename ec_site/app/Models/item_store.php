<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class item_store extends Model{
    //use HasFactory;

    //ECトップページ用全アイテム取得
    public function items(){

        //アイテム一覧select文
        $items = DB::select("SELECT item.id, img, name, price, stock 
        FROM item JOIN stock
        ON Item.id = stock.item_id
        WHERE status = '1'");

        return $items;
    }
}
