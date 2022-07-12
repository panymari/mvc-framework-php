<?php

namespace App\Components;

class RestApiConnection
{
    public static array $user_data;

    public static function connect(string $url, string $method): array|null
    {
        $curl_handle = require './config/init_curl.php';

        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $url);

        switch ($method) {
            case 'get':
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

                break;
            case 'post':
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(self::$user_data, JSON_UNESCAPED_UNICODE));

                break;
            case 'put':
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(self::$user_data, JSON_UNESCAPED_UNICODE));

                break;
            case 'delete':
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'DELETE');

                break;
        }
        // Execute curl & store data in a variable
        $output = curl_exec($curl_handle);
        curl_close($curl_handle);

        return json_decode($output, true);
    }
}
