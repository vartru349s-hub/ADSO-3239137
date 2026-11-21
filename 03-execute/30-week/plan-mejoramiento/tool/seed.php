<?php
$base=rtrim(getenv('BIKE_SHARE_API')?:'http://localhost:8000/api/v1','/');
function callApi(string $method,string $path,array $body=[]):array{global $base;$options=['http'=>['method'=>$method,'header'=>"Content-Type: application/json\r\n",'ignore_errors'=>true,'content'=>json_encode($body)]];$raw=file_get_contents($base.$path,false,stream_context_create($options));$status=(int)preg_replace('/\D/','',$http_response_header[0]??'500');if($status>=400)throw new RuntimeException("API $status: $raw");return json_decode($raw?:'[]',true)?:[];}
