<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Cart</title>
  <link rel="stylesheet" href="/EGS/assets/css/style.css" />
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
  <main>
    <div class="cart-container">
      <h2>Your Cart</h2>
      <div class="cart-content">
        <!-- Cart Items -->
        <div class="cart-items">
          <div class="cart-item">
            <img src="/EGS/assets/images/tools.jpg" alt="Product 1" class="cart-item-image" />
            <div class="cart-item-details">
              <h3>Product 1</h3>
              <p class="cart-item-price">$19.99</p>
              <div class="cart-item-actions">
                <button class="quantity-button decrease">
                  <i class="fas fa-minus"></i>
                </button>
                <span class="quantity">1</span>
                <button class="quantity-button increase">
                  <i class="fas fa-plus"></i>
                </button>
                <button class="delete-button">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="cart-item">
            <img src="/EGS/assets/images/oil.jpg" alt="Product 2" class="cart-item-image" />
            <div class="cart-item-details">
              <h3>Product 2</h3>
              <p class="cart-item-price">$24.99</p>
              <div class="cart-item-actions">
                <button class="quantity-button decrease">
                  <i class="fas fa-minus"></i>
                </button>
                <span class="quantity">2</span>
                <button class="quantity-button increase">
                  <i class="fas fa-plus"></i>
                </button>
                <button class="delete-button">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Cart Total -->
        <div class="cart-total">
          <h3>Total: $84.96</h3>
          <button class="checkout-button">Proceed to Checkout</button>
        </div>
      </div>
    </div>
  </main>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>