<?php
function getImageSrc($imagePath) {
    if (empty($imagePath)) {
        return null;
    }
    
    // Check if it's a URL (starts with http:// or https://)
    if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
        return $imagePath;
    }
    
    // Check if it's a local file and exists
    if (file_exists('../' . $imagePath)) {
        return '../' . $imagePath;
    }
    
    return null;
}
?>