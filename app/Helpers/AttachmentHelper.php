<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class AttachmentHelper
{
    public function privateStore($files, $folder)
    {
        $newFileNames = [];
        foreach ($files as $file) {
            $name = $this->createFileName($file);
            $file->storeAs($folder, $name);
            $newFileNames[] = $name;
        }
        return $newFileNames;
    }
    public function privateIconStore($file, $folder)
    {     
        $name = $this->createFileName($file);
        $path = public_path()."/$folder";
        $uplaod = $file->move($path,$name);
        $newFileNames = $name;
        return $newFileNames;
    }

    public function createFileName($file)
    {
        $name = time() . rand(100, 1000) . '.' . $file->extension();
        return $name;
    }

    public function privateDownload($path, $filename)
    {
        $path = rtrim($path, '/');
        $file = sprintf("%s/%s", $path, $filename);
         return Storage::download($file);
    }

}
