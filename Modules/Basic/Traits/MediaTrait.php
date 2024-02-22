<?php

namespace Modules\Basic\Traits;

use Illuminate\Database\Eloquent\Collection;

trait MediaTrait
{
    public function media_move($file, $file_name, $imageName, $path)
    {
        if(!\File::isDirectory(public_path($path . '/' . $file_name)))
        {
            \File::makeDirectory(public_path($path . '/' . $file_name), 0777, true, true);
        }
        file_put_contents(public_path($path . '/' . $file_name . '/' . $imageName), $file);
    }

    public function media_upload($data, $request, $fileNameServer, $path, $type)
    {
        if(isset($request->$type) && !empty($request->$type))
        {
            foreach($request->$type as $media)
            {
                $this->upload($media, $data, $fileNameServer, $path, $type);
            }
        }
    }

    public function upload($media, $data, $fileNameServer, $path, $type)
    {
        $image_type = $media['type'];
        $image_base64 = base64_decode($media['file']);
        $fileName = time() . '_' . random_int(0, 100) . '.' . $image_type;
        $file = $data->media()->create(['file' => $fileName, 'type' => $type]);
        !$file->file ?: $this->media_move($image_base64, $fileNameServer, $fileName, $path);
    }

    public function checkMediaDelete($data, $request, $type)
    {
        if(isset($request->$type) && !empty($request->$type))
        {
            if($data->$type)
            {
                if($data->$type instanceof Collection)
                {
                    foreach($data->$type as $datas)
                    {
                        $datas->delete();
                    }
                }else
                {
                    $data->$type->delete();
                }
            }
        }
    }
}
