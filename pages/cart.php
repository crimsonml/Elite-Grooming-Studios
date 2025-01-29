<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Cart</title>
  <link rel="stylesheet" href="/EGS/assets/css/style.css" />
  <link rel="icon" href="/EGS/assets/images/2.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/header.php'; ?>
  <?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/functions.php';

  $cartItems = getCartItems();
  ?>
  <main>
    <div class="cart-container">
      <h2>Your Cart</h2>
      <div class="cart-content">
        <!-- Cart Items -->
        <div class="cart-items">
          <?php if ($cartItems): ?>
            <?php foreach ($cartItems as $item): ?>
              <div class="cart-item" data-item-id="<?= htmlspecialchars($item['item_id']) ?>">
                <img src="/EGS/assets/itemphotos/<?= htmlspecialchars($item['image_location']) ?>" alt="<?= htmlspecialchars($item['item_name']) ?>" class="cart-item-image" />
                <div class="cart-item-details">
                  <h3><?= htmlspecialchars($item['item_name']) ?></h3>
                  <p class="cart-item-price">$<?= htmlspecialchars($item['price']) ?></p>
                  <div class="cart-item-actions">
                    <button class="quantity-button decrease">
                      <i class="fas fa-minus"></i>
                    </button>
                    <span class="quantity"><?= htmlspecialchars($item['quantity']) ?></span>
                    <button class="quantity-button increase">
                      <i class="fas fa-plus"></i>
                    </button>
                    <button class="delete-button">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Your cart is empty.</p>
          <?php endif; ?>
        </div>

        <!-- Cart Total -->
        <div class="cart-total">
          <h3>Total: $<span id="cart-total-price">0.00</span></h3>
          <form action="/EGS/pages/checkout.php" method="POST">
            <button type="submit" class="checkout-button">Proceed to Checkout</button>
          </form>
        </div>
      </div>
    </div>
  </main>
  <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/elements/footer.php'; ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const cartItems = document.querySelectorAll('.cart-item');
      const cartTotalPrice = document.getElementById('cart-total-price');
      const cartBubble = document.querySelector('.cart-bubble');

      function updateCartTotal() {
        let total = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
          const price = parseFloat(item.querySelector('.cart-item-price').textContent.replace('$', ''));
          const quantity = parseInt(item.querySelector('.quantity').textContent);
          total += price * quantity;
        });
        cartTotalPrice.textContent = total.toFixed(2);
      }

      function updateCartBubble() {
        fetch('/EGS/pages/add_to_cart.php?action=get_cart_count')
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              if (cartBubble) {
                cartBubble.textContent = data.cartItemCount;
              } else {
                const newCartBubble = document.createElement('span');
                newCartBubble.classList.add('cart-bubble');
                newCartBubble.textContent = data.cartItemCount;
                document.querySelector('.cart-icon').appendChild(newCartBubble);
              }
            }
          });
      }

      cartItems.forEach(item => {
        const decreaseButton = item.querySelector('.quantity-button.decrease');
        const increaseButton = item.querySelector('.quantity-button.increase');
        const quantitySpan = item.querySelector('.quantity');
        const deleteButton = item.querySelector('.delete-button');
        const itemId = item.getAttribute('data-item-id');

        decreaseButton.addEventListener('click', function() {
          let quantity = parseInt(quantitySpan.textContent);
          if (quantity > 1) {
            quantitySpan.textContent = quantity - 1;
            updateCartItem(itemId, quantity - 1);
          }
        });

        increaseButton.addEventListener('click', function() {
          let quantity = parseInt(quantitySpan.textContent);
          quantitySpan.textContent = quantity + 1;
          updateCartItem(itemId, quantity + 1);
        });

        deleteButton.addEventListener('click', function() {
          item.remove();
          removeCartItem(itemId);
        });
      });

      function updateCartItem(itemId, quantity) {
        // Update cart item quantity in the database or session
        fetch('/EGS/pages/update_cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            itemId,
            quantity
          })
        }).then(response => response.json()).then(data => {
          if (data.success) {
            updateCartTotal();
            updateCartBubble();
          }
        });
      }

      function removeCartItem(itemId) {
        // Remove cart item from the database or session
        fetch('/EGS/pages/remove_cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            itemId
          })
        }).then(response => response.json()).then(data => {
          if (data.success) {
            updateCartTotal();
            updateCartBubble();
          }
        });
      }

      updateCartTotal();
      updateCartBubble();
    });
  </script>
</body>

</html>