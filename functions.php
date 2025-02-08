<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/secrets.php';

function connectDB()
{
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}


function registerUser($fullName, $email, $username, $password, $confirmPassword)
{
    // Check if passwords match
    if ($password !== $confirmPassword) {
        return ['success' => false, 'message' => 'Passwords do not match'];
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Connect to the database
    $pdo = connectDB();

    try {
        // Check if email or username already exists
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email OR username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':username' => $username
        ]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            return ['success' => false, 'message' => 'Email or username already exists'];
        }

        // Insert the new user
        $sql = "INSERT INTO users (full_name, email, username, password) VALUES (:full_name, :email, :username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':full_name' => $fullName,
            ':email' => $email,
            ':username' => $username,
            ':password' => $hashedPassword
        ]);

        // Redirect to login page
        header("Location: /EGS/pages/logIn.php");
        exit();

        return ['success' => true, 'message' => 'Signup successful'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

function loginUser($username, $password)
{
    $pdo = connectDB();

    try {
        // Query the database for the user
        $sql = "SELECT * FROM users WHERE username = :username OR email = :username LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Check if the account is active
                if (!$user['is_active']) {
                    return ['success' => false, 'message' => 'Account is deactivated. Contact support.'];
                }

                // Start session and set user data
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username']; // Save username in session
                $_SESSION['email'] = $user['email']; // Save email in session
                $_SESSION['role'] = $user['role']; // Useful for admin pages

                return ['success' => true, 'message' => 'Login successful'];
            } else {
                return ['success' => false, 'message' => 'Incorrect password'];
            }
        } else {
            return ['success' => false, 'message' => 'User not found'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

function getUserDetails($userId)
{
    $pdo = connectDB();

    try {
        $sql = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        return false;
    }
}

function updateUserDetails($userId, $fullName, $email, $phone, $address)
{
    $pdo = connectDB();

    try {
        // Check if the new email already exists
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email AND user_id != :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email, ':user_id' => $userId]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            return ['success' => false, 'message' => 'Email is already registered'];
        }

        // Update user details
        $sql = "UPDATE users SET full_name = :full_name, email = :email, phone = :phone, address = :address WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':full_name' => $fullName,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':user_id' => $userId
        ]);

        return ['success' => true, 'message' => 'Profile updated successfully'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

function changeUserPassword($userId, $currentPassword, $newPassword)
{
    $pdo = connectDB();

    try {
        // Get the current password hash from the database
        $sql = "SELECT password FROM users WHERE user_id = :user_id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $user = $stmt->fetch();

        if ($user && password_verify($currentPassword, $user['password'])) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // Update the password in the database
            $sql = "UPDATE users SET password = :password WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':password' => $hashedPassword,
                ':user_id' => $userId
            ]);

            return ['success' => true, 'message' => 'Password updated successfully'];
        } else {
            return ['success' => false, 'message' => 'Current password is incorrect'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}
function logoutUser()
{
    session_start();
    session_unset();
    session_destroy();
    header("Location: /EGS/pages/login.php");
    exit();
}

function recordAppointment($userId, $name, $email, $phone, $preferredDate, $preferredTime, $service)
{
    $pdo = connectDB();

    try {
        $sql = "INSERT INTO appointments (user_id, name, email, phone, preferred_date, preferred_time, service) 
                VALUES (:user_id, :name, :email, :phone, :preferred_date, :preferred_time, :service)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':preferred_date' => $preferredDate,
            ':preferred_time' => $preferredTime,
            ':service' => $service
        ]);

        return ['success' => true, 'message' => 'Appointment booked successfully'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

function getItems($page = 1, $itemsPerPage = 20)
{
    $pdo = connectDB();

    try {
        $offset = ($page - 1) * $itemsPerPage;
        $sql = "SELECT * FROM items ORDER BY item_name ASC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return false;
    }
}

function getItemDetails($itemId)
{
    $pdo = connectDB();

    try {
        $sql = "SELECT * FROM items WHERE item_id = :item_id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':item_id' => $itemId]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        return false;
    }
}

function addToCart($itemId, $quantity = 1)
{
    $pdo = connectDB();

    if (isset($_SESSION['user_id'])) {
        // User is logged in, store cart items in the database
        $userId = $_SESSION['user_id'];

        try {
            // Check if the user has a cart
            $sql = "SELECT cart_id FROM carts WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $cart = $stmt->fetch();

            if (!$cart) {
                // Create a new cart for the user
                $sql = "INSERT INTO carts (user_id) VALUES (:user_id)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':user_id' => $userId]);
                $cartId = $pdo->lastInsertId();
            } else {
                $cartId = $cart['cart_id'];
            }

            // Check if the item is already in the cart
            $sql = "SELECT * FROM cart_items WHERE cart_id = :cart_id AND item_id = :item_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':cart_id' => $cartId, ':item_id' => $itemId]);
            $cartItem = $stmt->fetch();

            if ($cartItem) {
                // Update the quantity if the item is already in the cart
                $sql = "UPDATE cart_items SET quantity = quantity + :quantity WHERE cart_id = :cart_id AND item_id = :item_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':quantity' => $quantity, ':cart_id' => $cartId, ':item_id' => $itemId]);
            } else {
                // Insert the new item into the cart
                $sql = "INSERT INTO cart_items (cart_id, item_id, quantity) VALUES (:cart_id, :item_id, :quantity)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':cart_id' => $cartId, ':item_id' => $itemId, ':quantity' => $quantity]);
            }

            return ['success' => true, 'message' => 'Item added to cart'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    } else {
        // User is not logged in, store cart items in the session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$itemId])) {
            $_SESSION['cart'][$itemId] += $quantity;
        } else {
            $_SESSION['cart'][$itemId] = $quantity;
        }

        return ['success' => true, 'message' => 'Item added to cart'];
    }
}

function getCartItems()
{
    $pdo = connectDB();

    if (isset($_SESSION['user_id'])) {
        // User is logged in, retrieve cart items from the database
        $userId = $_SESSION['user_id'];

        try {
            $sql = "SELECT ci.item_id, ci.quantity, i.item_name, i.price, i.image_location
                    FROM cart_items ci
                    JOIN items i ON ci.item_id = i.item_id
                    JOIN carts c ON ci.cart_id = c.cart_id
                    WHERE c.user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    } else {
        // User is not logged in, retrieve cart items from the session
        if (!isset($_SESSION['cart'])) {
            return [];
        }

        $cartItems = [];
        foreach ($_SESSION['cart'] as $itemId => $quantity) {
            try {
                $sql = "SELECT item_id, item_name, price, image_location FROM items WHERE item_id = :item_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':item_id' => $itemId]);
                $item = $stmt->fetch();
                if ($item) {
                    $item['quantity'] = $quantity;
                    $cartItems[] = $item;
                }
            } catch (PDOException $e) {
                return false;
            }
        }

        return $cartItems;
    }
}

function getCartItemCount()
{
    $cartItems = getCartItems();
    $totalQuantity = 0;

    foreach ($cartItems as $item) {
        $totalQuantity += $item['quantity'];
    }

    return $totalQuantity;
}

function clearCart($userId)
{
    $pdo = connectDB();

    try {
        if ($userId) {
            // User is logged in, clear cart items from the database
            $sql = "SELECT cart_id FROM carts WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $cart = $stmt->fetch();

            if ($cart) {
                $cartId = $cart['cart_id'];

                // Delete cart items
                $sql = "DELETE FROM cart_items WHERE cart_id = :cart_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':cart_id' => $cartId]);
            }
        } else {
            // User is not logged in, clear cart items from the session
            unset($_SESSION['cart']);
        }
    } catch (PDOException $e) {
        return false;
    }
}

function getOrderDetails($orderId)
{
    $pdo = connectDB();

    try {
        $sql = "SELECT * FROM orders WHERE order_id = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        return false;
    }
}

// Function to get recent orders for a given user (limit defaults to 10)
function getRecentOrders($userId, $limit = 10)
{
    $pdo = connectDB();
    try {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return false;
    }
}

// Function to get order items for a given order id
function getOrderItems($orderId)
{
    $pdo = connectDB();
    try {
        $sql = "SELECT oi.*, i.item_name 
                FROM order_items oi 
                LEFT JOIN items i ON oi.item_id = i.item_id 
                WHERE oi.order_id = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return false;
    }
}

function storeOrder($userId, $guestData, $totalAmount, $cartItems, $sessionId)
{
    $pdo = connectDB();

    try {
        // Start a transaction
        $pdo->beginTransaction();

        if ($guestData) {
            // Insert guest details into guest_orders table
            $sql = "INSERT INTO guest_orders (full_name, email, phone, address, created_at) VALUES (:full_name, :email, :phone, :address, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':full_name' => $guestData['full_name'],
                ':email' => $guestData['email'],
                ':phone' => $guestData['phone'],
                ':address' => $guestData['address']
            ]);
            $guestId = $pdo->lastInsertId();
        } else {
            $guestId = null;
        }

        // Insert the order into the orders table
        $sql = "INSERT INTO orders (user_id, guest_id, total_amount, order_status, created_at, session_id) VALUES (:user_id, :guest_id, :total_amount, 'Pending', NOW(), :session_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':guest_id' => $guestId,
            ':total_amount' => $totalAmount,
            ':session_id' => $sessionId
        ]);

        // Get the order ID of the newly created order
        $orderId = $pdo->lastInsertId();

        // Insert each cart item into the order_items table
        foreach ($cartItems as $item) {
            $sql = "INSERT INTO order_items (order_id, item_id, item_name, price, quantity, subtotal) VALUES (:order_id, :item_id, :item_name, :price, :quantity, :subtotal)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':order_id' => $orderId,
                ':item_id' => $item['item_id'],
                ':item_name' => $item['item_name'],
                ':price' => $item['price'],
                ':quantity' => $item['quantity'],
                ':subtotal' => $item['price'] * $item['quantity']
            ]);
        }

        // Commit the transaction
        $pdo->commit();

        return $orderId;
    } catch (PDOException $e) {
        // Rollback the transaction if something goes wrong
        $pdo->rollBack();
        return false;
    }
}
