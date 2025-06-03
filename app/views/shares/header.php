<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Bán Hàng</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --text-color: #333;
            --light-gray: #f8f9fa;
        }
        body {
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', sans-serif;
            color: var(--text-color);
            background-color: #f9f9f9;
        }
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 12px 20px;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }
        .nav-link {
            font-weight: 600;
            color: #555 !important;
            transition: color 0.3s;
            margin: 0 5px;
        }
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        .navbar-nav {
            margin-left: 20px;
        }
        .navbar-toggler {
            border: none;
            outline: none;
        }
        .cart-icon {
            position: relative;
            margin-left: auto;
            padding: 8px 15px;
            color: #555;
            font-size: 1.2rem;
            transition: color 0.3s;
        }
        .cart-icon:hover {
            color: var(--primary-color);
        }
        .cart-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
        }
        .container {
            padding-top: 30px;
            padding-bottom: 50px;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        .btn-danger {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        .page-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #eee;
            padding-bottom: 0.8rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/webbanhang/Product">Web Bán Hàng</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/"><i class="fas fa-store mr-1"></i> Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Category/"><i class="fas fa-list mr-1"></i> Danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/add"><i class="fas fa-plus-circle mr-1"></i> Thêm sản phẩm</a>
                </li>
                <li class="nav-item">
                    <?php
                        if(SessionHelper::isLoggedIn()){
                            echo "<a class='navlink'>".$_SESSION['username']."</a>";
                            }
                            else{
                            echo "<a class='nav-link'href='/webbanhang/account/login'>Login</a>";
                        }
                        ?>
                </li>
                <li class="nav-item">
                    <?php
                        if(SessionHelper::isLoggedIn()){    
                            echo "<a class='nav-link'
                            href='/webbanhang/account/logout'>Logout</a>";
                        }
                    ?>
                </li>
            </ul>
            <a href="/webbanhang/Product/cart" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <?php 
                $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                if ($cartCount > 0): 
                ?>
                <span class="cart-badge"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</nav>
<div class="container mt-4">