<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ModernStore - Premium E-Commerce</title>
    <link rel="stylesheet" href="css.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <h1 class="logo">ModernStore</h1>
            </div>
            <div class="nav-menu">
                <a href="index.php" class="nav-link active">Home</a>
                <a href="products.php" class="nav-link">Shop</a>
                <a href="add_form.php" class="nav-link">Admin</a>
            </div>
            <div class="nav-actions">
                <button class="cart-icon">🛒</button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h2 class="hero-subtitle">Welcome to Premium E-Commerce</h2>
            <h1 class="hero-title">Discover Premium Products Curated For You</h1>
            <p class="hero-description">Shop from our exclusive collection of handpicked products with guaranteed quality and fast delivery.</p>
            <div class="hero-buttons">
                <a href="products.php" class="btn btn-primary">Shop Now</a>
                <a href="#featured" class="btn btn-secondary">See Featured Items</a>
            </div>
        </div>
        <div class="hero-background"></div>
    </section>

    <!-- Trust Badges -->
    <section class="trust-section">
        <div class="trust-grid">
            <div class="trust-item">
                <div class="trust-icon">✓</div>
                <h3>100% Original</h3>
                <p>Authentic products guaranteed</p>
            </div>
            <div class="trust-item">
                <div class="trust-icon">🚚</div>
                <h3>Fast Shipping</h3>
                <p>Delivered in 2-3 business days</p>
            </div>
            <div class="trust-item">
                <div class="trust-icon">🔒</div>
                <h3>Secure Payment</h3>
                <p>256-bit encryption protection</p>
            </div>
            <div class="trust-item">
                <div class="trust-icon">↩️</div>
                <h3>Easy Returns</h3>
                <p>30-day hassle-free policy</p>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="featured-section">
        <div class="section-header">
            <h2>Featured Products</h2>
            <p>Handpicked selections just for you</p>
        </div>
        <div class="featured-grid">
            <?php
            $con = mysqli_connect("localhost", "root", "", "crud");
            if(!mysqli_connect_errno()){
                $sql = "SELECT * FROM products LIMIT 6";
                $result = mysqli_query($con, $sql);
                
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $inStock = $row['stock'] > 0;
                        echo '<div class="product-card">';
                        echo '  <div class="product-image-wrapper">';
                        echo '    <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image" onerror="this.src=\'https://placehold.co/300x300?text=' . urlencode($row['name']) . '\'">';
                        if(!$inStock) {
                            echo '    <div class="out-of-stock">Out of Stock</div>';
                        }
                        echo '  </div>';
                        echo '  <div class="product-info">';
                        echo '    <h3 class="product-name">' . htmlspecialchars($row['name']) . '</h3>';
                        echo '    <div class="product-footer">';
                        echo '      <span class="product-price">$' . number_format($row['price'], 2) . '</span>';
                        echo '      <span class="product-stock">' . $row['stock'] . ' in stock</span>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="no-products">No products available yet</p>';
                }
                mysqli_close($con);
            }
            ?>
        </div>
        <div class="view-all-container">
            <a href="products.php" class="btn btn-primary btn-lg">View All Products</a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-wrapper">
            <?php
            $con = mysqli_connect("localhost", "root", "", "crud");
            $count_result = mysqli_query($con, "SELECT COUNT(*) as total FROM products");
            $count = mysqli_fetch_assoc($count_result);
            $total = $count['total'];
            ?>
            <div class="stat-item">
                <div class="stat-number"><?php echo $total; ?></div>
                <div class="stat-label">Products Available</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50K+</div>
                <div class="stat-label">Happy Customers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">4.9★</div>
                <div class="stat-label">Average Rating</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Customer Support</div>
            </div>
            <?php mysqli_close($con); ?>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="newsletter-content">
            <h2>Stay Updated</h2>
            <p>Subscribe to get special offers and new product updates delivered to your inbox</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
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
</body>
</html>