<?php
// Database connection settings
$host = 'your-database-hostname';
$dbname = 'your-database-name';
$username = 'your-username';
$password = 'your-password';

// Create MySQL connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form inputs
$accessibility = $_POST['accessibility'];
$activity_type = $_POST['activity_type'];
$postcode = $_POST['postcode'];

// Prepare SQL query
$sql = "SELECT * FROM businesses WHERE accessibility = ? AND activity_type = ? AND postcode LIKE ?";
$stmt = $conn->prepare($sql);
$searchPostcode = '%' . $postcode . '%';
$stmt->bind_param("sss", $accessibility, $activity_type, $searchPostcode);

// Execute query
$stmt->execute();
$result = $stmt->get_result();

// Display results
echo "<h2>Filtered Businesses:</h2>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>Business Name: " . $row['business_name'] . "<br>";
        echo "Activity Type: " . $row['activity_type'] . "<br>";
        echo "Accessibility: " . $row['accessibility'] . "<br>";
        echo "Postcode: " . $row['postcode'] . "</p>";
    }
} else {
    echo "No results found.";
}