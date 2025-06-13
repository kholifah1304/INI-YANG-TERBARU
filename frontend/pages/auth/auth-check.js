document.addEventListener('DOMContentLoaded', function() {
    checkAuthStatus();
    
    function checkAuthStatus() {
        const isLoggedIn = document.cookie.includes('id_user=');
        
        if (isLoggedIn) {
            setupLoggedInUI();
        } else {
            setupLoggedOutUI();
        }
    }
    
    function setupLoggedInUI() {
        // Update tombol Shop Now
        const shopNowBtn = document.querySelector('.btn-shop');
        if (shopNowBtn) {
            shopNowBtn.textContent = 'Shop Now';
            shopNowBtn.href = 'produk.php';
        }
        
        // Setup user dropdown
        setupUserDropdown();
        
        // Load user data
        fetchUserData();
    }
    
    function setupLoggedOutUI() {
        // Update tombol Shop Now
        const shopNowBtn = document.querySelector('.btn-shop');
        if (shopNowBtn) {
            shopNowBtn.textContent = 'Login to Shop';
            shopNowBtn.href = 'auth/login.php';
        }
        
        // Setup icon user untuk login
        const userContainer = document.getElementById('userContainer');
        if (userContainer) {
            userContainer.innerHTML = `
                <a href="auth/login.php" class="icon-user">👤</a>
            `;
        }
    }
    
    function setupUserDropdown() {
        const userContainer = document.getElementById('userContainer');
        if (userContainer) {
            userContainer.innerHTML = `
                <div class="user-dropdown">
                    <button class="user-btn" id="userBtn">👤</button>
                    <div class="dropdown-content" id="userDropdown">
                        <div class="user-info">
                            <span id="userUsername">Loading...</span>
                            <span id="userEmail"></span>
                        </div>
                        <a href="auth/logout.php" class="logout-btn">Logout</a>
                    </div>
                </div>
            `;
            
            const userBtn = document.getElementById('userBtn');
            const dropdown = document.getElementById('userDropdown');
            
            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });
            
            document.addEventListener('click', function() {
                dropdown.style.display = 'none';
            });
        }
    }
    
    function fetchUserData() {
        fetch('auth/get-user-data.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const usernameEl = document.getElementById('userUsername');
                    const emailEl = document.getElementById('userEmail');
                    
                    if (usernameEl) usernameEl.textContent = data.user.username;
                    if (emailEl) emailEl.textContent = data.user.email;
                }
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
            });
    }
});