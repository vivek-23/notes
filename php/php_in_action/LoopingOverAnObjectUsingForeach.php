<?php

class ArrayValues implements Iterator{
    private $values,$keys,$current_pointer = -1;
    function __construct($arr){
        $this->values = $arr;
        $this->keys = array_keys($arr);
        $this->current_pointer = 0;
    }

    public function current(){
        return $this->values[$this->keys[$this->current_pointer]];
    } 

    public function key(){
        return $this->keys[$this->current_pointer];
    }

    public function next(){
        $this->current_pointer++;
    }

    public function rewind(){
        $this->current_pointer = 0;
    }

    public function valid(){
        return isset($this->keys[$this->current_pointer]);
    }
}


$obj = new ArrayValues([1,2,3,4,5,6,77,88,681478]);

foreach($obj as $each_key => $each_value){
    echo $each_key," ",$each_value,"<br/>";
}
