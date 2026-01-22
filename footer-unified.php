            </main>
        </div>
    </div>

    <script>
        // Mobile menu toggle functionality
        function toggleMobileMenu() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('open');
        }

        // Add mobile menu button for smaller screens
        if (window.innerWidth <= 768) {
            const topBar = document.querySelector('.top-bar');
            const mobileMenuBtn = document.createElement('button');
            mobileMenuBtn.className = 'btn btn-ghost';
            mobileMenuBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            `;
            mobileMenuBtn.onclick = toggleMobileMenu;
            topBar.querySelector('div:first-child').appendChild(mobileMenuBtn);
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const mobileMenuBtn = document.querySelector('.btn-ghost');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !mobileMenuBtn?.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.querySelector('.sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
            }
        });

        // Add smooth transitions
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('animate-fadeIn');
        });
    </script>
</body>
</html>