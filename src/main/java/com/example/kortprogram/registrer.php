<?php
// Koble til MariaDB-serveren
$conn = new mysqli("localhost", "root", "Akademiet99", "Kortstokker");

// Sjekk tilkoblingen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hent innsendte brukernavn og passord fra skjemaet
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Utfør spørring for å legge til brukeren
$result = $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");

// Sjekk om det ble satt inn en ny rad
if ($result) {
    // Hent ID for den nyopprettede brukeren
    $userId = $conn->insert_id;

    // Opprett tabell for brukeren med to kolonner: Type (varchar(255)) og Number (int(11))
    $createTableQuery = "CREATE TABLE IF NOT EXISTS stock_$userId (
        Type VARCHAR(255),
        Number INT(11)
    )";
    $createTableResult = $conn->query($createTableQuery);

    if ($createTableResult) {
        echo "Bruker opprettet vellykket!";
    } else {
        echo "Feil ved oppretting av brukerens tabell.";
    }
} else {
    echo "Feil ved oppretting av bruker.";
}

// Lukk tilkoblingen
$conn->close();

// Returnerer til html siden
header("Location: http://172.20.128.64/src/main/resources/static/");
exit();
?>