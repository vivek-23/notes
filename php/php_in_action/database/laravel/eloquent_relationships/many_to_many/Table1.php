<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class Table1 extends Model{

    public $primaryKey = "id";
    public $timestamps = false;  
    protected $table = "table1";

    public function table2(){
        return $this->belongsToMany('App\Table2','table3','user_id','answer_id');
        /* 'table3' is a pivot table. Rest 2 parameters- first is foreign key present in table3 of current model, 
        second is foreign key present in table3 of the model we are joining with*/
    }
}
