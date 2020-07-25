<?php
use App\Table1 as Table1;
use App\Table2 as Table2;

Route::get('/many2many',function(){
    echo "<pre>";
    $rows = Table1::all();
    foreach($rows as $each_row){
        $table2_columns = $each_row->table2->toArray();
        print_r($table2_columns);
        echo "***************************************<br/>";
    }

    echo "#########################################################################################<br/>";

    $rows = Table2::all();
    foreach($rows as $each_row){
        $table1_columns = $each_row->table1->toArray();
        print_r($table1_columns);
        echo "***************************************<br/>";
    }
});
