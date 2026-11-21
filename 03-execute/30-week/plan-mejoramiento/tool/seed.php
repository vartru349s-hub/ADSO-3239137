<?php
$base=rtrim(getenv('BIKE_SHARE_API')?:'http://localhost:8000/api/v1','/');
function callApi(string $method,string $path,array $body=[]):array{global $base;$options=['http'=>['method'=>$method,'header'=>"Content-Type: application/json\r\n",'ignore_errors'=>true,'content'=>json_encode($body)]];$raw=file_get_contents($base.$path,false,stream_context_create($options));$status=(int)preg_replace('/\D/','',$http_response_header[0]??'500');if($status>=400)throw new RuntimeException("API $status: $raw");return json_decode($raw?:'[]',true)?:[];}
$categories=callApi('GET','/categories');
callApi('POST','/users',['name'=>'Carlos Méndez','document_number'=>'1010101010','email'=>'carlos@example.test']);
foreach($categories as $index=>$category){try{callApi('POST','/bicycles',['model_code'=>'DEMO-'.($index+1),'name'=>'Modelo demostración '.$category['name'],'category_id'=>$category['id'],'hourly_rate'=>7000+$index*500,'total_units'=>2]);}catch(RuntimeException $e){if(!str_contains($e->getMessage(),'422'))throw $e;}}
echo "Datos de demostración enviados por la API.\n";
