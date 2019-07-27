readme
```php

//step1
$cSession = curl_init(); 
//step2
curl_setopt($cSession,CURLOPT_URL,"https://opentdb.com/api.php?amount=10");
curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
curl_setopt($cSession,CURLOPT_HEADER, false); 
//step3
$result=curl_exec($cSession);
print_r($result);

//step4
curl_close($cSession);
//step5
echo $result;

```