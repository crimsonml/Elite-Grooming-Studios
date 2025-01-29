<?php
require_once 'adminFunctions.php';
$products = fetchProducts($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin Panel</title>
    <link rel="stylesheet" href="adminPanel.css">
</head>

<body>
    <header class="admin-header">
        <h1>Products</h1>
        <nav class="admin-nav">
            <ul>
                <li><a href="panelDash.php">Dashboard</a></li>
                <li><a href="/EGS/index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="/EGS/pages/login.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Manage Products</h2>
        <div>
            <button onclick="document.getElementById('add-modal').style.display='block'">Add Product</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['item_id']) ?></td>
                        <td><?= htmlspecialchars($product['item_name']) ?></td>
                        <td><?= htmlspecialchars($product['price']) ?></td>
                        <td><?= htmlspecialchars($product['stock']) ?></td>
                        <td>
                            <button onclick="openUpdateModal(<?= htmlspecialchars(json_encode($product)) ?>)">Update</button>
                            <button onclick="openDeleteModal(<?= $product['item_id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <!-- Add Modal -->
    <div id="add-modal" style="display:none;">
        <h2>Add Item</h2>
        <form id="add-product-form" enctype="multipart/form-data">
            <label for="add-name">Name:</label>
            <input type="text" id="add-name" name="name" required>
            <label for="add-small-description">Small Description:</label>
            <input type="text" id="add-small-description" name="small_description" required>
            <label for="add-long-description">Long Description:</label>
            <textarea id="add-long-description" name="long_description" required></textarea>
            <label for="add-price">Price:</label>
            <input type="number" id="add-price" name="price" required>
            <label for="add-stock">Stock:</label>
            <input type="number" id="add-stock" name="stock" required>
            <label for="add-image">Image:</label>
            <input type="file" id="add-image" name="image" accept="image/*" required>
            <button type="button" onclick="document.getElementById('add-modal').style.display='none';">Cancel</button>
            <button type="submit">Add</button>
        </form>
    </div>

    <!-- Update Modal -->
    <div id="update-modal" style="display:none;">
        <h2>Update Item</h2>
        <form id="update-product-form" enctype="multipart/form-data">
            <input type="hidden" id="update-id" name="id">
            <label for="update-name">Name:</label>
            <input type="text" id="update-name" name="name">
            <label for="update-small-description">Small Description:</label>
            <input type="text" id="update-small-description" name="small_description">
            <label for="update-long-description">Long Description:</label>
            <textarea id="update-long-description" name="long_description"></textarea>
            <label for="update-price">Price:</label>
            <input type="number" id="update-price" name="price">
            <label for="update-stock">Stock:</label>
            <input type="number" id="update-stock" name="stock">
            <label for="update-image">Image:</label>
            <input type="file" id="update-image" name="image" accept="image/*">
            <button type="button" onclick="document.getElementById('update-modal').style.display='none';">Cancel</button>
            <button type="submit">Update</button>
        </form>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" style="display:none;">
        <h2>Delete Item</h2>
        <p>Do you want to delete this item?</p>
        <form id="delete-product-form">
            <input type="hidden" id="delete-id" name="id">
            <button type="button" onclick="document.getElementById('delete-modal').style.display='none';">Cancel</button>
            <button type="submit">Delete</button>
        </form>
    </div>

    <script>
        function openUpdateModal(product) {
            document.getElementById('update-id').value = product.item_id;
            document.getElementById('update-name').placeholder = product.item_name;
            document.getElementById('update-small-description').placeholder = product.small_description;
            document.getElementById('update-long-description').placeholder = product.long_description;
            document.getElementById('update-price').placeholder = product.price;
            document.getElementById('update-stock').placeholder = product.stock;
            document.getElementById('update-modal').style.display = 'block';
        }

        function openDeleteModal(id) {
            document.getElementById('delete-id').value = id;
            document.getElementById('delete-modal').style.display = 'block';
        }

        document.getElementById('add-product-form').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('addProduct.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product added successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        document.getElementById('update-product-form').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('updateProduct.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product updated successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        document.getElementById('delete-product-form').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('deleteProduct.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product deleted successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
</body>

</html>