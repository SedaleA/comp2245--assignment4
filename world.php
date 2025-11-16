<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';


try {
    // Connect using PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get country from GET parameter
    $country = $_GET['country'] ?? '';

    if (!empty($country)) {
        // Prepared statement with LIKE operator
        $sql = "SELECT * FROM countries WHERE name LIKE :country";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':country' => "%$country%"]);
    } else {
        // No input → return all countries
        $stmt = $conn->prepare("SELECT * FROM countries");
        $stmt->execute();
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul>
