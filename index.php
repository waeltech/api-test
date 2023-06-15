<?php 
require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

// LOAD ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "<h1> beginning of Test </h1>";

echo "client_id:". $_ENV['CLIENT_ID'];
echo "<br>";
echo "client_Secret:". $_ENV['CLIENT_SECRET'];




function getToken() {
    $tokenUrl = 'https://login.windows.net/0be9457f-8c79-4174-bfa9-8123bd902e77/oauth2/token?resource=https://api.businesscentral.dynamics.com';
    $formParams = [
        'grant_type' => 'client_credentials',
        'client_id' => $_ENV['CLIENT_ID'],
        'client_secret' => $_ENV['CLIENT_SECRET'],
        'scope' => null,
    ];

    $client = new Client();
    return $client->post($tokenUrl, [
        'form_params' => $formParams,
    ]);
}

function refreshToken() 
{
    // function to refresh token 
}

function getProduct($token, $url) {
    
    $client = new Client();
    $headers = [
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
    'Authorization' => 'Bearer '.$token
    ];
    $request = new Request('GET', $url, $headers);
    $res = $client->sendAsync($request)->wait();
    return $res;
}

$Testurl = "https://api.businesscentral.dynamics.com/v2.0/0be9457f-8c79-4174-bfa9-8123bd902e77/Production/ODataV4/Company('Specialist Sports LIVE')/CustomerStockFeedVariants?".'$filter=VariantItemNo eq %27F91067%27';


$response = getToken();

$access_token = json_decode((string) $response->getBody(), true)['access_token'];

// override token with token from postman for testing, go to postman and grab token
// $access_token =   'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6Ii1LSTNROW5OUjdiUm9meG1lWm9YcWJIWkdldyIsImtpZCI6Ii1LSTNROW5OUjdiUm9meG1lWm9YcWJIWkdldyJ9.eyJhdWQiOiJodHRwczovL2FwaS5idXNpbmVzc2NlbnRyYWwuZHluYW1pY3MuY29tIiwiaXNzIjoiaHR0cHM6Ly9zdHMud2luZG93cy5uZXQvMGJlOTQ1N2YtOGM3OS00MTc0LWJmYTktODEyM2JkOTAyZTc3LyIsImlhdCI6MTY4NjgzMzY2MiwibmJmIjoxNjg2ODMzNjYyLCJleHAiOjE2ODY4MzkzMDcsImFjciI6IjEiLCJhaW8iOiJBVlFBcS84VEFBQUFSLzlvWTVCeXp3TmU4NGdDSmw3dEFKZC9yREFsd3lTUk55Y0lmV3BYbFdOdWc3ZW51NXJMekpnL1pMQklCVGw1Lzh0ZHo0a3JpbTJJaGR6Y0hPenRybUVacitYRHlSb1dFK3VtaU5PRWZ3ND0iLCJhbXIiOlsicHdkIiwibWZhIl0sImFwcGlkIjoiNjgxYTE5YWUtZWY0Ni00MTExLThjN2MtOTg0ODBiYWE0MzZiIiwiYXBwaWRhY3IiOiIxIiwiZmFtaWx5X25hbWUiOiJFREkiLCJnaXZlbl9uYW1lIjoiU1MiLCJpcGFkZHIiOiI5Mi4yMC43MC4xODEiLCJuYW1lIjoiU1MgRURJIiwib2lkIjoiOTM2MjBjMWYtZWUyMS00OWQwLWJhODctMjMwNGI3MmRjNTQ2IiwicHVpZCI6IjEwMDMyMDAxQ0Q4QzhBRUIiLCJyaCI6IjAuQVRvQWYwWHBDM21NZEVHX3FZRWp2WkF1ZHozdmJabHNzMU5CaGdlbV9Ud0J1Sjg2QUNNLiIsInNjcCI6IkZpbmFuY2lhbHMuUmVhZFdyaXRlLkFsbCB1c2VyX2ltcGVyc29uYXRpb24iLCJzdWIiOiIxZ1c0MUx3WDk0dE9VaHVvUFVTNE1vTnB5UzRqSzVTZmFqYW8xclE2UF9RIiwidGlkIjoiMGJlOTQ1N2YtOGM3OS00MTc0LWJmYTktODEyM2JkOTAyZTc3IiwidW5pcXVlX25hbWUiOiJTU0VESUBzcGVjaWFsaXN0c3BvcnRzLmNvbSIsInVwbiI6IlNTRURJQHNwZWNpYWxpc3RzcG9ydHMuY29tIiwidXRpIjoiSUFxbmtiNWs2VWF2WjR6VDJFQWRBQSIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il19.rUByOVV_ZXtLBeCI0lofVuFjpsmuO5KphU8t3ghjfcnX9PShw2OcBDKfT8cfcEojlGD1KS3VywNhFCZ_JszbBOLINbP3poeYGk_eg701IWa8Bmb3Yrv95x38DpL6HmgYrym6FsjEWYYSGtgmw3HrACs_sXWHbQVz7C2a2R_BWOWU3nS1ksanbNfMHNdbYdb_eFb560gjq3V-Sw5MQgaamGLB2L-aidhzo98Ayiv0vKHjKE9SgBZdlKDInbBi2Au90hQhT12OS1Vn3vgSbGp54wOkVertiPeyzwJpHqTZhyHYfGrDRRH-Y8cKSab9odo14IyAt-lVPrLB_zi-pfAnYw';


echo "<h4> Access token from api ". $access_token; 
echo "</h4>";

// trying to get CustomerStockFeedVariants from API
$products = getProduct($access_token, $Testurl);
echo "<h4> status:". $products->getStatusCode() .'</h4>';

if($products->getStatusCode() === 200)
{
    echo $products->getBody();
} else 
{
    var_dump($products);

}

echo "<h1> end of Test </h1>";


?>