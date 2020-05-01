<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductTypeModel extends Model
{
    protected $table = "product_type";
    protected $fillable = ["name"];
    public $primarykey = "id";

    public function lists($request){
        $query = DB::table( $this->table );
        if( !empty($request->search) ){
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
        return $query->paginate( $request->limit );
    }
}
