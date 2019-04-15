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

// read data from an Ajax post request
$data = trim(file_get_contents('php://input'));

if ($data) {
    $data = json_decode($data, true);
    // add 'time' for the event fired
    $data['time'] = date('H:i:s, jS F, Y');

    // remote endpoint, in this test case, code on it just simply to catch the GET and POST
    $url = "http://dev.test06/index.php";
    $header = array("Content-Type: application/x-www-form-urlencoded");

    // use CURL to send a POST request to analytics system - a remote endpoint
    $curl = curl_init();

    // if failed to initialise CURL
    if ($curl === false) {
        echo json_encode(['success' => false]);
        exit();
    }

    curl_setopt($curl, CURLOPT_URL, $url); // set endpoint
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header); // set header
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // set if return the transfer as a string of response
    curl_setopt($curl, CURLOPT_POST, 1); // set request method
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // set data sent for this post request
    $response = curl_exec($curl);

    // if failed to send request
    if ($response === false) {
        echo json_encode(['success' => false]);
        exit();
    }

    curl_close($curl);
}

// tracking data successfully
echo json_encode(['success' => true]);