<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use AWS, Config, Storage;
use App\Models\{UserFile, User};
use Aws\S3\MultipartUploader;

class FileController extends Controller{
    function __construct(){
        $this->s3 = AWS::createClient('s3');
    }

    public function upload(Request $request){
        $v = Validator::make($request->all(),[
            'files' => 'required|array',
            'files.*' => 'file',
            'isProfilePic' => 'required|in:0,1'        
        ],[
            'isProfilePic' => 'isProfilePic is required and can either be 0 or 1.'
        ]);

        if($v->fails()){
            return response()->json(['success' => false, 'message' => $v->errors()->first()]);
        }

        $files = $request->file('files');
        $user = User::find(1);

        $results = [];

        $uploadsDir = storage_path('app'. DIRECTORY_SEPARATOR. 'user_uploads');

        if(!file_exists($uploadsDir)){
            mkdir($uploadsDir, 0775);// make the dir with appropriate permissions
        }

        $newDirPath = storage_path('app'. DIRECTORY_SEPARATOR. 'user_uploads' . DIRECTORY_SEPARATOR . $user->id);

        if(!file_exists($newDirPath)){
            mkdir($newDirPath, 0775);// make the dir with appropriate permissions
        }

        foreach($files as $f){
            $newFileName = microtime(true). "_" . $f->getClientOriginalName();           
            $newFilePath = $newDirPath. DIRECTORY_SEPARATOR . $newFileName;
            Storage::disk('local')->putFileAs('user_uploads/'. $user->id, $f, $newFileName);
            $res = $this->s3->putObject([
                'Bucket' => Config::get('aws.bucket'),
                'Key'    => md5('user_'. $user->id) . '/' . $f->getClientOriginalName(),
                'SourceFile' => $newFilePath,
                'ACL'    => 'public-read',
            ]);
            $results[$f->getClientOriginalName()] = $res->get('ObjectURL');
            unlink($newFilePath);
        }

        rmdir($newDirPath);// unlink the temporary user folder

        $currT = date("Y-m-d H:i:s");

        UserFile::insert(array_map(fn($r) => [
            'user_id' => 1,
            'blob_path' => $r,
            'isProfilePic' => $request->get('isProfilePic'),
            'created_at' => $currT,
            'updated_at' => $currT
        ], $results));

        return response()->json([
            'success' => true,
            'message' => 'Files uploaded successfully.',
            'file_links' => $results,
            'isProfilePic' => $request->get('isProfilePic') == '1'
        ]);
    }
}
