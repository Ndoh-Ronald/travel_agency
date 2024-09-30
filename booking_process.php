<?php
require 'vendor/autoload.php';
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

\Stripe\Stripe::setApiKey('your_secret_key'); // Replace with your secret key

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];
    $paymentMethodId = $_POST['payment_method_id'];

    try {
        // Create a PaymentIntent
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $price * 100, // Amount in cents
            'currency' => 'usd',
            'payment_method' => $paymentMethodId,
            'confirm' => true,
        ]);

        // Save booking to the database
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, destination, price) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $userId, $destination, $price);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } catch (\Stripe\Exception\CardException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Payment processing failed']);
    }
}
?>