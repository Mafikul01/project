<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "crud");
if(mysqli_connect_errno()){
    $_SESSION['error'] = "Failed to connect to MySQL: " . mysqli_connect_error();
    header("Location: add_form.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $id = trim($_POST['id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $stock = trim($_POST['stock'] ?? '');
    
    $errors = [];
    
    // Validate fields
    if(empty($id)) $errors[] = "Product ID is required";
    if(empty($name)) $errors[] = "Product Name is required";
    if(empty($price)) $errors[] = "Price is required";
    if(empty($stock)) $errors[] = "Stock Quantity is required";
    
    // Validate file upload
    if(empty($_FILES['image']['name'])) {
        $errors[] = "Product image is required";
    } else {
        $imageName = $_FILES['image']['name'];
        $imageError = $_FILES['image']['error'];
        $imageSize = $_FILES['image']['size'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        
        // Check upload errors
        if($imageError !== UPLOAD_ERR_OK) {
            $errors[] = "File upload error: " . ($imageError === UPLOAD_ERR_INI_SIZE ? "File too large" : "Upload failed");
        }
        
        // Check file size (5MB max)
        if($imageSize > 5 * 1024 * 1024) {
            $errors[] = "Image file size must not exceed 5MB";
        }
        
        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $imageTmpName);
        finfo_close($finfo);
        
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        if(!in_array($mimeType, $allowedMimes)) {
            $errors[] = "Only JPG, PNG, and WebP images are allowed";
        }
    }
    
    if(!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: add_form.php");
        exit;
    }
    
    // Create images directory if it doesn't exist
    if(!is_dir('images')) {
        mkdir('images', 0755, true);
    }
    
    // Generate unique filename
    $fileExt = pathinfo($imageName, PATHINFO_EXTENSION);
    $uniqueFilename = 'product_' . time() . '_' . mt_rand(1000, 9999) . '.' . $fileExt;
    $targetPath = "images/" . $uniqueFilename;
    
    // Move uploaded file
    if(!move_uploaded_file($imageTmpName, $targetPath)) {
        $_SESSION['error'] = "Failed to save image file";
        header("Location: add_form.php");
        exit;
    }
    
    // Use prepared statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO products (id, name, price, stock, image) VALUES (?, ?, ?, ?, ?)");
    
    if(!$stmt) {
        $_SESSION['error'] = "Database error: " . $con->error;
        unlink($targetPath); // Delete uploaded file if query prep fails
        header("Location: add_form.php");
        exit;
    }
    
    $stmt->bind_param("isdis", $id, $name, $price, $stock, $targetPath);
    
    if($stmt->execute()) {
        $_SESSION['success'] = "Product added successfully!";
        header("Location: products.php");
        exit;
    } else {
        $_SESSION['error'] = "Error adding product: " . $stmt->error;
        unlink($targetPath); // Delete uploaded file if insert fails
        header("Location: add_form.php");
        exit;
    }
    
    $stmt->close();
    mysqli_close($con);
} else {
    // Not a POST request
    header("Location: add_form.php");
    exit;
}
?>