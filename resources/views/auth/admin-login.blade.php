<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | Nigeria Voting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --nigerian-green: #008751;
            --nigerian-white: #ffffff;
            --nigerian-dark-green: #005738;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(0, 135, 81, 0.1) 0%, rgba(255, 255, 255, 1) 100%);
        }
        
        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
        }
        
        .login-header {
            background-color: var(--nigerian-green);
            color: white;
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }
        
        .login-header::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--nigerian-green) 0%, white 50%, var(--nigerian-green) 100%);
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .login-logo i {
            color: var(--nigerian-green);
            font-size: 2.5rem;
        }
        
        .login-body {
            padding: 2rem;
            background-color: white;
        }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--nigerian-green);
            box-shadow: 0 0 0 0.25rem rgba(0, 135, 81, 0.25);
        }
        
        .btn-login {
            background-color: var(--nigerian-green);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background-color: var(--nigerian-dark-green);
        }
        
        .btn-login .spinner-border {
            vertical-align: middle;
            margin-right: 8px;
        }
        
        .forgot-password {
            color: var(--nigerian-green);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .forgot-password:hover {
            color: var(--nigerian-dark-green);
            text-decoration: underline;
        }
        
        .login-footer {
            text-align: center;
            padding: 1rem;
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .flag-stripe {
            height: 6px;
            background: linear-gradient(90deg, var(--nigerian-green) 0%, white 50%, var(--nigerian-green) 100%);
        }
    </style>
</head>
<body>
    <div class="flag-stripe"></div>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h2>Admin Portal</h2>
                <p>BlockChain Voting System</p>
            </div>
            <div class="login-body">
                <form id="loginForm" method="POST" action="{{ route('admin.login.store') }}">
                    @csrf
                    <div id="loginStatus" class="alert alert-danger d-none"></div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-login btn-block " id="loginButton">
                            <span id="loginText">Login</span>
                            <span id="loginSpinner" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="login-footer">
                © {{ date('Y') }} Blockchain Voting System. All rights reserved.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.querySelector('.toggle-password');
            const password = document.getElementById('password');
            
            if (togglePassword && password) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }

            // Form submission
            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const loginButton = document.getElementById('loginButton');
                    const loginText = document.getElementById('loginText');
                    const loginSpinner = document.getElementById('loginSpinner');
                    const loginStatus = document.getElementById('loginStatus');
                    
                    // Show loading state
                    loginButton.disabled = true;
                    loginText.textContent = 'Authenticating...';
                    loginSpinner.classList.remove('d-none');
                    loginStatus.classList.add('d-none');
                    
                    try {
                        const formData = new FormData(this);
                        const response = await fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();
                        
                        if (!response.ok) {
                            throw new Error(data.message || 'Login failed. Please try again.');
                        }

                        // Redirect on success
                        window.location.href = data.redirect || '/admin/dashboard';
                        
                    } catch (error) {
                        // Show error message
                        loginStatus.textContent = error.message;
                        loginStatus.classList.remove('d-none');
                        loginStatus.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        
                        // Shake animation for error
                        loginForm.classList.add('animate__animated', 'animate__headShake');
                        setTimeout(() => {
                            loginForm.classList.remove('animate__animated', 'animate__headShake');
                        }, 1000);
                        
                    } finally {
                        // Reset button state
                        loginButton.disabled = false;
                        loginText.textContent = 'Login';
                        loginSpinner.classList.add('d-none');
                    }
                });
            }

            // Display flash messages
            @if(session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('status') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
            
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: '<ul class="text-left">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>'
                });
            @endif
        });
    </script>
</body>
</html>