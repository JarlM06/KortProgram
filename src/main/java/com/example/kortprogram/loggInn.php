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

// Utfør spørring for å sjekke om brukeren finnes
$query = "SELECT id FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($query);

// Sjekk om det finnes en rad som samsvarer med brukernavn og passord
if ($result->num_rows > 0) {
    // Hent brukerens ID
    $row = $result->fetch_assoc();
    $userId = $row['id'];

    // Bygg tabellnavn basert på brukerens ID
    $tableName = "stock_" . $userId;

    // Utfør spørring for å hente alle rader fra tabellen basert på brukerens ID
    $tableQuery = "SELECT * FROM $tableName";
    $tableResult = $conn->query($tableQuery);

    if ($tableResult) {
        // Hent alle radene fra tabellen
        $tableData = array();
        while ($row = $tableResult->fetch_assoc()) {
            $tableData[] = $row;
        }

        // Lukk tilkoblingen
        $conn->close();

        // Returner dataene som JSON
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "tableData" => $tableData));

        // Endrer tableData til JSON
        $tableDataJSON = json_encode($tableData);

        // Redirekt til program.html med tableData i query string
        header("Location: http://172.20.128.64/src/main/resources/static/program.html?tableData=$tableDataJSON?userId=$userId");
    } else {
        // Feil ved henting av data fra tabellen
        // Lukk tilkoblingen
        $conn->close();

        // Returner en feilmelding som JSON
        header('Content-Type: application/json');
        echo json_encode(array("success" => false, "message" => "Feil ved henting av data fra tabellen."));

        header("Location: http://172.20.128.64/src/main/resources/static/index.html");
    }
} else {
    // Brukeren ble ikke funnet
    // Lukk tilkoblingen
    $conn->close();

    // Returner en feilmelding som JSON
    header('Content-Type: application/json');
    echo json_encode(array("success" => false, "message" => "Feil brukernavn eller passord."));

    header("Location: http://172.20.128.64/src/main/resources/static/index.html?loggInn=false");
}
?>