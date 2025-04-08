import Web3 from 'web3';

export default class BlockchainAuth {
    constructor() {
        if (typeof window.ethereum !== 'undefined') {
            this.web3 = new Web3(window.ethereum);
            this.setupEvents();
        } else {
            this.showMetaMaskAlert();
        }
    }

    setupEvents() {
        const connectBtn = document.getElementById('connectWallet');
        
        connectBtn.addEventListener('click', async () => {
            try {
                const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
                this.handleConnectedWallet(accounts[0]);
            } catch (error) {
                console.error('Error connecting wallet:', error);
            }
        });
    }

    async handleConnectedWallet(address) {
        // Display connected wallet
        document.getElementById('walletAddress').textContent = address;
        document.getElementById('walletStatus').style.display = 'flex';
        document.getElementById('connectWallet').style.display = 'none';
        
        // Get signature
        const message = 'Authenticate with voting system - ' + new Date().toISOString();
        const signature = await this.web3.eth.personal.sign(message, address);
        
        // Submit to backend
        await this.verifySignature(address, message, signature);
    }

    async verifySignature(address, message, signature) {
        const response = await fetch('/api/verify-signature', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ address, message, signature })
        });
        
        const data = await response.json();
        
        if (data.success) {
            window.location.href = '/dashboard';
        } else {
            alert('Authentication failed: ' + data.error);
        }
    }

    showMetaMaskAlert() {
        document.getElementById('connectWallet').textContent = 'Install MetaMask';
        document.getElementById('connectWallet').onclick = () => {
            window.open('https://metamask.io/download.html', '_blank');
        };
    }
}

// Initialize
if (document.getElementById('connectWallet')) {
    new BlockchainAuth();
}