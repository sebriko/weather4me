<?php

// Function to fetch weather data from the API
function fetchWeatherData() {
    $apiUrl = 'https://api.openweathermap.org/data/2.5/forecast?lat=51.421121&lon=6.820335&lang=de&appid=<Your API Key>';
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

    // If the last forecast is older than 3 hours, update
    if ($timeDifference >= 10800) {
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
