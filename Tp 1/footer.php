</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-GFX1Dnjo7s1sJKWAxkFZxz23VZYhAJoHc1CCgVuVn+Y5tI7iAc2tUEE04iP8Z9M7" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.getElementById('weaponsDropdown');
        var menu = document.querySelector('.dropdown-menu.megamenu');
        if (toggle && menu) {
            toggle.addEventListener('click', function (event) {
                event.preventDefault();
                var isOpen = menu.classList.contains('show');
                menu.classList.toggle('show', !isOpen);
                toggle.classList.toggle('show', !isOpen);
                toggle.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
            });

            document.addEventListener('click', function (event) {
                if (!toggle.contains(event.target) && !menu.contains(event.target)) {
                    menu.classList.remove('show');
                    toggle.classList.remove('show');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        }

        var cartToggle = document.getElementById('cartToggle');
        var cartBackdrop = document.getElementById('cartBackdrop');
        var cartDrawer = document.getElementById('cartDrawer');
        var cartClose = document.getElementById('cartClose');

        function openCart() {
            cartDrawer.classList.add('open');
            cartBackdrop.classList.add('visible');
            document.body.classList.add('cart-open');
        }

        function closeCart() {
            cartDrawer.classList.remove('open');
            cartBackdrop.classList.remove('visible');
            document.body.classList.remove('cart-open');
            if (window.location.hash === '#cart') {
                history.replaceState(null, '', window.location.pathname + window.location.search);
            }
        }

        if (window.location.hash === '#cart') {
            openCart();
        }

        if (cartToggle) {
            cartToggle.addEventListener('click', function () {
                if (cartDrawer.classList.contains('open')) {
                    closeCart();
                } else {
                    openCart();
                }
            });
        }

        if (cartBackdrop) {
            cartBackdrop.addEventListener('click', closeCart);
        }

        if (cartClose) {
            cartClose.addEventListener('click', closeCart);
        }
    });
</script>
</body>
</html>
