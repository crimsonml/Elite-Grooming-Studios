<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elite Grooming Studio</title>
  <link rel="stylesheet" href="/EGS/assets/css/style.css" />
  <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
</head>

<body>
  <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
  <?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

  // Get the current page number from the query string, default to 1 if not set
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

  // Retrieve items for the current page
  $items = getItems($page);

  // Calculate the total number of pages
  $totalItems = count($items);
  $itemsPerPage = 20;
  $totalPages = ceil($totalItems / $itemsPerPage);

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $itemId = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
    $result = addToCart($itemId);
  }
  ?>
  <main>
    <div class="shop-container">
      <h2>Our Products</h2>
      <div class="product-grid">
        <?php foreach ($items as $item): ?>
          <div class="product">
            <a href="/EGS/pages/product.php?id=<?= htmlspecialchars($item['item_id']) ?>" class="product-link">
              <img src="/EGS/assets/itemphotos/<?= htmlspecialchars($item['image_location']) ?>" alt="<?= htmlspecialchars($item['item_name']) ?>" />
              <div class="product-info">
                <h3><?= htmlspecialchars($item['item_name']) ?></h3>
                <p><?= htmlspecialchars($item['small_description']) ?></p>
                <p class="price">$<?= htmlspecialchars($item['price']) ?></p>
              </div>
            </a>
            <form method="POST" action="">
              <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['item_id']) ?>">
              <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
      <!-- Pagination -->
      <div class="pagination">
        <?php if ($page > 1): ?>
          <a href="?page=<?= $page - 1 ?>">&laquo; Previous</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
          <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
</body>

</html>