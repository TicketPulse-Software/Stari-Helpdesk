<?php
session_start();
include_once 'db.php';

function register($username, $password, $role) {
    $conn = db_connect();
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hash, $role);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function login($username, $password) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hash, $role);
    $stmt->fetch();
    if (password_verify($password, $hash)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['role'] = $role;
        return true;
    } else {
        return false;
    }
}

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /public/login.php');
        exit();
    }
}
?>
