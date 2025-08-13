<div class="container mt-5">
    <h1 class="mb-4">Tableau de bord</h1>
    
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-dark border-orange h-100">
                <div class="card-body">
                    <h5 class="card-title text-orange">Fonctions Admin</h5>
                    <p class="card-text">Gestion des rôles, pause du contrat, création de factures/pools</p>
                    <a href="<?php echo base_url('admin/functions'); ?>" class="btn btn-orange">Accéder</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-dark border-orange h-100">
                <div class="card-body">
                    <h5 class="card-title text-orange">Fonctions Client</h5>
                    <p class="card-text">Remboursement de factures, historique des paiements</p>
                    <a href="<?php echo base_url('client/functions'); ?>" class="btn btn-orange">Accéder</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-dark border-orange h-100">
                <div class="card-body">
                    <h5 class="card-title text-orange">Fonctions Entreprise</h5>
                    <p class="card-text">Dépôt de collatéral, retrait de fonds</p>
                    <a href="<?php echo base_url('enterprise/functions'); ?>" class="btn btn-orange">Accéder</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-dark border-orange h-100">
                <div class="card-body">
                    <h5 class="card-title text-orange">Fonctions Investisseur</h5>
                    <p class="card-text">Investissement, réclamation de fonds</p>
                    <a href="<?php echo base_url('investor/functions'); ?>" class="btn btn-orange">Accéder</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card bg-dark border-orange mt-4">
        <div class="card-body">
            <h5 class="card-title text-orange">Informations du portefeuille</h5>
            <p>Adresse connectée: <code id="wallet-address-display">Chargement...</code></p>
            
            <div class="d-flex align-items-center mb-3">
                <span id="dashboard-balance-amount">0</span>
                <span class="ms-1">USDT</span>
            </div>
                
                
            
            <div class="row g-3">
                <!-- Transfer Section -->
                <div class="col-md-6">
                    <div class="card bg-darker border-secondary h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Transfert USDT</h6>
                            <div class="mb-3">
                                <label for="transfer-address" class="form-label small">Adresse destinataire</label>
                                <input type="text" class="form-control form-control-sm bg-dark text-white" id="transfer-address" placeholder="0x...">
                            </div>
                            <div class="mb-3">
                                <label for="transfer-amount" class="form-label small">Montant USDT</label>
                                <input type="number" class="form-control form-control-sm bg-dark text-white" id="transfer-amount" placeholder="0.00" step="0.01">
                            </div>
                            <button id="transfer-btn" class="btn btn-sm btn-orange w-100" onclick="handleTransfer()">
                                <i class="fas fa-paper-plane me-1"></i> Transférer
                            </button>
                        </div>
                    </div>
                </div>
                
               <!-- Faucet Section (for testnet) -->
                <div class="col-md-6">
                    <div class="card bg-darker border-warning h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-warning">Faucet USDT (Testnet)</h6>
                            <p class="small text-muted mb-3">Fonction réservée au owner - Mint de tokens USDT</p>
                            
                            <div class="mb-3">
                                <label for="faucet-address" class="form-label small">Adresse bénéficiaire</label>
                                <input type="text" class="form-control form-control-sm bg-dark text-white" 
                                    id="faucet-address" placeholder="0x..." 
                                    value="<?php echo $this->session->userdata('wallet_address') ?? ''; ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="faucet-amount" class="form-label small">Montant USDT</label>
                                <input type="text" 
                                    class="form-control form-control-sm bg-dark text-white" 
                                    id="faucet-amount" 
                                    placeholder="100" 
                                    value="100"
                                    pattern="^[0-9]*\.?[0-9]+$"
                                    title="Please enter a positive number (e.g. 100 or 50.5)"
                                    required>
                                <div class="invalid-feedback">
                                    Please enter a valid positive number (e.g. 100 or 50.5)
                                </div>
                            </div>
                            
                            <button id="faucet-btn" class="btn btn-sm btn-warning w-100">
                                <i class="fas fa-faucet me-1"></i> Mint USDT Tokens
                            </button>
                            
                            <div id="faucet-status" class="small mt-2 text-muted"></div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<script>
    // Fonction pour vérifier l'état de connexion
    async function checkWalletConnection() {
        try {
            // Vérifie si Web3 est injecté
            if (typeof window.ethereum === 'undefined') {
                console.warn('MetaMask non détecté');
                document.getElementById('wallet-address-display').textContent = 'MetaMask non détecté';
                return false;
            }

            // Vérifie si déjà connecté
            const accounts = await window.ethereum.request({ method: 'eth_accounts' });
            
            if (accounts.length === 0) {
                document.getElementById('wallet-address-display').textContent = 'Non connecté';
                return false;
            }
            
            return true;
        } catch (error) {
            console.error('Erreur de vérification:', error);
            return false;
        }
    }

    // Fonction principale pour mettre à jour les infos
    async function updateWalletInfo() {
        const isConnected = await checkWalletConnection();
        
        if (!isConnected) {
            // Cache les fonctionnalités si non connecté
            document.querySelectorAll('#transfer-btn, #approve-btn, #faucet-btn')
                .forEach(btn => btn.disabled = true);
            return;
        }

        try {
            // Récupère l'adresse
            const accounts = await window.ethereum.request({ method: 'eth_accounts' });
            const walletAddress = accounts[0];
            document.getElementById('wallet-address-display').textContent = walletAddress;

            // Met à jour le solde
            const balance = await window.stablecoinCFN.getCFNBalance(walletAddress);
            document.getElementById('dashboard-balance-amount').textContent = balance.display;

            // Active les boutons
            document.querySelectorAll('#transfer-btn, #approve-btn, #faucet-btn')
                .forEach(btn => btn.disabled = false);

        } catch (error) {
            console.error('Erreur de mise à jour:', error);
            document.getElementById('wallet-address-display').textContent = 'Erreur de connexion';
        }
    }

    // Écouteurs d'événements
    window.addEventListener('load', async () => {
        // Vérifie la connexion au chargement
        await updateWalletInfo();
        
        // Écoute les changements de compte
        window.ethereum.on('accountsChanged', async (accounts) => {
            if (accounts.length === 0) {
                document.getElementById('wallet-address-display').textContent = 'Non connecté';
                document.getElementById('dashboard-balance-amount').textContent = '0';
            } else {
                await updateWalletInfo();
            }
        });
    });


    async function updateDashboardBalance() {
        try {
            if (!window.walletUtils || !window.walletUtils.isWalletReady()) {
                console.warn('Wallet not connected');
                return;
            }

            const walletAddress = await window.walletUtils.getCurrentWalletAddress();
            document.getElementById('wallet-address-display').textContent = walletAddress;
            
            const balance = await window.stablecoinCFN.getCFNBalance(walletAddress);
            document.getElementById('dashboard-balance-amount').textContent = balance.display;
            
        } catch (error) {
            console.error('Balance update error:', error);
            document.getElementById('dashboard-balance-amount').textContent = 'Error';
        }
    }

    // Functions to handle the token operations
    async function handleTransfer() {
        const toAddress = document.getElementById('transfer-address').value;
        const amount = document.getElementById('transfer-amount').value;
        
        try {
            if (!toAddress || !amount) {
                alert('Veuillez remplir tous les champs');
                return;
            }
            
            const result = await window.stablecoinCFN.transferCFN(toAddress, amount);
            if (result) {
                // Update balance after transfer
                await updateDashboardBalance();
            }
        } catch (error) {
            console.error('Transfer error:', error);
        }
    }

    

    // Demande de faucet
    async function handleFaucetRequest() {
        console.log('Handling faucet request...');
        // Récupération des éléments du DOM
        const faucetBtn = document.getElementById('faucet-btn');
        const recipientAddress = document.getElementById('faucet-address').value.trim();
        const amountInput = document.getElementById('faucet-amount');
        const amount = amountInput.value.trim();
        const statusElement = document.getElementById('faucet-status');
        
        try {
            // Validation des entrées
            if (!recipientAddress) {
                throw new Error('Please enter recipient address');
            }
            
            // Validation stricte du montant
            const amountNum = parseFloat(amount);
            
            if (isNaN(amountNum)) {
                throw new Error('Amount must be a number');
            }
            
            if (amountNum <= 0) {
                throw new Error('Amount must be positive');
            }
            
            if (!/^\d+(\.\d{1,18})?$/.test(amount)) {
                throw new Error('Invalid amount format');
            }

            // Désactivation du bouton pendant le traitement
            faucetBtn.disabled = true;
            faucetBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';
            statusElement.textContent = 'Processing your request...';
            statusElement.className = 'small mt-2 text-info';

            // Appel de la fonction avec conversion du montant en string
            const result = await window.stablecoinCFN.requestCFNFromFaucet(
                recipientAddress, 
                amountNum.toString() // Conversion en string pour éviter les problèmes
            );
            
            if (result) {
                statusElement.textContent = 'Tokens minted successfully!';
                statusElement.className = 'small mt-2 text-success';
                
                // Mise à jour du solde si nécessaire
                const currentAddress = await window.walletUtils.getCurrentWalletAddress();
                if (recipientAddress.toLowerCase() === currentAddress.toLowerCase()) {
                    await updateDashboardBalance();
                }
            }
            
        } catch (error) {
            console.error('Faucet error:', error);
            statusElement.textContent = `Error: ${error.message}`;
            statusElement.className = 'small mt-2 text-danger';
            
            // Mise en évidence des champs invalides
            if (error.message.includes('recipient')) {
                document.getElementById('faucet-address').classList.add('is-invalid');
            }
            if (error.message.includes('Amount') || error.message.includes('amount')) {
                amountInput.classList.add('is-invalid');
            }
            
        } finally {
            // Réactivation du bouton
            faucetBtn.disabled = false;
            faucetBtn.innerHTML = '<i class="fas fa-faucet me-1"></i> Mint USDT Tokens';
            
            // Suppression des marqueurs d'erreur après délai
            setTimeout(() => {
                document.getElementById('faucet-address').classList.remove('is-invalid');
                amountInput.classList.remove('is-invalid');
            }, 3000);
        }
    }

    // Événements
    document.addEventListener('DOMContentLoaded', async function() {
        // Vérifier la connexion au chargement
        if (window.walletUtils && window.walletUtils.isWalletReady()) {
            await updateDashboardBalance();
        }
        
        // Écouter les changements de compte
        if (window.ethereum) {
            window.ethereum.on('accountsChanged', async () => {
                await updateDashboardBalance();
            });
            
            window.ethereum.on('chainChanged', async () => {
                await updateDashboardBalance();
            });
        }
    });

    // Écoutez les événements de connexion du wallet
    document.addEventListener('walletConnected', function() {
        updateDashboardBalance();
    });

    document.getElementById('faucet-btn').addEventListener('click', handleFaucetRequest); 
</script>