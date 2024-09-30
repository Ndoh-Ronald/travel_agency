<!-- booking.php -->
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <header>
        <h1>Book Your Trip</h1>
    </header>
    <main>
        <form id="payment-form" action="process_booking.php" method="POST">
            <label for="destination">Destination:</label>
            <input type="text" name="destination" value="<?php echo isset($_GET['destination']) ? $_GET['destination'] : ''; ?>" readonly required>
            <label for="price">Price:</label>
            <input type="number" name="price" value="<?php echo isset($_GET['price']) ? $_GET['price'] : ''; ?>" readonly required>            <div id="card-element"></div>
            <button type="submit">Pay</button>
            <div id="card-errors" role="alert"></div>
        </form>
    </main>

    <script>
        const stripe = Stripe('your_publishable_key'); // Replace with your public key
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
            } else {
                const formData = new FormData(form);
                formData.append('payment_method_id', paymentMethod.id);
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                }).then(response => response.json()).then(data => {
                    console.log(data);
                    if (data.success) {
                        alert('Booking successful!');
                        window.location.href = 'dashboard.php';
                    } else {
                        document.getElementById('card-errors').textContent = data.error;
                    }
                });
            }
        });
    </script>
</body>
</html>