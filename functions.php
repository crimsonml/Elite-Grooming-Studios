<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EGS/db_config.php';

function connectDB()
{
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS
        );
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
