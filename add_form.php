<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | ModernStore</title>
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
            <h1>Add New Product</h1>
            <p>Expand your catalog with a new premium item</p>
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
                <form action="add.php" method="post" enctype="multipart/form-data" class="product-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="id">Product ID *</label>
                            <input type="number" id="id" name="id" placeholder="Enter unique product ID" required>
                            <small>Must be unique and cannot be changed later</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Product Name *</label>
                            <input type="text" id="name" name="name" placeholder="Enter product name" maxlength="100" required>
                            <small>Keep it clear and descriptive (max 100 characters)</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Price (USD) *</label>
                            <div class="price-input-wrapper">
                                <span class="currency">$</span>
                                <input type="number" id="price" name="price" step="0.01" placeholder="0.00" min="0" required>
                            </div>
                            <small>Enter the selling price</small>
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock Quantity *</label>
                            <input type="number" id="stock" name="stock" placeholder="0" min="0" required>
                            <small>Number of units available</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="image">Product Image *</label>
                            <div class="file-input-wrapper">
                                <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp" required>
                                <div class="file-hint">
                                    <p>📷 Click to upload or drag & drop</p>
                                    <small>JPG, PNG, or WebP (max 5MB)</small>
                                </div>
                            </div>
                            <div id="imagePreview" class="image-preview"></div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">✓ Add Product</button>
                        <a href="products.php" class="btn btn-secondary btn-lg">Cancel</a>
                    </div>
                </form>
            </div>

            <div class="form-info-panel">
                <h3>Product Guidelines</h3>
                <ul>
                    <li>Use clear, descriptive product names</li>
                    <li>Upload high-quality product images</li>
                    <li>Set competitive and accurate pricing</li>
                    <li>Keep stock quantities up to date</li>
                    <li>Use unique product IDs</li>
                </ul>
                <div class="info-box">
                    <p><strong>Need help?</strong></p>
                    <p>Contact our support team for product management assistance.</p>
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