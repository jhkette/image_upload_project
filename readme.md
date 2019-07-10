$my_curl = curl_init();
$url = 'http://www.xyz.com/data.php?type=books'; curl_setopt($my_curl, CURLOPT_URL, $url); curl_setopt($my_curl, CURLOPT_RETURNTRANSFER, true); $result = curl_exec($my_curl);
// Get the error codes and messages if(curl_errno($my_curl)) {
echo 'Code: ' . curl_errno($my_curl);
echo 'Message: ' . curl_error($my_curl); } else {
echo $result;
}
// Get array of info about the transfer
$info = curl_getinfo(\$my_curl);
