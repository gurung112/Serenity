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
    $book_url = trim($_POST['book_url']);  // New field for book URL
    $image = $_FILES['image'];

    // Handle image upload and set path to 'admin/uploads/'
    $image_path = null;
    if (!empty($image['name'])) {
        $target_dir = __DIR__ . "/admin/uploads/";  // Save in admin/uploads folder
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);  // Create directory if not exists
        }
        $image_path = "admin/uploads/" . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $target_dir . basename($image['name']));
    }

    // Validate required fields
    if (!empty($title) && !empty($author_id) && !empty($year) && !empty($category_id) && !empty($description)) {
        $sql = "INSERT INTO books (title, year, category_id, status, description, b_image, book_url) 
        VALUES (?, ?, ?, 'Available', ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('siisss', $title, $year, $category_id, $description, $image_path, $book_url);


        if ($stmt->execute()) {
            header('Location: admin_library.php');
            exit;
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
    <title>Add Book</title>
    <link rel="stylesheet" href="abc.css">
    <link rel="stylesheet" href="addcategory.css">
</head>
<body>
    <div class="heading">
        <h1>PEACE</h1>
        <a href="logout.php">Logout</a>
    </div>
    <div class="navbar">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_library.php">Library</a>
        <a href="admin_categories.php">Categories</a>
        <a href="admin_author.php">Author</a>
        <a href="admin_bookrequest.php">Book Requests</a>
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
            
            <!-- New Book URL Field -->
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
