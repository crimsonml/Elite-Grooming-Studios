<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Page - Elite Grooming Studio</title>
    <link rel="stylesheet" href="/EGS/assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>

    <main>
        <div class="product-container">
            <!-- Product Image -->
            <div class="product-image">
                <img src="/EGS/assets/images/oil.jpg" alt="Product Example" />
            </div>

            <!-- Product Details -->
            <div class="product-details">
                <h1 class="product-title">Premium Beard Oil</h1>
                <p class="product-description">
                    Our Premium Beard Oil is made with natural ingredients to keep your beard soft, shiny, and healthy. Designed for all beard types.
                </p>
                <p class="product-price">$19.99</p>

                <!-- Action Buttons -->
                <div class="product-actions">
                    <button class="quantity-button decrease">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="quantity">1</span>
                    <button class="quantity-button increase">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <button class="add-to-cart-button">Add to Cart</button>
                <button class="buy-now-button">Buy Now</button>
            </div>
        </div>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>