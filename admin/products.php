<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin Panel</title>
    <link rel="stylesheet" href="adminPanel.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('adminFunctions.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    const tableBody = document.querySelector('table tbody');
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.item_id}</td>
                            <td>${item.item_name}</td>
                            <td>${item.price}</td>
                            <td>${item.stock}</td>
                            <td>
                                <button onclick="openUpdateModal(${item.item_id})">Update</button>
                                <button onclick="deleteItem(${item.item_id})">Delete</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        });

        function openUpdateModal(id) {
            // Fetch item details and open modal for updating
            fetch(`adminFunctions.php?id=${id}`)
                .then(response => response.json())
                .then(item => {
                    document.getElementById('update-id').value = item.item_id;
                    document.getElementById('update-name').value = item.item_name;
                    document.getElementById('update-name').placeholder = item.item_name;
                    document.getElementById('update-small-description').value = item.small_description;
                    document.getElementById('update-small-description').placeholder = item.small_description;
                    document.getElementById('update-long-description').value = item.long_description;
                    document.getElementById('update-long-description').placeholder = item.long_description;
                    document.getElementById('update-price').value = item.price;
                    document.getElementById('update-price').placeholder = item.price;
                    document.getElementById('update-stock').value = item.stock;
                    document.getElementById('update-stock').placeholder = item.stock;
                    document.getElementById('update-modal').style.display = 'block';
                });
        }

        function updateItem() {
            const formData = new FormData();
            formData.append('id', document.getElementById('update-id').value);
            formData.append('name', document.getElementById('update-name').value);
            formData.append('small_description', document.getElementById('update-small-description').value);
            formData.append('long_description', document.getElementById('update-long-description').value);
            formData.append('price', document.getElementById('update-price').value);
            formData.append('stock', document.getElementById('update-stock').value);
            const imageFile = document.getElementById('update-image').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            fetch('adminFunctions.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                });
        }

        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                fetch('adminFunctions.php', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${id}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    });
            }
        }

        function openAddModal() {
            document.getElementById('add-modal').style.display = 'block';
        }

        function addItem() {
            const formData = new FormData();
            formData.append('name', document.getElementById('add-name').value);
            formData.append('small_description', document.getElementById('add-small-description').value);
            formData.append('long_description', document.getElementById('add-long-description').value);
            formData.append('price', document.getElementById('add-price').value);
            formData.append('stock', document.getElementById('add-stock').value);
            formData.append('image', document.getElementById('add-image').files[0]);

            fetch('adminFunctions.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                });
        }
    </script>
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
            <button onclick="openAddModal()">Add Product</button>
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
                <!-- Product list here -->
            </tbody>
        </table>
    </main>

    <!-- Add Modal -->
    <div id="add-modal" style="display:none;">
        <h2>Add Item</h2>
        <form onsubmit="event.preventDefault(); addItem();" enctype="multipart/form-data">
            <label for="add-name">Name:</label>
            <input type="text" id="add-name" required>
            <label for="add-small-description">Small Description:</label>
            <input type="text" id="add-small-description" required>
            <label for="add-long-description">Long Description:</label>
            <textarea id="add-long-description" required></textarea>
            <label for="add-price">Price:</label>
            <input type="number" id="add-price" required>
            <label for="add-stock">Stock:</label>
            <input type="number" id="add-stock" required>
            <label for="add-image">Image:</label>
            <input type="file" id="add-image" required>
            <button type="submit">Add</button>
            <button type="button" onclick="document.getElementById('add-modal').style.display='none';">Cancel</button>
        </form>
    </div>

    <!-- Update Modal -->
    <div id="update-modal" style="display:none;">
        <h2>Update Item</h2>
        <form onsubmit="event.preventDefault(); updateItem();" enctype="multipart/form-data">
            <input type="hidden" id="update-id">
            <label for="update-name">Name:</label>
            <input type="text" id="update-name" required>
            <label for="update-small-description">Small Description:</label>
            <input type="text" id="update-small-description" required>
            <label for="update-long-description">Long Description:</label>
            <textarea id="update-long-description" required></textarea>
            <label for="update-price">Price:</label>
            <input type="number" id="update-price" required>
            <label for="update-stock">Stock:</label>
            <input type="number" id="update-stock" required>
            <label for="update-image">Image:</label>
            <input type="file" id="update-image">
            <button type="submit">Update</button>
            <button type="button" onclick="document.getElementById('update-modal').style.display='none';">Cancel</button>
        </form>
    </div>
</body>

</html>