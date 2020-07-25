<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    protected $primaryKey = 'id';
    protected $table = 'category';
    
    public function childCategories(){
        return $this->hasMany('App\Models\Category','parent_id','id');
    }
    
    public function parentCategory(){
        return $this->belongsTo('App\Models\Category','parent_id','id');
    }    
}

// in the code this would be accessed like foreach($cat->childCategories as $child_cat) and $cat->parentCategory->name etc.
