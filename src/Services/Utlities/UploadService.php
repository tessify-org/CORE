<?php

namespace Tessify\Core\Services\Utilities;

use Storage;
use Illuminate\Http\UploadedFile;

class UploadService
{
    /**
     * Upload
     *
     * @param       UploadedFile    The file we're uploading
     * @param       String          Path to upload the file to relative to the public folder        example: "images/awesomesauce" so no "/" suffix, defaults to root directory "storage/app/public"
     * @param       String          The desired name of the file (without extension)
     * @param       String          The storage filesystem to upload the file to
     * @return      String          Relative path to the uploaded file
     */
    public function upload(UploadedFile $file, $upload_path = null, $file_name = null, $file_system = "public")
    {
        // Set default path to the root directory of public storage.
        if (is_null($upload_path)) $upload_path = "";

        // Create the target directory if it does not exist yet.
        if (!Storage::exists($upload_path)) Storage::makeDirectory($upload_path);

        // If no file name was specified; move the file and let laravel generate a random name.
        if (is_null($file_name))
        {
            $path = $file->store($upload_path, $file_system);
        }
        // If a file name was specified; move the file using the received name.
        else
        {
            $path = $file->storeAs($upload_path."/".$file_name,  $file_system);
        }

        // Return the uploaded file's final path relative to the storage directory to be saved in the database.
        // By using this format we can get an absolute path to the asset using the asset('path') helper in our views.
        return "storage/" . $path;
    }

    /**
     * Generate file name
     * 
     * @param       String          The extension the generated file name should have
     * @param       String          The file name without the extension (in case we just want append ext)
     * @return      String
     */
    public function generateFileName($extension, $file_name = null)
    {
        // If no file name was specified; generate one
        if (is_null($file_name))
        {
            $file_name = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 50), 1).substr(md5(time()), 1);
        }
        
        // Return the file name incl. it's extension
        return $file_name . "." . $extension;
    }
}