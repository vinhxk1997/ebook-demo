<?php

use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;

if (!function_exists('get_avatar')) {
    function get_avatar($user, $size = null)
    {
        $image = config('app.avatar_path') . ($user->avatar ?? config('app.default_avatar'));
        $sizes = config('app.avatar_sizes');
        if (!($size && isset($sizes[$size]))) {
            $size = current($sizes);
        } else {
            $size = $sizes[$size];
        }
        $image = preg_replace('/\.([a-z]+)$/i', '_' . $size . '.$1', $image);

        return asset($image);
    }
}

if (!function_exists('get_user_cover')) {
    function get_user_cover($user, $size = 0)
    {
        $image = config('app.user_cover_path') . ($user->cover_image ?? config('app.user_default_cover'));
        $sizes = config('app.user_cover_sizes');
        if (!($size && isset($sizes[$size]))) {
            $size = current($sizes);
        } else {
            $size = $sizes[$size];
        }
        $image = preg_replace('/\.([a-z]+)$/i', '_' . implode('x', $size) . '.$1', $image);

        return asset($image);
    }
}

if (!function_exists('get_story_cover')) {
    function get_story_cover($story, $size = 0)
    {
        $image = config('app.story_cover_path') . ($story->cover_image ?? config('app.story_default_cover'));
        $sizes = config('app.story_cover_sizes');
        if (!($size && isset($sizes[$size]))) {
            $size = current($sizes);
        } else {
            $size = $sizes[$size];
        }
        $image = preg_replace('/\.([a-z]+)$/i', '_' . implode('x', $size) . '.$1', $image);

        return asset($image);
    }
}

if (!function_exists('createObject')) {
    function createObject($data = [])
    {
        $object = app()->make('stdClass');
        
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $object->{$key} = $value;
            }
        }

        return $object;
    }
}

if (!function_exists('processTags')) {
    function processTags($tags)
    {
        $tags = explode(',', $tags);
        $tags = array_map('trim', $tags);
        $tags = array_map('mb_strtolower', $tags);
        $tags = array_filter($tags, function ($tag) {
            return mb_strlen($tag) >= 3 && preg_match('/^[[:alnum:]\s]+$/ui', $tag);
        });

        return $tags;
    }
}

if (!function_exists('removeFile')) {
    function removeFile($file, $path, $sizes)
    {
        try {
            foreach ($sizes as $size) {
                if (is_array($size)) {
                    $size = implode('x', $size);
                }
                $image = preg_replace('/\.([a-z]+)$/i', '_' . $size . '.$1', $file);
                
                unlink($path . $image);
            }
        } catch (\Exeption $e) {
            return false;
        }
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($file, $path, $sizes, $extension = null)
    {
        $fileName = microtime(true);
        if ($file instanceOf UploadedFile) {
            $fileExtension = $file->getClientOriginalExtension();
            $filePath = $file->getRealPath();
        } else {
            $fileExtension = 'jpeg';
            $filePath = $file;
        }

        try {
            $image = Image::make($filePath);
            $image->backup();
            $first = true;
            foreach ($sizes as $size) {
                if (is_array($size)) {
                    [$width, $height] = $size;
                    $size = implode('x', $size);
                } else {
                    $width = $height = $size;
                }
                $fileSaveName = $fileName . '_' . $size . '.' . $fileExtension;
                if ($first) {
                    $first = false;
                } else {
                    $image->reset();
                }
                $image->fit($width, $height);
                $image->save($path . $fileSaveName);
            }
            
            return $fileName . '.' . $fileExtension;
        } catch (\Exeption $e) {
            return false;
        }
    }
}
