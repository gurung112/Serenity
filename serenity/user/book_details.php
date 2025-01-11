<?php
session_start();
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit;
}

// Get the book ID from the URL
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Fetch book details from the database
    $query = "SELECT b.book_id, b.title, b.year, b.status, b.category_id, b.description, b.b_image, 
                     b.book_url, a.a_name, a.a_id, c.c_name 
              FROM books b 
            JOIN book_requests br ON b.book_id=br.book_id
            JOIN author a ON br.a_id = a.a_id
            JOIN categories c ON b.category_id = c.c_id
              WHERE b.book_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    // If no book is found
    if (!$book) {
        header('Location: user_books.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link rel="stylesheet" href="css/user_home.css">
    <link rel="stylesheet" href="css/book_details.css">
    <link rel="stylesheet" href="css/img.css">
</head>
<body>
    <div class="navbar">
        <h1>Library Management System</h1>
        <a href="user_home.php">Home</a>
        <a href="user_books.php">Books</a>
        <a href="user_profile.php">Profile</a>
        <a href="user_change_password.php">Change Password</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="book-details-container">
        <!-- Book Image -->
        <?php if (!empty($book['b_image'])): ?>
            <div class="book-image">
                <img src="<?php echo htmlspecialchars($book['b_image']); ?>" alt="Book Image">
            </div>
        <?php endif; ?>

        <!-- Book Title -->
        <h1><?php echo htmlspecialchars($book['title']); ?></h1>

        <p><strong>Author:</strong> <?php echo htmlspecialchars($book['a_name']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($book['c_name']); ?></p>
        <p><strong>Year:</strong> <?php echo htmlspecialchars($book['year']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($book['description']); ?></p>

        <!-- New message and dynamic link below description -->
        <?php if (!empty($book['book_url'])): ?>
            <p>Want to read this book? <a href="<?php echo htmlspecialchars($book['book_url']); ?>" target="_blank">Click here</a></p>
        <?php else: ?>
            <p>Want to read this book? The link is not available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
