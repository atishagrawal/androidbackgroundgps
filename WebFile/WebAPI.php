<?php

/**
 * @Author: atish
 * @Date:   2017-12-14 11:55:50
 * @Last Modified by:   atish
 * @Last Modified time: 2017-12-14 12:49:34
 */

/**
 * 1. Check whether the request is from a genune android app from emma
 * 2. Verify the secret hash for android app
 * 3. Verify if the request contains variables
 * 4. After all verification, insert the data into the database, otherwise reject.
 */

/**
 * Verifying for Secret Hash
 */

if (isset($_POST["location"])) {
    $request = json_decode($_POST["location"], true);

    if (array_key_exists("secret_key", $request)) {
        $serverSecretKey = 'GEHHdhLwHX_XBPTApnTp8VA@zY?9ZSQR';

        $secretKey = $request["secret_key"];

        if ($serverSecretKey === $secretKey) {
            if (array_key_exists("latitude", $request) and array_key_exists("longitude", $request) and array_key_exists("deviceID", $request)) {
                $data = array(
                    'latitude' => $request["latitude"],
                    'longitude' => $request["longitude"],
                    'deviceID' => $request["deviceID"],
                );

                // print_r(json_encode($data));
                //Saving this data in the DB
                //Connecting with the DB
                $conn = mysqli_connect('localhost', 'id3980136_emmabackgroundgps', 'U2zoqbcJcFX1G@OtXv6Q', 'id3980136_emmabackgroundgps');
                if ($conn->connect_errno) {
                    //Connection Error
                    showError();
                } else {
                    //Connection Established
                    $sql_query = 'INSERT INTO backgroundgps (deviceId, latitude, longitude) VALUES (' . $data["deviceID"] . ',' . $data["latitude"] . ',' . $data["longitude"] . ')';

                    if (mysqli_query($conn, $sql_query)) {
                        echo "Success";
                    } else {

                        echo "Failed";
                    }
                }

                $conn->close();
            } else {
                showError();
            }
        }
    } else {
        showError();
    }
} else {
    showError();
}

function showError()
{
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
    exit();
}
