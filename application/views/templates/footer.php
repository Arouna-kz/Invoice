</main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-warning">CoinFinance</h5>
                    <p class="mb-0">Decentralized invoice tokenization platform</p>
                    <small class="text-muted">Powered by Hedera Network</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="social-links mb-2">
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-telegram"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-discord"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-github"></i></a>
                    </div>
                    <small class="text-muted">© 2024 CoinFinance. All rights reserved.</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript Files -->
    <script type="module" src="<?php echo base_url('assets/js/contracts/adminFunctions.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/walletUtils.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/contracts/uiUtils.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/contracts/ipfsUtils.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/sharedFunctions.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/stablecoinCFN.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/adminFunctions.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/enterpriseFunctions.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/investorFunctions.js'); ?>"></script>
    <script type="module" src="<?php echo base_url('assets/js/contracts/clientFunctions.js'); ?>"></script> 
    <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo base_url('assets/js/language.js'); ?>"></script>


    
    <!-- Page-specific JavaScript -->
    <?php if(isset($additional_js)): ?>
        <?php foreach($additional_js as $js_file): ?>
            <script src="<?php echo base_url('assets/js/' . $js_file); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <script>
        // Initialize application when DOM is ready
        $(document).ready(function() {
            initializeWallet();
            updateUILanguage();
            
            // Auto-update token balance every 30 seconds
            setInterval(updateTokenBalance, 30000);
            
            // Auto-update network status every 10 seconds
            setInterval(updateNetworkStatus, 10000);
        });
    </script>
</body>
</html>