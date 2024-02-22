<?php

use Illuminate\Support\Collection;

/**
 * @Target this file to make function to help about media for all system
 * can call it in all system
 */
/**
 * @result get image from server but
 * @param $image => image i want from server
 * @param $file_name => name file we saved in it in server
 */
function getImag($image, $file_name, $id = null)
{
    $file_name = strtolower($file_name);
    if($image instanceof Collection)
    {
        $imagesArray = [];
        foreach($image as $im)
        {
            if(isset($im))
            {
                $images = $im ? public_path('images/' . $file_name . '/' . $im->file) : "";
                if(file_exists($images) == false)
                {
                    $imagesArray[] = asset('public/images/test1.png');//image default
                }else
                {
                    $imagesArray[] = asset('public/images/' . $file_name . '/' . ($id ? $id . '/' : "") . $im->file);//image we want get it
                }
            }else
            {
                $imagesArray[] = ""; //image default
            }
        }
        return $imagesArray;
    }else
    {
        if(isset($image))
        {
            $images = $image ? public_path('images/' . $file_name . '/' . ($id ? $id . '/' : "") . $image->file) : "";
            if(file_exists($images) == false)
            {
                return ""; //image default
            }else
            {
                return asset('public/images/' . $file_name . '/' . ($id ? $id . '/' : "") . $image->file);//image we want get it
            }
        }else
        {
            return ""; //image default
        }
    }
}

/**
 * @result get files from server
 * @param $fileName => name file in server
 * @param $path => path folder in server
 * @param $fileNameServer => name folder we saved in it
 */
function getFile($fileName, $path, $fileNameServer)
{
    return asset("public/" . $path . '/' . $fileNameServer . '/' . $fileName);
}

/**
 * @result get folder name in server will search in it
 * @param $data => object will get name folder for it
 */
function getFileNameServer($data)
{
    $name = null;
    if(isset($data->category_type))
    {
        $name = strtolower(basename($data->category_type));
        if(strpos($name, '\\') !== false)
        {
            $name = explode('\\', $name);
            $name = $name[count($name) - 1];
        }
    }
    return $name ? $name . '/' . $data->category_id : null;
}

/**
 * @result get folder name in server will save in it
 * @param $model => path model
 * @param $id => id row we will save it
 */
function createFileNameServer($model, $id)
{
    $name = strtolower(basename($model));
    if(strpos($name, '\\') !== false)
    {
        $name = explode('\\', $name);
        $name = $name[count($name) - 1];
    }
    return $model ? $name . '/' . $id : null;
}
