<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Page - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css" />
    <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

    // Get the item ID from the query string
    $itemId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Retrieve item details
    $item = getItemDetails($itemId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        $result = addToCart($itemId, $quantity);
    }
    ?>
    <main>
        <?php if ($item): ?>
            <!-- Product Container -->
            <div class="product-container">
                <!-- Product Image -->
                <div class="product-image">
                    <img src="/EGS/assets/itemphotos/<?= htmlspecialchars($item['image_location']) ?>" alt="<?= htmlspecialchars($item['item_name']) ?>" />
                </div>

                <!-- Product Details -->
                <div class="product-details">
                    <h1 class="product-title"><?= htmlspecialchars($item['item_name']) ?></h1>
                    <p class="product-description"><?= htmlspecialchars($item['small_description']) ?></p>
                    <p class="product-price">$<?= htmlspecialchars($item['price']) ?></p>

                    <!-- Action Buttons -->
                    <form method="POST" action="">
                        <div class="product-actions">
                            <button type="button" class="quantity-button decrease">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="quantity" value="1" min="1" class="quantity">
                            <button type="button" class="quantity-button increase">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                    </form>
                </div>
            </div>

            <!-- Product Description Section -->
            <section class="long-description">
                <h2>About the Product</h2>
                <p><?= htmlspecialchars($item['long_description']) ?></p>
            </section>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const decreaseButton = document.querySelector('.quantity-button.decrease');
            const increaseButton = document.querySelector('.quantity-button.increase');
            const quantityInput = document.querySelector('.quantity');

            decreaseButton.addEventListener('click', function() {
                let quantity = parseInt(quantityInput.value);
                if (quantity > 1) {
                    quantityInput.value = quantity - 1;
                }
            });

            increaseButton.addEventListener('click', function() {
                let quantity = parseInt(quantityInput.value);
                quantityInput.value = quantity + 1;
            });
        });
    </script>
</body>

</html>