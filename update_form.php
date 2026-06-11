<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product | ModernStore</title>
    <link rel="stylesheet" href="css.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        .message-box {
            margin: 20px auto;
            padding: 16px 20px;
            max-width: 1200px;
            border-radius: 8px;
            font-size: 15px;
            animation: slideDown 0.3s ease-out;
        }
        .message-box.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message-box.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .current-image-section {
            margin-bottom: var(--spacing-lg);
            padding-bottom: var(--spacing-lg);
            border-bottom: 1px solid var(--border);
        }
        .current-image {
            max-width: 150px;
            height: auto;
            border-radius: 8px;
            border: 2px solid var(--border);
        }
        .current-image-label {
            display: block;
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: var(--spacing-sm);
            font-weight: 500;
        }
    </style>
</head>
<body>
    <?php session_start(); ?>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <h1 class="logo">ModernStore</h1>
            </div>
            <div class="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="products.php" class="nav-link">Shop</a>
                <a href="add_form.php" class="nav-link active">Admin</a>
            </div>
            <div class="nav-actions">
                <button class="cart-icon">🛒</button>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-content">
            <h1>Update Product</h1>
            <p>Modify product details and pricing</p>
        </div>
    </section>

    <!-- Messages -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="message-box error">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if(isset($_SESSION['success'])): ?>
        <div class="message-box success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Form Container -->
    <section class="form-page">
        <div class="form-wrapper">
            <div class="form-card">
                <?php
                $con = mysqli_connect("localhost", "root", "", "crud");
                if(!mysqli_connect_errno()){
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM products WHERE id='$id'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    
                    if($row) {
                        ?>
                        <form method="post" action="update.php" enctype="multipart/form-data" class="product-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="id">Product ID</label>
                                    <input type="number" id="id" name="id" value="<?php echo $row['id']; ?>" readonly style="background:#f0f0f0; cursor:not-allowed;">
                                    <small>This ID cannot be changed</small>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group full-width">
                                    <div class="current-image-section">
                                        <span class="current-image-label">📸 Current Image</span>
                                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="current-image">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Product Name *</label>
                                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" maxlength="100" required>
                                    <small>Keep it clear and descriptive</small>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="price">Price (USD) *</label>
                                    <div class="price-input-wrapper">
                                        <span class="currency">$</span>
                                        <input type="number" id="price" name="price" step="0.01" value="<?php echo $row['price']; ?>" min="0" required>
                                    </div>
                                    <small>Update pricing as needed</small>
                                </div>

                                <div class="form-group">
                                    <label for="stock">Stock Quantity *</label>
                                    <input type="number" id="stock" name="stock" value="<?php echo $row['stock']; ?>" min="0" required>
                                    <small>Current inventory level</small>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label for="image">Product Image (Optional)</label>
                                    <div class="file-input-wrapper">
                                        <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
                                        <div class="file-hint">
                                            <p>📷 Click to upload or drag & drop</p>
                                            <small>JPG, PNG, or WebP (max 5MB) - Leave empty to keep current image</small>
                                        </div>
                                    </div>
                                    <div id="imagePreview" class="image-preview"></div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-lg">💾 Save Changes</button>
                                <a href="products.php" class="btn btn-secondary btn-lg">Cancel</a>
                            </div>
                        </form>
                        <?php
                    } else {
                        echo '<div class="error-message">Product not found</div>';
                    }
                    mysqli_close($con);
                }
                ?>
            </div>

            <div class="form-info-panel">
                <h3>Update Guidelines</h3>
                <ul>
                    <li>Update product names for clarity</li>
                    <li>Adjust prices to match market</li>
                    <li>Keep stock quantities accurate</li>
                    <li>Changes take effect immediately</li>
                    <li>Review before saving</li>
                </ul>
                <div class="info-box">
                    <p><strong>Need help?</strong></p>
                    <p>Check with your inventory manager for pricing questions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>About Us</h4>
                <p>ModernStore brings premium products to your doorstep with exceptional customer service.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="products.php">Shop</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Shipping Info</a></li>
                    <li><a href="#">Returns</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 ModernStore. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const fileInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const fileWrapper = document.querySelector('.file-input-wrapper');
        
        // Click to open file explorer
        fileWrapper.addEventListener('click', function(e) {
            if (e.target !== fileInput) {
                fileInput.click();
            }
        });
        
        fileInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.innerHTML = '<img src="' + event.target.result + '" alt="Preview">';
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileWrapper.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileWrapper.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileWrapper.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            fileWrapper.classList.add('highlight');
        }

        function unhighlight(e) {
            fileWrapper.classList.remove('highlight');
        }

        fileWrapper.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    </script>
</body>
</html>