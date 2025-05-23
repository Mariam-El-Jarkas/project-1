document.addEventListener('DOMContentLoaded', function() {
    // Dropdown functionality
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.closest('.dropdown');
            const submenu = this.nextElementSibling;
            
            // Close other dropdowns
            document.querySelectorAll('.dropdown').forEach(d => {
                if(d !== dropdown) {
                    d.classList.remove('active');
                    d.querySelector('.submenu').classList.remove('active');
                }
            });
            
            // Toggle current
            dropdown.classList.toggle('active');
            submenu.classList.toggle('active');
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown').forEach(d => {
                d.classList.remove('active');
                d.querySelector('.submenu').classList.remove('active');
            });
        }
    });

    // Mobile menu toggle
    const mobileToggle = document.getElementById('mobileMenuToggle');
    if(mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    }
});