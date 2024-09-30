<!-- dashboard.php -->
<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM bookings WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Your Bookings</h1>
    <a href="destinations.php">Book New Trip</a>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li><?php echo $row['destination']; ?> - $<?php echo $row['price']; ?> on <?php echo $row['booking_date']; ?></li>
        <?php endwhile; ?>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>