<script>
function toggleCart() {
    const panel = document.getElementById('cartPanel');
    const overlay = document.getElementById('overlay');

    panel.classList.toggle('open');
    overlay.classList.toggle('show');

    if (panel.classList.contains('open')) {
        fetch('cart.php')
            .then(res => res.text())
            .then(data => {
                document.getElementById('cartContent').innerHTML = data;
            });
    }
}
</script>
