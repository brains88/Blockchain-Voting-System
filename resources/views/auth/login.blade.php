@extends('layouts.app')

<style>
:root {
    --nigeria-green: #008751;
    --nigeria-white: #ffffff;
    --nigeria-dark-green: #005738;
    --light-gray: #f8f9fa;
    --border-green: rgba(0, 135, 81, 0.3);
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--light-gray);
    color: #333;
}

.login-wrapper {
    display: flex;
    min-height: 100vh;
}

/* Left Section - Visual Appeal */
.visual-section {
    flex: 1;
    background: linear-gradient(rgba(0, 135, 81, 0.8), rgba(0, 87, 56, 0.9)), 
                url('{{ asset("https://electionsgroup.com/wp-content/uploads/2024/09/Vote-Ballot-Box_green-499x499.png") }}') center/cover no-repeat;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 40px;
    color: white;
}

.visual-content {
    max-width: 600px;
    margin: 0 auto;
}

.visual-section h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    font-weight: 700;
}

.visual-section p {
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 30px;
}

.feature-list {
    list-style: none;
    padding: 0;
}

.feature-list li {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.feature-list i {
    color: white;
    background-color: var(--nigeria-green);
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

/* Form Section */
.form-section {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

.login-container {
    width: 100%;
    max-width: 480px;
}

.login-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-green);
    overflow: hidden;
}

.login-header {
    background-color: var(--nigeria-green);
    color: white;
    padding: 25px;
    text-align: center;
}

.login-header img {
    height: 50px;
    margin-bottom: 15px;
}

.login-header h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.login-header p {
    margin: 5px 0 0;
    opacity: 0.9;
}

.login-body {
    padding: 30px;
}

.btn-metamask {
    background-color: #f6851b;
    color: white;
    border: none;
    padding: 15px;
    width: 100%;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px 0;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.btn-metamask:hover {
    background-color: #e2761b;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(246, 133, 27, 0.3);
}

.btn-metamask i {
    font-size: 24px;
    margin-right: 12px;
}

.divider {
    display: flex;
    align-items: center;
    margin: 25px 0;
    color: #777;
    font-size: 0.9rem;
}

.divider::before, .divider::after {
    content: "";
    flex: 1;
    border-bottom: 1px solid #ddd;
}

.divider::before {
    margin-right: 15px;
}

.divider::after {
    margin-left: 15px;
}

.manual-auth {
    border-top: 1px solid #eee;
    padding-top: 20px;
    margin-top: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--nigeria-dark-green);
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s;
}

.form-control:focus {
    border-color: var(--nigeria-green);
    box-shadow: 0 0 0 3px rgba(0, 135, 81, 0.1);
    outline: none;
}

.btn-submit {
    background-color: var(--nigeria-green);
    color: white;
    border: none;
    padding: 15px;
    width: 100%;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-submit:hover {
    background-color: var(--nigeria-dark-green);
}

.get-started {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-top: 30px;
    border: 1px dashed var(--nigeria-green);
}

.get-started h4 {
    color: var(--nigeria-green);
    margin-top: 0;
    font-size: 1.1rem;
}

.get-started ol {
    padding-left: 20px;
}

.get-started a {
    color: var(--nigeria-green);
    font-weight: 600;
    text-decoration: none;
}

.get-started a:hover {
    text-decoration: underline;
}

.loading-spinner {
    display: none;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
    margin-left: 10px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

@media (max-width: 992px) {
    .login-wrapper {
        flex-direction: column;
    }
    
    .visual-section {
        padding: 30px;
        text-align: center;
    }
    
    .form-section {
        padding: 30px;
    }
}

@media (max-width: 576px) {
    .login-header {
        padding: 20px;
    }
    
    .login-body {
        padding: 20px;
    }
}
</style>

@section('content')
<div class="login-wrapper">
    <!-- Visual Appeal Section -->
    <div class="visual-section">
        <div class="visual-content">
            <h2>Secure Blockchain Voting System</h2>
            <p>Participate in the future of democratic elections using cutting-edge blockchain technology that ensures transparency and security.</p>
            
            <ul class="feature-list">
                <li>
                    <i class="fas fa-shield-alt"></i>
                    <span>Tamper-proof voting records secured by blockchain</span>
                </li>
                <li>
                    <i class="fas fa-user-lock"></i>
                    <span>Cryptographic identity verification</span>
                </li>
                <li>
                    <i class="fas fa-check-circle"></i>
                    <span>End-to-end verifiable results</span>
                </li>
                <li>
                    <i class="fas fa-mobile-alt"></i>
                    <span>Accessible voting from anywhere</span>
                </li>
            </ul>
            
           
        </div>
    </div>
    
    <!-- Form Section -->
<div class="form-section">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('https://electionsgroup.com/wp-content/uploads/2024/09/Vote-Ballot-Box_green-499x499.png') }}" alt="Nigeria Emblem">
                <h3>Voting Platform Access</h3>
                <p>Secure authentication using blockchain or voter ID</p>
            </div>
            
            <div class="login-body">
                <button id="connectMetamask" class="btn-metamask">
                    <i class="fab fa-ethereum"></i> Connect with MetaMask
                    <div class="loading-spinner" id="spinner"></div>
                </button>
                
                <div class="divider">OR</div>
                
                <div class="manual-auth">
                    <form id="walletAuthForm" method="POST" action="{{ route('wallet.login') }}">
                    @csrf
                        
                        <div class="form-group">
                            <label for="auth_method">Authentication Method</label>
                            <select class="form-control" id="auth_method" name="auth_method">
                                <option value="wallet">Blockchain Wallet</option>
                                <option value="voter_id">Voter ID Card</option>
                            </select>
                        </div>

                        <!-- Wallet Address Fields -->
                        <div id="walletFields">
                            <div class="form-group">
                                <label for="wallet_address">Wallet Address</label>
                                <input type="text" class="form-control" id="wallet_address" 
                                       name="wallet_address" placeholder="0x..." required>
                            </div>
                            
                            <div class="form-group">
                                <label for="signature">Signature</label>
                                <input type="text" class="form-control" id="signature" 
                                       name="signature" placeholder="Your cryptographic signature" required>
                                <small class="text-muted">Sign the message provided after entering your wallet address</small>
                            </div>
                        </div>

                        <!-- Voter ID Fields (hidden by default) -->
                        <div id="voterIdFields" style="display:none;">
                            <div class="form-group">
                                <label for="voter_id">Voter ID Number</label>
                                <input type="text" class="form-control" id="voter_id" 
                                       name="voter_id" placeholder="Your voter identification card number" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" 
                                       name="dob" required>
                                <small class="text-muted">You must be at least 18 years old to vote</small>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-submit">
                            Authenticate & Continue
                        </button>
                    </form>
                </div>
                
                <div class="get-started">
                    <h4>New to Blockchain Voting?</h4>
                    <ol>
                        <li>Install <a href="https://metamask.io/download.html" target="_blank">MetaMask</a> browser extension</li>
                        <li>Create or import a wallet</li>
                        <li>Connect your wallet to begin voting</li>
                        <li>Or use your Voter ID card if you don't have a wallet</li>
                    </ol>
                    <p style="margin-top: 10px;">Learn more about <a href="#">how blockchain voting works</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>

<style>
.loading-spinner {
    display: none;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
    margin-left: 10px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<script>
// Initialize form fields on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set wallet as default method
    document.getElementById('auth_method').value = 'wallet';
    document.getElementById('walletFields').style.display = 'block';
    document.getElementById('voterIdFields').style.display = 'none';
});

// Toggle between wallet and voter ID fields
document.getElementById('auth_method').addEventListener('change', function() {
    const method = this.value;
    if (method === 'voter_id') {
        document.getElementById('walletFields').style.display = 'none';
        document.getElementById('voterIdFields').style.display = 'block';
        document.getElementById('wallet_address').required = false;
        document.getElementById('signature').required = false;
    } else {
        document.getElementById('walletFields').style.display = 'block';
        document.getElementById('voterIdFields').style.display = 'none';
        document.getElementById('wallet_address').required = true;
        document.getElementById('signature').required = true;
    }
});

// MetaMask connection code
document.getElementById('connectMetamask').addEventListener('click', async () => {
    const button = document.getElementById('connectMetamask');
    const spinner = document.getElementById('spinner');
    
    try {
        // Show loading spinner
        button.disabled = true;
        spinner.style.display = 'inline-block';
        
        // Ensure wallet fields are visible
        document.getElementById('auth_method').value = 'wallet';
        document.getElementById('walletFields').style.display = 'block';
        document.getElementById('voterIdFields').style.display = 'none';
        
        // Check if MetaMask is installed
        if (!window.ethereum) {
            throw new Error('MetaMask not detected. Please install MetaMask first.');
        }
        
        // Request account access
        const accounts = await window.ethereum.request({ 
            method: 'eth_requestAccounts' 
        }).catch(err => {
            throw new Error('You need to connect your wallet to continue');
        });
        
        if (!accounts || accounts.length === 0) {
            throw new Error('No accounts found');
        }
        
        const account = accounts[0];
        document.getElementById('wallet_address').value = account;
        
        // Get authentication message from backend
        const response = await fetch('/api/auth/nonce', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ wallet_address: account })
        });
        
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || 'Failed to get authentication message');
        }
        
        const { message } = await response.json();
        
        // Request signature
        let signature;
        try {
            signature = await window.ethereum.request({
                method: 'personal_sign',
                params: [message, account]
            });
            
            console.log('Signature obtained:', signature);
            
        } catch (signError) {
            console.error('Signature error:', signError);
            if (signError.code === 4001) {
                throw new Error('Signature rejected by user');
            } else {
                throw new Error('Failed to obtain signature: ' + signError.message);
            }
        }
        
        if (!signature) {
            throw new Error('Empty signature received');
        }
        
        // Submit form
        document.getElementById('signature').value = signature;
        document.getElementById('walletAuthForm').submit();
        
    } catch (error) {
        console.error("Authentication Error:", error);
        alert(`Authentication failed: ${error.message}`);
        button.disabled = false;
        spinner.style.display = 'none';
    }
});

// Age verification for voter ID
document.getElementById('walletAuthForm').addEventListener('submit', function(e) {
    if (document.getElementById('auth_method').value === 'voter_id') {
        const dobInput = document.getElementById('dob');
        if (dobInput.value) {
            const dob = new Date(dobInput.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            
            if (age < 18) {
                e.preventDefault();
                alert('You must be at least 18 years old to vote.');
            }
        }
    }
});
</script>
@endsection