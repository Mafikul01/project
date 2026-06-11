<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "crud");
if(mysqli_connect_errno()){
    $_SESSION['error'] = "Failed to connect to MySQL: " . mysqli_connect_error();
    header("Location: products.php");
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
    
    if(!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: update_form.php?id=" . urlencode($id));
        exit;
    }
    
    // Get current product data
    $stmt = $con->prepare("SELECT image FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentProduct = $result->fetch_assoc();
    $stmt->close();
    
    if(!$currentProduct) {
        $_SESSION['error'] = "Product not found";
        header("Location: products.php");
        exit;
    }
    
    $imageToUse = $currentProduct['image']; // Keep existing image by default
    
    // Handle image upload if provided
    if(!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $imageError = $_FILES['image']['error'];
        $imageSize = $_FILES['image']['size'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        
        // Check upload errors
        if($imageError !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = "File upload error: " . ($imageError === UPLOAD_ERR_INI_SIZE ? "File too large" : "Upload failed");
            header("Location: update_form.php?id=" . urlencode($id));
            exit;
        }
        
        // Check file size (5MB max)
        if($imageSize > 5 * 1024 * 1024) {
            $_SESSION['error'] = "Image file size must not exceed 5MB";
            header("Location: update_form.php?id=" . urlencode($id));
            exit;
        }
        
        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $imageTmpName);
        finfo_close($finfo);
        
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        if(!in_array($mimeType, $allowedMimes)) {
            $_SESSION['error'] = "Only JPG, PNG, and WebP images are allowed";
            header("Location: update_form.php?id=" . urlencode($id));
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
            header("Location: update_form.php?id=" . urlencode($id));
            exit;
        }
        
        // Delete old image if it exists and is different
        if($currentProduct['image'] && file_exists($currentProduct['image']) && $currentProduct['image'] !== $targetPath) {
            unlink($currentProduct['image']);
        }
        
        $imageToUse = $targetPath;
    }
    
    // Use prepared statement to prevent SQL injection
    $stmt = $con->prepare("UPDATE products SET name=?, price=?, stock=?, image=? WHERE id=?");
    
    if(!$stmt) {
        $_SESSION['error'] = "Database error: " . $con->error;
        header("Location: update_form.php?id=" . urlencode($id));
        exit;
    }
    
    $stmt->bind_param("sddsi", $name, $price, $stock, $imageToUse, $id);
    
    if($stmt->execute()) {
        $_SESSION['success'] = "Product updated successfully!";
        header("Location: products.php");
        exit;
    } else {
        $_SESSION['error'] = "Error updating product: " . $stmt->error;
        header("Location: update_form.php?id=" . urlencode($id));
        exit;
    }
    
    $stmt->close();
    mysqli_close($con);
} else {
    // Not a POST request
    header("Location: products.php");
    exit;
}
?>