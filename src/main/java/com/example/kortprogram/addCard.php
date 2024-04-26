<?php
// Koble til MariaDB-serveren
$conn = new mysqli("localhost", "root", "Akademiet99", "Kortstokker");

// Sjekk tilkoblingen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hent innsendte verdier fra skjemaet
$userId = $_POST['userIdInput'];
$cardType = $_POST['cardType'];
$cardNumber = $_POST['cardNumber'];

// Utfør spørring for å legge til et nytt objekt i databasen
$result = $conn->query("INSERT INTO stock_$userId (Type, Number) VALUES ('$cardType', '$cardNumber')");

// Lukk tilkoblingen
$conn->close();

// Returnerer til html siden
header("Location: http://172.20.128.64/src/main/resources/static/");
exit();
?>