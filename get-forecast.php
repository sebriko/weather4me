<?php

// Custom settings. 
$latitude = 51.421121;
$longitude = 6.820335;
$language = 'de'; // Some weather results will be language specific
$apiKey = ''; // API key from openweathermap

// Function to fetch weather data from the API
function fetchWeatherData() {
    global $latitude, $longitude, $language, $apiKey;
    $apiUrl = "https://api.openweathermap.org/data/2.5/forecast?lat=$latitude&lon=$longitude&lang=$language&appid=$apiKey";
    $response = file_get_contents($apiUrl);
    return $response;
}

// Function to save weather data to a file
function saveWeatherData($data) {
    $filePath = 'forecasts/weather.json';
    file_put_contents($filePath, $data);
}

// Function to load weather data from a file
function loadWeatherData() {
    $filePath = 'forecasts/weather.json';
    return file_get_contents($filePath);
}
 
// Main program
$currentTimestamp = time();
$forecastFilePath = 'forecasts/weather.json';

// Check if current weather forecast already exists
if (file_exists($forecastFilePath)) {
    $lastModifiedTimestamp = filemtime($forecastFilePath);
    $timeDifference = $currentTimestamp - $lastModifiedTimestamp;

    // If the last forecast is older than 1 hour, update
    if ($timeDifference >= 3600) {
        $weatherData = fetchWeatherData();
        saveWeatherData($weatherData);
    }
} else {
    // If no weather forecast exists, fetch and save new one
    $weatherData = fetchWeatherData();
    saveWeatherData($weatherData);
}

// Return weather data
echo loadWeatherData();

?>
