<?php

function getUserToken($checksum, $emailaddr, $passwrd)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => api_url . '/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'grant_type=password&scope=sollicitatie-scope&emailaddr=' . $emailaddr . '&passwrd=' . $passwrd,
        CURLOPT_HTTPHEADER => array(
            'client-id: ' . client_key,
            'client-secret: ' . $checksum,
            'scope: ' . scope,
            'grant_type: password',
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function getUser($checksum, $userToken)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => api_url . '/user',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => Globals::$clientHeader,
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function getUserEul($checksum, $userToken)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => api_url . '/user/eul',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => Globals::$clientHeader,
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
