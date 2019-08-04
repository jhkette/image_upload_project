# README

## Pic upload
[http://titan.dcs.bbk.ac.uk/~jkette01/w1tma/]

Author: Joseph Ketterer

## Description
-----------
This package contains the files for the Web Applications using MySQL and PHP FMA project. It is a picture upload
service, that allows the user to upload pictures 

## Installation

Set up a database and run the sql commands which can be found in createTable.sql. This will set up a photos
table with appropriate columns. 

## Configuration

All configuration settings for this application can be found in: includes/config.inc.php
You should change the values to match your current environment before deploying. To run locally use your
local mysql username and password. To set up a  test server run php -S localhost:8080. 


## JSON web service

[http://titan.dcs.bbk.ac.uk/~jkette01/w1fma/index.php?json=3](http://titan.dcs.bbk.ac.uk/~jkette01/w1fma/index.php?json=3) 

The url for the JSON web service is provided above. After the '?json=' the id of the photo should be provided. In
the example above the url links to a photo with the id of 10.

I have added the id on all the main photo listings. This ensure thes user has access to the id 
of the photo they would like get json data from. 

For an example of how to access the data in your own php application see below.

```php

$my_curl = curl_init();
$url = 'http://titan.dcs.bbk.ac.uk/~jkette01/upload/index.php?json=2'; 
curl_setopt($my_curl, CURLOPT_URL, $url); 
curl_setopt($my_curl, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($my_curl);
// Get the error codes and messages 
if(curl_errno($my_curl)) {
    echo 'Code: ' . curl_errno($my_curl);
    echo 'Message: ' . curl_error($my_curl); } 
else {
    echo $result;
}


```

