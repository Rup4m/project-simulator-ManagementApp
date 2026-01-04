<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($role == "" || $email == "" || $password == "") {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        if ($role === "admin") {
            if ($email === "admin@krishibazar.com" && $password === "1234") {
                $_SESSION['user_role'] = 'admin';
                $_SESSION['admin_email'] = $email;
                header("Location: ../html/admin_dashboard.php");
                exit;
            } else {
                $error = "Invalid admin credentials.";
            }
        }

        if ($role === "seller") {
            $_SESSION['user_role'] = 'seller';
            $_SESSION['seller_id'] = 1;
            $_SESSION['seller_email'] = $email;

            setcookie("user_role", "seller", time() + 3600, "/");
            setcookie("user_email", $email, time() + 3600, "/");

            header("Location: ../html/seller_dashboard.php");
            exit;
        }

        if ($role === "customer") {
            $_SESSION['user_role'] = 'customer';
            $_SESSION['customer_id'] = 1;
            $_SESSION['customer_email'] = $email;

            setcookie("user_role", "customer", time() + 3600, "/");
            setcookie("user_email", $email, time() + 3600, "/");

            header("Location: ../html/customer_dashboard.php");
            exit;
        }
    }
}


$_SESSION['login_error'] = $error;
header("Location: ../html/login.php");
exit();
?>
