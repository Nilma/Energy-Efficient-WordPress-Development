<?php
/*
Plugin Name: My Image Compressor
Plugin URI: https://aeeriksen.com
Description: An image compressor plugin for WordPress.
Version: 1.0.0
Author: Andreas E. Eriksen
Author URI: https://aeeriksen.com
License: GPL2
*/

add_filter( 'wp_handle_upload', 'image_compressor_handle_upload' );

function image_compressor_handle_upload( $upload ) {
    $file_path = $upload['file'];
    $file_path = image_compressor_compress_image( $file_path );
    $upload['file'] = $file_path;
    return $upload;
}

function image_compressor_compress_image( $file_path ) {
    $image_quality = 60; // Set the image quality
    $info = getimagesize( $file_path );
    if ( $info['mime'] == 'image/jpeg' ) {
        $image = imagecreatefromjpeg( $file_path );
        imagejpeg( $image, $file_path, $image_quality );
    } elseif ( $info['mime'] == 'image/png' ) {
        $image = imagecreatefrompng( $file_path );
        imagepng( $image, $file_path, round( 9 * $image_quality / 100 ) );
    } elseif ( $info['mime'] == 'image/gif' ) {
        $image = imagecreatefromgif( $file_path );
        imagegif( $image, $file_path );
    } elseif ( $info['mime'] == 'image/webp' ) {
        $image = imagecreatefromwebp( $file_path );
        imagewebp( $image, $file_path );
    }
    return $file_path;
}