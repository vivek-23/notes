<?php

final class ZipFiles extends ZipArchive{
    public $path;
    public $output_zip_file;
    function __construct($file_path){
        if(!file_exists($file_path) || !is_dir($file_path)){
            throw new Exception("$file_path directory doesn't exist!");
        }
        $this->path = $file_path;
        $this->output_zip_file = "";
    } 
    
    /* 
     * @param $filename - Output file to generate
     * $param $flag - Mode to use to open the archive
     * @return true if successful. Opens the archive and sets the output file name(needed for download)
    */
    
    public function open($filename,$flag = ZipFiles::CREATE){
        $this->output_zip_file = $filename;
        return parent::open($filename,$flag);        
    }
    
    /* 
     * @return Nothing. Initiates the process of zipping.
    */
    
    public function zipAllFiles(){
        $this->readDirectory($this->path);
    }
    
    /* 
     * @param $path- path of the current directory(disk file path).
     * @param $parent_path - path of the parent directory inside the current directory(inside the zip file that is getting created).
     * @return nothing. Does the job of zipping all files in it.
    */
    
    private function readDirectory($path,$parent_path = ""){
        $directory_path = "";
        if(!empty($parent_path)){
            $directory_path = $parent_path . DIRECTORY_SEPARATOR;
        }
        $directory_path .= basename($path);
        $this->addEmptyDir($directory_path);
        foreach(array_diff(scandir($path),array(".","..")) as $each_file){
            $file_path = $path . DIRECTORY_SEPARATOR . $each_file;
            if(is_dir($file_path)){
                $this->readDirectory($file_path,$directory_path);
            }else{
                $this->addFile($file_path,$directory_path . DIRECTORY_SEPARATOR . basename($file_path));
            }            
        }
    }
    
    /* 
     * @exception throws Exception if no zip is made to be downloaded
     * @return nothing. Downloads the file on client's computer.
    */
    
    public function download(){
        if(empty($this->output_zip_file)){
            throw new Exception("There is no zip file present to download it.");
        }        
        header("Content-type:application/octet-stream");
        header("Content-Disposition:attachment;filename=zipped.zip");          
        readfile($this->output_zip_file);
        exit;
    }
}



try{
    $zip = new ZipFiles(__DIR__ . DIRECTORY_SEPARATOR . 'ZipItPlease');// path to folder supposed to be zipped
    if($zip->open("zipall.zip", ZipFiles::CREATE) !== true){
        throw new Exception("Unable to create zip file");
    }
    $zip->zipAllFiles();
    $zip->close();
    $zip->download();
}catch(Exception $ex){
    die($ex->getMessage());
}
