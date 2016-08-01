<?php

set_error_handler(function() {
    throw new Exception();
});

try
{
    $site = $_REQUEST["s"];
    $data = $_REQUEST["d"];
    $origin = $_SERVER["HTTP_ORIGIN"];

    $od = json_decode(file_get_contents("od.json"));

    if($od->opendata->$site->$data && $od->cors->$origin)
    {
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Content-Type: " . $od->opendata->$site->$data->mime);
        header("Cache-Control: private, max-age=60");
        print(file_get_contents($od->opendata->$site->$data->data));
    }
}
catch (Exception $e)
{
    header("HTTP/1.0 404 Not Found");
    print("Nothing.");
}
