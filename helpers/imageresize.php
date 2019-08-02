<?php

/**
 * Resize images
 *
 * Function to resize images to fit area specified when called
 * All testing for file type, validity is done outside this function - in the validate form method in the 
 * Controlview class
 * 
 * @param string $in_img_file Input image file
 * @param string $out_img_file Output image filename
 * @param int $req_width Width of area the image should fill
 * @param int $req_height Height of area the image should fill
 * @param int $quality Quality of the thumb - i'm adding a default of a 100 - this could be changed
 * @return bool, 
 */

function img_resize($in_img_file, $out_img_file, $req_width, $req_height, $quality=100) {

// Get image file details
list($width, $height, $type, $attr) = getimagesize($in_img_file);
$src = @imagecreatefromjpeg($in_img_file);

// Open file according to file type    
    // Check if image is smaller (in both directions) than required image
    if ($width < $req_width and $height < $req_height) {
        // Use original image dimensions
        $new_width = $width;
        $new_height = $height;
    } else {
        // Test orientation of image and set new dimensions appropriately
    // (makes sure largest dimension never exceeds the target thumb size)
        if ($width > $height) {
            // landscape
            $sf = $req_width / $width;
        } else {
            // portrait                 
    $sf = $req_height / $height;
        }
        $new_width = round($width * $sf);
        $new_height = round($height * $sf);
    }

    // Create the new canvas ready for resampled image to be inserted into it
    $new = imagecreatetruecolor($new_width, $new_height);

    // Resample input image into newly created image
    imagecopyresampled($new, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Create output jpeg
    imagejpeg($new, $out_img_file, $quality);
    // Destroy any intermediate image files
    imagedestroy($src);
    imagedestroy($new);

    return true;
}

?>