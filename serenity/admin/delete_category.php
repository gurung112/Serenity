<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: admin_index.php');
    exit;
}

$servername = "localhost";
$username = "root"; // Update if necessary
$password = ""; // Update if necessary
$dbname = "lib";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is set in the URL query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First, delete all books in this category
    $delete_books = $conn->prepare("DELETE FROM books WHERE category_id = ?");
    $delete_books->bind_param("i", $id);
    $delete_books->execute();
    $delete_books->close();

    // Now, delete the category
    $stmt = $conn->prepare("DELETE FROM categories WHERE c_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin_categories.php"); // Redirect back to categories list
        exit;
    } else {
        echo "Error deleting category.";
    }

    $stmt->close();
} else {
    echo "Category ID is required.";
}

$conn->close();
?>
