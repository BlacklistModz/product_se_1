<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class StoreModel extends Model
{
    protected $table = "store";
    protected $fillable = [ "name" , "address" ];
    public $primarykey = "id";

    public function lists( $ops ){
    	$sth = DB::table( $this->table );
    	if( !empty($ops->search) ){
            $sth->where('name', 'LIKE', "%{$ops->search}%");
            $sth->orWhere('address', 'LIKE', "%{$ops->search}%");
        }
        return $sth->paginate( $ops->limit );
    }
}
