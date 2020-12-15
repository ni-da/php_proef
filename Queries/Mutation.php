<?php
function modifyEUL($user_access_token, $checksum, $client_key)
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
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => 'signed_eul=1',
    CURLOPT_HTTPHEADER => array(
      'client-id: ' . $client_key,
      'client-secret: ' . $checksum,
      'scope: ' . scope,
      'Authorization: Bearer ' . $user_access_token,
      'Content-Type: application/x-www-form-urlencoded'
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  echo $response;
  return $response;
}


function modifyPassword($newPassword, $user_access_token, $checksum, $client_key)
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => api_url . '/user/forceNewPassword',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => 'new_password=' . $newPassword,
    CURLOPT_HTTPHEADER => array(
      'client-id: ' . $client_key,
      'client-secret: ' . $checksum,
      'scope: sollicitatie-scope',
      'Authorization: Bearer ' . $user_access_token,
      'Content-Type: application/x-www-form-urlencoded'
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  echo $response;
  return $response;
}
