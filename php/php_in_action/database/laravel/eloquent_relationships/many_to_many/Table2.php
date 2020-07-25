<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class Table2 extends Model{

    public $primaryKey = "id";
    public $timestamps = false;  
    protected $table = "table2";

	public function table1(){
		return $this->belongsToMany('App\Table1','table3','answer_id','user_id'); 
    /* 'table3' is a pivot table. Rest 2 parameters- first is foreign key present in table3 of current model, 
        second is foreign key present in table3 of the model we are joining with*/
	}
}
