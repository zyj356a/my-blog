<?php
/*
 * 返回可读性更好的文件尺寸
 */

function human_filesize($bytes, $decimals=2)
{
    $size = ['B','kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) -1) /3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).@$size[$factor];
}

/*
 * 判断文件的MIME类型是否为图片
 */

function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}

/*
 * return "checked" if true
 */

function checked($value)
{
    return $value ? 'checked' : '';
}

/*
 * return image url for headers
 */

//function page_image($value = null)
//{
//    if(empty($value))
//    {
//        $value = config('blog.page_image');
//    }
//    if(! starts_with($value, 'http') && $value[0] !== '/')
//    {
//        $value = config('blog.uploads.webpath'). '/' .$value;
//    }
//
//    return $value;
//}
function page_image($value = null)
{
    if(empty($value))
    {
        $value = config('blog.page_image');
    }
    if(! starts_with($value, 'http') && $value[0] !== '/')
    {
        $value =  asset('image' . '/' .$value);
    }

    return $value;
}
