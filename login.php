<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: admin/dashboard.php");
    exit;
}

$pesan = '';
if ($_POST) {
    include 'functions.php';
    if (cekPassword($_POST['password'])) {
        $_SESSION['login'] = true;
        header("Location: admin/dashboard.php");
        exit;
    }
    $pesan = "Password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - RT 13</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8fdf8 0%, #e6f4ea 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(to right, #2e7d32, #4caf50);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        .login-header h5 {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .login-header small {
            opacity: 0.9;
        }
        .login-body {
            padding: 1.5rem;
        }
        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
        }
        .btn-success {
            background: #2e7d32;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .btn-success:hover {
            background: #1b5e20;
        }
        .alert {
            border-radius: 8px;
            font-size: 0.9rem;
        }
        @media (max-width: 576px) {
            .login-body {
                padding: 1rem;
            }
            .form-control {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <h5><i class="fas fa-lock me-2"></i> Login Admin</h5>
        <small>RT 13 RW 04 - Pondokkaso Tonggoh</small>
    </div>
    <div class="login-body">
        <?php if ($pesan): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i> <?= $pesan ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="visually-hidden">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                <div class="form-text text-muted mt-1">
                    Password default: <code>admin123</code>
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100">
                <i class="fas fa-sign-in-alt me-2"></i> Masuk
            </button>
        </form>
    </div>
</div>

</body>
</html>