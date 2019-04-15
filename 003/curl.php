<?php
/**
 * Send tracking data to a remote endpoint, which has code like:
 *
 * $log = "GET:".print_r($_GET,1)."POST:".print_r($_POST,1);
 * error_log( $log, 3, 'log.log');
 *
 * The data tracking in log file log.log should be like:
 *
 * GET:Array
 * (
 * )
 * POST:Array
 * (
 * [--------------------------2d954ba8f787d017
 * Content-Disposition:_form-data;_name] => "id"
 *
 * 2
 * --------------------------2d954ba8f787d017
 * Content-Disposition: form-data; name="name"
 *
 * BMW
 * --------------------------2d954ba8f787d017
 * Content-Disposition: form-data; name="link"
 *
 * img/bmw.png
 * --------------------------2d954ba8f787d017
 * Content-Disposition: form-data; name="time"
 *
 * 09:52:53, 12th April, 2019
 * --------------------------2d954ba8f787d017--
 *
 * )
 */

$data = trim(file_get_contents('php://input'));

if ($data) {
    $data = json_decode($data, true);
    $data['time'] = date('H:i:s, jS F, Y');
    $url = "http://dev.test06/index.php";
    $header = array("Content-Type: application/x-www-form-urlencoded");
    $curl = curl_init();

    if ($curl === false) {
        echo json_encode(['success' => false]);
        exit();
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($curl);

    if ($response === false) {
        echo json_encode(['success' => false]);
        exit();
    }

    curl_close($curl);
}

echo json_encode(['success' => true]);