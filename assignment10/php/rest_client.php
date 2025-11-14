<?php
// REST client to get weather data based on zip code input
function getWeather(): array {
    $ack = '';
    $out = '';

    // Read zip from POST
    $zipInput = isset($_POST['zip_code']) ? trim($_POST['zip_code']) : '';

    // Required input
    if ($zipInput === '') {
        $ack = 'No zip code provided. Please enter a zip code.';
        return [$ack, $out];
    }

    // Call remote API via cURL
    $apiurl = "https://russet-v8.wccnet.edu/~sshaper/assignments/assignment10_rest/get_weather_json.php?zip_code=" . urlencode($zipInput);
    $ch = curl_init($apiurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $curlErr  = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        $ack = 'There was an error retrieving the records.';
        //  log $curlErr
        return [$ack, $out];
    }

    $data = json_decode($response, true);

    // Check if API returned an error
    if (is_array($data) && isset($data['error'])) {
        $ack = htmlspecialchars($data['error']);
        return [$ack, $out];
    }

    // Check for searched_city structure
    if (is_array($data) && isset($data['searched_city'])) {
        $cityData = $data['searched_city'];
        
    // Extract city info
    $city = htmlspecialchars($cityData['name'] ?? '');
    // Temperature comes back with HTML entities like 72&deg;F; decode then escape
    $tempRaw = $cityData['temperature'] ?? '';
    $temp = htmlspecialchars(html_entity_decode($tempRaw, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $hum  = htmlspecialchars($cityData['humidity'] ?? '');
        
        // Build output
        $out .= "<h3>{$city}</h3>";
        $out .= "<p><strong>Temperature:</strong> {$temp}</p>";
        $out .= "<p><strong>Humidity:</strong> {$hum}</p>";
        
        // Display 3-day forecast
        if (isset($cityData['forecast']) && is_array($cityData['forecast'])) {
            $out .= "<p><strong>3-day forecast</strong></p>";
            foreach ($cityData['forecast'] as $forecast) {
                $day = htmlspecialchars($forecast['day'] ?? '');
                $condition = htmlspecialchars($forecast['condition'] ?? '');
                $out .= "<p>{$day}: {$condition}</p>";
            }
        }
        
        // Display higher temperatures
        if (isset($data['higher_temperatures']) && is_array($data['higher_temperatures']) && count($data['higher_temperatures']) > 0) {
            $out .= "<p><strong>Up to three cities where temperatures are higher than {$city}</strong></p>";
            $out .= "<table class='table table-bordered table-striped'>";
            $out .= "<thead><tr><th>City Name</th><th>Temperature</th></tr></thead><tbody>";
            foreach ($data['higher_temperatures'] as $higherCity) {
                $hName = htmlspecialchars($higherCity['name'] ?? '');
                $hTempRaw = $higherCity['temperature'] ?? '';
                $hTemp = htmlspecialchars(html_entity_decode($hTempRaw, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                $out .= "<tr><td>{$hName}</td><td>{$hTemp}</td></tr>";
            }
            $out .= "</tbody></table>";
        } else {
            $out .= "<p><strong>There are no cities with temperatures higher than {$city}.</strong></p>";
        }
        
        // Display lower temperatures
        if (isset($data['lower_temperatures']) && is_array($data['lower_temperatures']) && count($data['lower_temperatures']) > 0) {
            $out .= "<p><strong>Up to three cities where temperatures are lower than {$city}</strong></p>";
            $out .= "<table class='table table-bordered table-striped'>";
            $out .= "<thead><tr><th>City Name</th><th>Temperature</th></tr></thead><tbody>";
            foreach ($data['lower_temperatures'] as $lowerCity) {
                $lName = htmlspecialchars($lowerCity['name'] ?? '');
                $lTempRaw = $lowerCity['temperature'] ?? '';
                $lTemp = htmlspecialchars(html_entity_decode($lTempRaw, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                $out .= "<tr><td>{$lName}</td><td>{$lTemp}</td></tr>";
            }
            $out .= "</tbody></table>";
        } else {
            $out .= "<p><strong>There are no cities with temperatures lower than {$city}.</strong></p>";
        }
        
        return [$ack, $out];
    }

    // Not found or unexpected structure
    $ack = 'City with zip code ' . htmlspecialchars($zipInput) . ' not found';
    return [$ack, $out];
}


// set $acknowledgement and $output based on POST default to empty strings.
// This allows index.php to only `require` this file and then echo the variables.
if (!isset($acknowledgement) || !isset($output)) {
    $acknowledgement = '';
    $output = '';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$acknowledgement, $output] = getWeather();
}


/* 
Explain the difference between a REST API client and a REST API server. What role does this code play in that relationship?
REST API Client sends the intial request to the server. ($_POST request) 
The REST API Server waits for the request, and processes and validate the request then sends back a response.
This code plays the REST API Client because it sends the request to the weather API server and process the response.  


Why is JSON commonly used for API responses? What are the benefits of using JSON over other data formats like XML?
JSON is commonly used for API responses because structure wise is easier to read and write. 
For PHP purposes it is easier to to turn JSON data into associative arrays that is needed for API.



How should an application handle different types of API responses (success, error, empty data)? What considerations are important for each scenario?
For success responses the applicaation should process and display the data in a readable format.
For error responses the application should display an error message to the user such as "Invalid zip code" and the error should be logged on backend for debugging.
For empty data responses the application should inform that no data was found. (i.e. if nothing was enteed "no zip code provided")
Considerations that are important for each scenario is user experience, so the user knows what is happening and what to do next. 

What is cURL used for in web development? 
cURL is used for HTTPS request from the command line. 
You're able to test the API endpoints directly to make sure they are working before building.
You're also able to see each request being sent and the response received for debugging purposes.
*/