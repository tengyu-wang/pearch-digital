<?php
/*

The table structure should be like this:

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(3) NOT NULL,
  `job_title` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inserted_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

 */


// create instance of mysqli
$mysqli = new mysqli("localhost", "username", "password", "test_db");

// check connection
if ($mysqli->connect_errno) {
    printf("Connect failed: %s", $mysqli->connect_error);
    exit();
}


// query a record by given id_user
$userId = 3; // test example for id_user = 3
$userId = $mysqli->real_escape_string((string)$userId); // escape string if it is from user input

// select queries return a resultset for searching user who has is_user = 3
$result = $mysqli->query("SELECT id_user, name, age, job_title, inserted_on, last_updated FROM users WHERE id_user = ".$userId);

// if query failed
if (!$result) {
    printf("Failed to get data, ".$mysqli->error);
    exit();
}

if($rowObj = $result->fetch_object()) {
    printf ("Details for userId %d is - ID: %s, Name: %s, Age: %s, Job title: %s, Inserted on: %s, Last updated: %s",
            intval($userId),
            $rowObj->is_user,
            $rowObj->name,
            $rowObj->age,
            $rowObj->job_title,
            $rowObj->inserted_on,
            $rowObj->last_updated);

    printf("<br>");
}

// free result set
$result->close();



// Insert a record, as table structure, all 'name', 'age' and 'job_title' fields are required, should be checked in
// front-end validation, but checking here too for sure
if (!isset($_POST['name'], $_POST['age'], $_POST['job_title'])) {
    printf("Failed to get form value");
    exit();
}

$name = $mysqli->real_escape_string($_POST['name']);
$age = $mysqli->real_escape_string($_POST['age']);
$jobTitle = $mysqli->real_escape_string($_POST['job_title']);

// insert into table
$query = "INSERT INTO users (name, age, job_title) VALUES ('$name', $age, '$jobTitle')";

if (!$mysqli->query($query)) {
    printf("Failed to insert - Name: %s, Age: %s, Job title: %s",
            $name,
            $age,
            $jobTitle);
}

printf("%d Row inserted.", $mysqli->affected_rows);