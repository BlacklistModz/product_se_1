<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductModel extends Model
{
    protected $table = "product";
    protected $fillable = [ "name" , "detail" , "price" , "type" , "store" ];
    public $primarykey = "id";

    public function lists($request){
        $query = DB::table( $this->table )
                    ->select("{$this->table}.*", "product_type.name AS typename", "store.name AS storename")
                    ->leftjoin('product_type', "{$this->table}.type", "=", "product_type.id")
                    ->leftjoin('store', "{$this->table}.store", "=", "store.id");

        if( !empty($request->search) ){
            $query->where(function($q) use ($request) {
                $q->where("{$this->table}.name", 'LIKE', "%{$request->search}%");
                $q->orWhere("{$this->table}.price", 'LIKE', "%{$request->search}%");
            });
        }

        if( !empty($request->type) ){
            $query->where("{$this->table}.type", '=', $request->type);
        }
        if( !empty($request->store) ){
            $query->where("{$this->table}.store", '=', $request->store);
        }
        return $query->paginate( $request->limit );
    }
}