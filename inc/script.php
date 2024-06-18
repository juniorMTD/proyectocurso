    <script src="./js/sweetaler.js"></script>
    
    <script src="./js/ajx.js"></script>
    <!-- jQuery -->
    <script src="./plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./plugins/bootstrap/dist/js/bootstrap.min.js"></script>    
    <!-- Custom Theme Scripts -->
    <script src="./js/custom.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Get all "navbar-burger" elements
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

            // Add a click event on each of them
            $navbarBurgers.forEach(el => {
                el.addEventListener('click', () => {

                    // Get the target from the "data-target" attribute
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);

                    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                    el.classList.toggle('is-active');
                    $target.classList.toggle('is-active');

                });
            });

        });
        
    </script>



    