<?php
function img_resize($in_img_file, $out_img_file, $req_width, $req_height, $quality=90) {

// Get image file details
list($width, $height, $type, $attr) = getimagesize($in_img_file);

// Open file according to file type
if (isset($type)) {
    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = @imagecreatefromjpeg($in_img_file);
            break;
        case IMAGETYPE_PNG:
            $src = @imagecreatefrompng($in_img_file);
            break;
        case IMAGETYPE_GIF:
            $src = @imagecreatefromgif($in_img_file);
            break;
        default:
            $error = "Image is not a gif, png or jpeg.";
            return array(false, $error);
    }
    
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

    // Return an array of values, including the new width and height
    return array(true, "Resize successful", $new_width, $new_height);
} else {
// Return only the bool and an error message
    $error = "Problem opening image.";
    return array(false, $error);
}
}
?>