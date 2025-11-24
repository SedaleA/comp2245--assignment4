<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $country = $_GET['country'] ?? '';
    $lookupType = $_GET['lookup'] ?? 'countries'; // default is countries

    // =========================
    // COUNTRY LOOKUP (DEFAULT)
    // =========================
    if ($lookupType === 'countries') {
        if (!empty($country)) {
            $sql = "SELECT name, continent, independence_year, head_of_state
                    FROM countries 
                    WHERE name LIKE :country";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':country' => "%$country%"]);
        } else {
            $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries");
            $stmt->execute();
        }

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output country table
        echo "<table border='1'>
                <tr>
                    <th>Country</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['continent']) . "</td>
                    <td>" . htmlspecialchars($row['independence_year']) . "</td>
                    <td>" . htmlspecialchars($row['head_of_state']) . "</td>
                  </tr>";
        }
        echo "</table>";
    }

    // =========================
    // CITY LOOKUP
    // =========================
    elseif ($lookupType === 'cities' && !empty($country)) {

        $sql = "SELECT cities.name AS city, cities.district, cities.population
                FROM cities 
                JOIN countries ON cities.country_code = countries.code
                WHERE countries.name LIKE :country";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>Cities in " . htmlspecialchars($country) . "</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Name</th>
                    <th>District</th>
                    <th>Population</th>
                </tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['city']) . "</td>
                    <td>" . htmlspecialchars($row['district']) . "</td>
                    <td>" . htmlspecialchars($row['population']) . "</td>
                  </tr>";
        }
        echo "</table>";
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

