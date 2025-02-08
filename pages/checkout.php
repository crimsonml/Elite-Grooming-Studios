<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/secrets.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

session_start();

$cartItems = getCartItems();
if (empty($cartItems)) {
    header("Location: /EGS/pages/cart.php");
    exit;
}

$guestData = json_decode(file_get_contents('php://input'), true)['guestData'] ?? null;

$line_items = [];
foreach ($cartItems as $item) {
    $line_items[] = [
        "quantity" => $item['quantity'],
        "price_data" => [
            "currency" => "usd",
            "unit_amount" => $item['price'] * 100,
            "product_data" => [
                "name" => $item['item_name']
            ]
        ]
    ];
}

try {
    // Create the Stripe Checkout session
    $checkout_session = \Stripe\Checkout\Session::create([
        "payment_method_types" => ["card"],
        "customer_email" => $guestData['email'] ?? $_SESSION['email'],
        "mode" => "payment",
        "line_items" => $line_items,
        "success_url" => "http://localhost/EGS/pages/success.php?session_id={CHECKOUT_SESSION_ID}",
        "cancel_url" => "http://localhost/EGS/pages/cart.php",
        "locale" => "auto",
        "metadata" => [
            "guestData" => json_encode($guestData)
        ]
    ]);

    $_SESSION['payment_status'] = 'success';
    http_response_code(303);
    header("Location: " . $checkout_session->url);
} catch (\Stripe\Exception\ApiErrorException $e) {
    error_log("Stripe API error: " . $e->getMessage());
    header("Location: /EGS/pages/cart.php?error=stripe_failed");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css">
    <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
    <main>
        <div class="checkout-container">
            <h2>Checkout</h2>
            <form action="" method="POST" id="payment-form">
                <div class="form-row">
                    <label for="card-element">
                        Credit or debit card
                    </label>
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>
                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>
                <button type="submit">Submit Payment</button>
            </form>
        </div>
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
    <script>
        var stripe = Stripe('<?= STRIPE_PUBLISHABLE_KEY ?>');
        var elements = stripe.elements();

        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        var card = elements.create('card', {
            style: style
        });
        card.mount('#card-element');

        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            form.submit();
        }
    </script>
</body>

</html>