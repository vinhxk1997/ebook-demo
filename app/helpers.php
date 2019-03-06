<?php

if (! function_exists('get_avatar')) {
    function get_avatar($user, $size = null) {
        $image = config('app.avatar_path') . ($user->avatar ?? config('app.default_avatar'));
        $sizes = config('app.avatar_sizes');
        if (! ($size && in_array($size, $sizes))) {
            $size = current($sizes);
        }
        $image = preg_replace('/\.([a-z]+)/', '_' . $size . '.$1', $image);

        return asset($image);
    }
}

if (! function_exists('get_user_cover')) {
    function get_user_cover($user, $size = 0) {
        $image = config('app.user_cover_path') . ($user->cover_image ?? config('app.user_default_cover'));
        $sizes = config('app.user_cover_sizes');
        if (! ($size && isset($sizes[$size]))) {
            $size = current($sizes);
        }
        $image = preg_replace('/\.([a-z]+)/', '_' . implode('x', $size) . '.$1', $image);

        return  asset($image);
    }
}

if (! function_exists('get_story_cover')) {
    function get_story_cover($story, $size = 0) {
        $image = config('app.story_cover_path') . ($story->cover_image ?? config('app.story_default_cover'));
        $sizes = config('app.story_cover_sizes');
        if (! ($size && isset($sizes[$size]))) {
            $size = current($sizes);
        } else {
            $size = $sizes[$size];
        }
        $image = preg_replace('/\.([a-z]+)/', '_' . implode('x', $size) . '.$1', $image);

        return  asset($image);
    }
}
