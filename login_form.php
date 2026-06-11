<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | ModernStore</title>
    <link rel="stylesheet" href="css.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .login-page {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
            padding: var(--spacing-xl) var(--spacing-lg);
        }
        .login-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: var(--spacing-xl);
            width: 100%;
            max-width: 450px;
            box-shadow: var(--shadow-lg);
        }
        .login-header {
            text-align: center;
            margin-bottom: var(--spacing-lg);
        }
        .login-header h2 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        .message-box {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: var(--spacing-md);
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php session_start(); ?>

    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand"><h1 class="logo">ModernStore</h1></div>
            <div class="nav-menu">
                <a href="index.html" class="nav-link">Home</a>
                <a href="products.php" class="nav-link">Shop</a>
                <a href="login_form.php" class="nav-link active">Admin</a>
            </div>
            <div class="nav-actions"><button class="cart-icon">🛒</button></div>
        </div>
    </nav>

    <section class="login-page">
        <div class="login-card">
            <div class="login-header">
                <h2>Admin Portal</h2>
                <p>Sign in to manage your premium store</p>
            </div>

            <?php if(isset($_SESSION['login_error'])): ?>
                <div class="message-box">
                    <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="post" class="product-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; margin-top: 1rem;">🔓 Secure Login</button>
            </form>
        </div>
    </section>
</body>
</html>