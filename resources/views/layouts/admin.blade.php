
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Election</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/web3@1.5.2/dist/web3.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    :root {
        --primary-color: #008751;
        --primary-light: rgba(0, 135, 81, 0.1);
        --secondary-color: #2c3e50;
        --accent-color: #f6851b;
    }
    
    body {
        background-color: #f8f9fa;
    }
    
    .admin-container {
        min-height: 100vh;
    }
    
    .admin-header {
        background: linear-gradient(135deg, var(--primary-color), #006442);
        color: white;
        padding: 1rem 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .admin-logo {
        width: 50px;
        height: 50px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .total-votes-badge {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 30px;
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
        font-weight: 600;
    }
    
    .badge-count {
        font-size: 1.2rem;
        margin-right: 0.5rem;
    }
    
    .badge-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1rem;
    }
    
    .stat-info h3 {
        font-weight: 700;
        margin-bottom: 0.2rem;
        color: var(--secondary-color);
    }
    
    .stat-info p {
        margin-bottom: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }
    
    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        border-bottom: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        background-color: #f8f9fa;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: rgba(0, 135, 81, 0.03);
    }
    
    .rank-badge {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        background-color: #e9ecef;
        color: #6c757d;
    }
    
    .rank-badge.top-1 {
        background-color: #ffc107;
        color: #212529;
    }
    
    .rank-badge.top-2 {
        background-color: #6c757d;
        color: white;
    }
    
    .rank-badge.top-3 {
        background-color: #cd7f32;
        color: white;
    }
    
    .candidate-avatar {
        width: 50px;
        height: 50px;
    }
    
    .candidate-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .party-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        color: white;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 50px;
    }
    
    .progress {
        border-radius: 4px;
        background-color: #e9ecef;
    }
    
    .progress-bar {
        background-color: var(--primary-color);
    }
    
    .image-upload-container {
        text-align: center;
    }
    
    .image-preview {
        width: 100%;
        height: 200px;
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        background-color: #f8f9fa;
    }
    
    .image-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
    
    .modal-header {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .modal-title {
        font-weight: 600;
    }
    
    .modal-footer {
        border-top: none;
    }
    
    @media (max-width: 768px) {
        .admin-header {
            padding: 0.75rem 0;
        }
        
        .admin-logo {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
        
        .total-votes-badge {
            padding: 0.35rem 0.75rem;
        }
        
        .stat-card {
            padding: 1rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }
</style>
</head>
<body class="nigeria-flag-effect">
    <!-- Navigation -->

    <!-- Main Content -->
    <main class="py-4 mt-4 mb-4">
        <div class="container">
            @yield('content')
        </div>
    </main>
