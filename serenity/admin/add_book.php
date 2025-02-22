<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: admin_index.php');
    exit;
}

include('config.php');

// Fetch authors and categories for the dropdowns
$authors_sql = "SELECT * FROM author";
$authors_result = $mysqli->query($authors_sql);

$categories_sql = "SELECT * FROM categories";
$categories_result = $mysqli->query($categories_sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $author_id = $_POST['author_id'];
    $year = $_POST['year'];
    $category_id = $_POST['category_id'];
    $description = trim($_POST['description']);
    $book_url = trim($_POST['book_url']);
    $image = $_FILES['image'];

    // Ensure the 'admin/images/' directory exists
    $target_dir = "../admin/uploads/"; // Correct folder for storage
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true); // Creates directory if missing
    }

    // Handle image upload
    $image_path = null;
    if (!empty($image['name'])) {
        $image_name = time() . "_" . basename($image['name']); // Unique filename
        $image_path = $target_dir . $image_name;

        if (!move_uploaded_file($image['tmp_name'], $image_path)) {
            $error_message = "Error uploading the image.";
        }
    }

    // Validate required fields
    if (!empty($title) && !empty($author_id) && !empty($year) && !empty($category_id) && !empty($description)) {
        $sql = "INSERT INTO books (title, year, category_id, status, description, b_image, book_url) 
                VALUES (?, ?, ?, 'Available', ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('siisss', $title, $year, $category_id, $description, $image_path, $book_url);

        if ($stmt->execute()) {
            $book_id = $stmt->insert_id; // Get the last inserted book ID

            // Insert request into book_requests table
            $user_id = $_SESSION['user_id']; // Get logged-in user ID
            $request_date = date('Y-m-d H:i:s'); // Current timestamp

            $request_sql = "INSERT INTO book_requests (user_id, book_id, a_id, status, request_date) 
                            VALUES (?, ?, ?, 'Pending', ?)";
            $request_stmt = $mysqli->prepare($request_sql);
            $request_stmt->bind_param('iiis', $user_id, $book_id, $author_id, $request_date);
            
            if ($request_stmt->execute()) {
                header('Location: admin_library.php');
                exit;
            } else {
                $error_message = "Error adding book request.";
            }
        } else {
            $error_message = "Error adding book. Please try again.";
        }
    } else {
        $error_message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serenity</title>
    <link rel="icon" type="image/jpg" href="../images/logo.jpg">
    <link rel="stylesheet" href="abc.css">
    <link rel="stylesheet" href="addcategory.css">
    <link rel="stylesheet" href="scrolling.css">
</head>
<body>
    <div class="heading">
        <img src="../images/logo.jpg" style="width: 150px; height: 90px; border-radius: 10%;">
        <a href="logout.php">Logout</a>
    </div>
    <div class="navbar">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_library.php">Library</a>
        <a href="admin_categories.php">Categories</a>
        <a href="admin_author.php">Author</a>
        <a href="admin_usermanagement.php">User Management</a>
    </div>
    <div class="content">
        <h1>Add New Book</h1>

        <?php if (isset($error_message)) : ?>
            <p style="color:red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form method="POST" action="add_book.php" enctype="multipart/form-data">
            <label for="title">Book Title:</label>
            <input type="text" name="title" id="title" required>
            
            <label for="author_id">Author:</label>
            <select name="author_id" id="author_id" required>
                <option value="">Select Author</option>
                <?php while ($author = $authors_result->fetch_assoc()) : ?>
                    <option value="<?php echo $author['a_id']; ?>"><?php echo $author['a_name']; ?></option>
                <?php endwhile; ?>
            </select>
            
            <label for="year">Year:</label>
            <input type="number" name="year" id="year" required>
            
            <label for="category_id">Category:</label>
            <select name="category_id" id="category_id" required>
                <option value="">Select Category</option>
                <?php while ($category = $categories_result->fetch_assoc()) : ?>
                    <option value="<?php echo $category['c_id']; ?>"><?php echo $category['c_name']; ?></option>
                <?php endwhile; ?>
            </select>
            
            <label for="book_url">Book URL:</label>
            <input type="url" name="book_url" id="book_url" placeholder="Enter book URL" required>
            
            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" required></textarea>

            <label for="image">Book Image:</label>
            <input type="file" name="image" id="image" accept="image/*">

            <button type="submit">Add Book</button>
        </form>
    </div>
</body>
</html>
