<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elite Grooming Studio</title>
  <link rel="stylesheet" href="/EGS/assets/css/style.css" />
</head>

<body>
  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
  <main>
    <div class="shop-container">
      <h2>Our Products</h2>
      <div class="product-grid">
        <div class="product">
          <img src="/EGS/assets/images/tools.jpg" alt="Product 1" />
          <div class="product-info">
            <h3>Product 1</h3>
            <p>High-quality grooming product for your daily needs.</p>
            <p class="price">$19.99</p>
            <button class="add-to-cart">Add to Cart</button>
          </div>
        </div>
        <div class="product">
          <img src="/EGS/assets/images/oil.jpg" alt="Product 2" />
          <div class="product-info">
            <h3>Product 2</h3>
            <p>Premium beard oil for a smooth and shiny beard.</p>
            <p class="price">$24.99</p>
            <button class="add-to-cart">Add to Cart</button>
          </div>
        </div>
        <div class="product">
          <img src="/EGS/assets/images/cream.jpg" alt="Product 3" />
          <div class="product-info">
            <h3>Product 3</h3>
            <p>Luxury shaving cream for a close and comfortable shave.</p>
            <p class="price">$14.99</p>
            <button class="add-to-cart">Add to Cart</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php require $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>