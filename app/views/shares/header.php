<?php
require_once 'app/models/AccountModel.php';
require_once 'app/config/database.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Bán Hàng</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #375ad3;
            --accent-color: #f6546a;
            --text-color: #2e3951;
            --light-gray: #f8f9fc;
            --dark-gray: #5a5c69;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --border-radius: 0.35rem;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            color: var(--text-color);
            background-color: #f8f9fc;
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        /* Header & Navigation */
        .navbar {
            background: linear-gradient(135deg, #fff, #f8f9fc) !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            padding: 0.8rem 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.6rem;
            letter-spacing: -0.5px;
        }
        
        .navbar-brand span {
            color: var(--accent-color);
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-color) !important;
            transition: all 0.3s ease;
            margin: 0 0.3rem;
            padding: 0.5rem 0.8rem !important;
            border-radius: var(--border-radius);
            position: relative;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: rgba(78, 115, 223, 0.05);
        }
        
        .nav-link.active {
            color: var(--primary-color) !important;
            background-color: rgba(78, 115, 223, 0.1);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 70%;
        }
        
        .navbar-toggler {
            border: none;
            outline: none !important;
            padding: 0.5rem;
            border-radius: var(--border-radius);
            background-color: rgba(78, 115, 223, 0.1);
        }
        
        .navbar-toggler-icon {
            color: var(--primary-color);
        }
        
        /* User Avatar & Cart */
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .user-avatar:hover {
            transform: scale(1.1);
            border-color: var(--accent-color);
        }
        
        .cart-icon {
            position: relative;
            margin-left: 1rem;
            padding: 0.5rem;
            color: var(--text-color);
            font-size: 1.2rem;
            transition: all 0.3s ease;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(78, 115, 223, 0.1);
        }
        
        .cart-icon:hover {
            color: var(--primary-color);
            background-color: rgba(78, 115, 223, 0.2);
            transform: translateY(-2px);
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            font-weight: 700;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(246, 84, 106, 0.7);
            }
            70% {
                box-shadow: 0 0 0 5px rgba(246, 84, 106, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(246, 84, 106, 0);
            }
        }
        
        /* Container & Content */
        .container {
            padding-top: 2rem;
            padding-bottom: 3rem;
        }
        
        .page-title {
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 1.8rem;
            position: relative;
            padding-bottom: 0.8rem;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            border-radius: 3px;
        }
        
        /* Buttons */
        .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #0ca876);
            border: none;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--accent-color), #e74a3b);
            border: none;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #f4b619);
            border: none;
            color: #fff;
        }
        
        .btn-warning:hover {
            color: #fff;
        }
        
        .btn-outline-secondary {
            border-color: var(--dark-gray);
            color: var(--dark-gray);
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--dark-gray);
            color: #fff;
        }
        
        /* Form Controls */
        .form-control {
            border-radius: var(--border-radius);
            padding: 0.6rem 1rem;
            border: 1px solid rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        /* Cards */
        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1rem 1.25rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/webbanhang/Product">Zoe<span>Mart</span></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/Product') !== false && strpos($_SERVER['REQUEST_URI'], '/Product/add') === false) ? 'active' : ''; ?>" href="/webbanhang/Product/"><i class="fas fa-store mr-1"></i> Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/Category') !== false ? 'active' : ''; ?>" href="/webbanhang/Category/"><i class="fas fa-list mr-1"></i> Danh mục</a>
                </li>
                <?php if (SessionHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/Product/add') !== false ? 'active' : ''; ?>" href="/webbanhang/Product/add"><i class="fas fa-plus-circle mr-1"></i> Thêm sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/account/manageUsers') !== false ? 'active' : ''; ?>" href="/webbanhang/account/manageUsers"><i class="fas fa-users-cog mr-1"></i> Quản lý người dùng</a>
                    </li>
                <?php endif; ?>
            </ul>
            
            <div class="d-flex align-items-center">
                <?php if(SessionHelper::isLoggedIn()): ?>
                    <div class="dropdown mr-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php
                                $username = $_SESSION['username'];
                                $db = Database::getConnection();
                                $accountModel = new AccountModel($db);
                                $userInfo = $accountModel->getAccountByUsername($username);
                                
                                if (!empty($userInfo->avatar)) {
                                    $avatarUrl = '/webbanhang/' . $userInfo->avatar;
                                    echo "<img src='$avatarUrl' alt='Avatar' class='user-avatar mr-2'>";
                                } else {
                                    echo "<i class='fas fa-user-circle mr-2' style='font-size: 1.5rem; color: var(--primary-color);'></i>";
                                }
                                
                                echo "<span>" . $_SESSION['username'] . "</span>";
                            ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <div class="dropdown-item text-muted small">
                                <i class="fas fa-user-tag mr-1"></i> <?php echo SessionHelper::getRole(); ?>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/webbanhang/account/profile">
                                <i class="fas fa-user-circle mr-1"></i> Hồ sơ
                            </a>
                            <a class="dropdown-item" href="/webbanhang/account/logout">
                                <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="btn btn-outline-primary mr-2" href="/webbanhang/account/login">
                        <i class="fas fa-sign-in-alt mr-1"></i> Đăng nhập
                    </a>
                <?php endif; ?>
                
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
    </div>
</nav>
<div class="container mt-4">