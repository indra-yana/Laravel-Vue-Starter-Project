<?php

namespace App\Src\Services\Upload;

use App\Src\Base\IBaseService;
use Storage;
use Illuminate\Support\Str;

class UploadService implements IBaseService {

    public function __construct() 
    {
        
    }

    public static function getInstance()
    {
        return new static();
    }

    public function formatResult($model)
    {
        return [];
    }
    
    public function createFileName($prefix = "", $file) 
    {
        return strtolower(preg_replace('/[\W_]+/', '', $prefix) .'-' .date('Ymd-His') .'-' .Str::random(16) .'.' .$file->getClientOriginalExtension());
    }

    public function getCleanName($filename)
    {
        return preg_replace("/[^a-zA-Z0-9-_. ]/", "", $filename);
    }
    
    public function upload(array $data)
    {
        $file = @$data['file'];
        if (!empty($file)) {
            $filename = $this->createFileName($data["prefix"] ?? "", $file);
            Storage::putFileAs("{$data["path"]}", $file, $filename);

            if (isset($data["old_file"])) {
                Storage::delete($data["old_file"]);
            }

            return $filename;
        }

        return null;
    }

    public function delete($oldFile)
    {
        return Storage::delete($oldFile);
    }

    public function preview($path, $defaultImage = null) {
        if (Storage::exists($path)) {
            return Storage::response($path);
        }
        
        return response()->file($defaultImage ?? public_path("images/user.png"));
    }
}