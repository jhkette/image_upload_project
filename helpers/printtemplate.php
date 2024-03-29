<?php


/**
 * This function takes an array of values from templates ,the replacements from the Database and an html file as parameters. It 
 * replaces template values with data. The data from the database is an array of arrays so needs to be handled with
 * a foreach loop. Im passing in two array - one of values from templates, one from database. This allows me to map through database
 * data and escape it using array_map with 'htmlentities'.  
 * 
 * @param array $values an array of values from templates
 * @param array $replacements an array of values from database to replaces template variables
 * @param string $file html file in templates file 
 * @return string $new_message, new html with new data present in HTML
 * */

function printTemplateArray($values, $replacements, $file){
  
    $new_message = '';
    // a for each loop is needed. Data from database is an array of arrays. 
    foreach($replacements as $replacement) {
        /* I'm using array_map here to create a new 'escaped' array of database values 
        htmlentities can be passed as an argument to array_map https://www.php.net/manual/en/function.array-map.php */
        $replacement = array_map('htmlentities', $replacement);
        $new_message .= str_replace($values, $replacement, $file);

    }
    return $new_message;
}

/**  I use this function if data does not come from database. 
* We do not need a foreach loop for the replacements, as they are not an array of arrays. 
* @param array $values an array of values from templates
* @param array $replacements an array of values from method to replaces template variables
* @param string $file html file in templates file 
* @return string $new_message, new html with new data present in HTML 
*/

function printTemplate($values, $replacements, $file){
    $replacements = array_map('htmlentities', $replacements);
    return $new_message = str_replace($values, $replacements, $file);
}


?>