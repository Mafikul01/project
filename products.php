<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | ModernStore</title>
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
                <a href="index.html" class="nav-link">Home</a>
                <a href="products.php" class="nav-link active">Shop</a>
                <a href="add_form.php" class="nav-link">Admin</a>
            </div>
            <div class="nav-actions">
                <button class="cart-icon">🛒</button>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-content">
            <h1>Our Complete Collection</h1>
            <p>Explore our full range of premium products</p>
        </div>
    </section>

    <!-- Search & Filter Bar -->
    <section class="filter-bar">
        <div class="filter-container">
            <div class="search-group">
                <input type="text" id="searchInput" class="search-input" placeholder="🔍 Search products by name or ID..." autocomplete="off">
            </div>
            <div class="filter-controls">
                <div class="filter-group">
                    <label>Sort By:</label>
                    <select id="sortSelect">
                        <option value="newest">Newest</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="name">Name (A-Z)</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>View:</label>
                    <button class="view-toggle active" data-view="grid">⊞ Grid</button>
                    <button class="view-toggle" data-view="list">☰ List</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="shop-section">
        <div class="products-container">
            <?php
            $con = mysqli_connect("localhost", "root", "", "crud");
            if(!mysqli_connect_errno()){
                $sql = "SELECT * FROM products ORDER BY id DESC";
                $result = mysqli_query($con, $sql);
                
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $inStock = $row['stock'] > 0;
                        $stockClass = $inStock ? 'in-stock' : 'out-of-stock';
                        
                        echo '<div class="product-card ' . $stockClass . '">';
                        echo '  <div class="product-image-wrapper">';
                        echo '    <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image" onerror="this.src=\'https://placehold.co/400x400?text=' . urlencode($row['name']) . '\'">';
                        
                        if(!$inStock) {
                            echo '    <div class="stock-overlay">Out of Stock</div>';
                        } else {
                            echo '    <div class="product-actions">';
                            echo '      <a href="update_form.php?id=' . $row['id'] . '" class="action-btn edit-btn" title="Edit">✏️</a>';
                            echo '      <a href="delete.php?id=' . $row['id'] . '" class="action-btn delete-btn" title="Delete" onclick="return confirm(\'Are you sure?\')">🗑️</a>';
                            echo '    </div>';
                        }
                        
                        echo '  </div>';
                        echo '  <div class="product-info">';
                        echo '    <div class="product-header">';
                        echo '      <h3 class="product-name">' . htmlspecialchars($row['name']) . '</h3>';
                        echo '      <span class="product-id">ID: ' . $row['id'] . '</span>';
                        echo '    </div>';
                        echo '    <div class="product-details">';
                        echo '      <span class="product-price">$' . number_format($row['price'], 2) . '</span>';
                        echo '      <span class="product-stock">' . $row['stock'] . ' units</span>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="empty-state"><p>No products found. <a href="add_form.php">Add your first product</a></p></div>';
                }
                mysqli_close($con);
            } else {
                echo '<div class="error-message">Database connection failed</div>';
            }
            ?>
        </div>
    </section>

    <!-- Admin Panel Button -->
    <section class="admin-panel-section">
        <a href="add_form.php" class="btn btn-primary btn-lg">+ Add New Product</a>
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
        const container = document.querySelector('.products-container');
        const allProducts = Array.from(document.querySelectorAll('.product-card'));
        
        // View Toggle
        document.querySelectorAll('.view-toggle').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.view-toggle').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const view = this.dataset.view;
                
                // Update container class
                container.classList.remove('view-grid', 'view-list');
                container.classList.add('view-' + view);
            });
        });

        // Search Functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            filterAndDisplay(searchTerm);
        });
        
        function filterAndDisplay(searchTerm) {
            const products = Array.from(document.querySelectorAll('.product-card'));
            let visibleCount = 0;
            
            products.forEach(product => {
                const productName = product.querySelector('.product-name').textContent.toLowerCase();
                const productId = product.querySelector('.product-id').textContent.toLowerCase();
                
                if(searchTerm === '' || productName.includes(searchTerm) || productId.includes(searchTerm)) {
                    product.style.display = '';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });
            
            // Show or hide empty state
            let emptyState = document.querySelector('.empty-state');
            if(visibleCount === 0) {
                if(!emptyState) {
                    emptyState = document.createElement('div');
                    emptyState.className = 'empty-state';
                    emptyState.innerHTML = '<p>No products found matching "' + searchTerm + '"</p>';
                    container.appendChild(emptyState);
                } else {
                    emptyState.innerHTML = '<p>No products found matching "' + searchTerm + '"</p>';
                    emptyState.style.display = '';
                }
            } else if(emptyState) {
                emptyState.style.display = 'none';
            }
        }

        // Sort Functionality
        document.getElementById('sortSelect').addEventListener('change', function() {
            const products = Array.from(document.querySelectorAll('.product-card')).filter(p => p.style.display !== 'none');
            const sort = this.value;
            
            products.sort((a, b) => {
                switch(sort) {
                    case 'price-low':
                        const priceA = parseFloat(a.querySelector('.product-price').textContent.replace('$', ''));
                        const priceB = parseFloat(b.querySelector('.product-price').textContent.replace('$', ''));
                        return priceA - priceB;
                    case 'price-high':
                        const priceA2 = parseFloat(a.querySelector('.product-price').textContent.replace('$', ''));
                        const priceB2 = parseFloat(b.querySelector('.product-price').textContent.replace('$', ''));
                        return priceB2 - priceA2;
                    case 'name':
                        return a.querySelector('.product-name').textContent.localeCompare(b.querySelector('.product-name').textContent);
                    default:
                        return 0;
                }
            });
            
            products.forEach(p => container.appendChild(p));
        });
    </script>
</body>
</html>