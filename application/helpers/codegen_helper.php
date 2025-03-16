<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


function p($a)
{
    echo '<pre>';
    print_r($a);
    echo '</pre>';

}
function v($a)
{
    echo '<pre>';
    var_dump($a);
    echo '</pre>';

}


function clean_header($array){
    $CI = get_instance();
    $CI->load->helper('inflector');
    foreach($array as $a){
        $arr[] = humanize($a);
    }
    return $arr;
}

function url_product_primary($image)
{
    if (empty($image)) {
        return base_url('uploads/img_productos/default.png');
    }
    if (strpos($image, 'http://') !== false || strpos($image, 'https://') !== false) {
        return $image;
    }
    return base_url('uploads/img_productos/' . $image);
}

function url_product_gallery($image)
{
    if (empty($image)) {
        return base_url('uploads/img_productos/default.png');
    }
    if (strpos($image, 'http://') !== false || strpos($image, 'https://') !== false) {
        return $image;
    }
    return base_url('uploads/img_productos/galeria/' . $image);
}