    <script src="./js/sweetaler.js"></script>
    
    <script src="./js/ajx.js"></script>
    <!-- jQuery -->
    <script src="./plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./plugins/bootstrap/dist/js/bootstrap.min.js"></script>    
    <!-- Custom Theme Scripts -->
    <script src="./js/custom.min.js"></script>
    <script src="./js/select2.min.js"></script>
    <!-- <script src="./js/chart.js"></script> -->

    <script>
        $(document).ready(function() {
            function formatState (state) {
                if (!state.id) {
                    return state.text;
                }
                var baseUrl = state.element.getAttribute('data-icon');
                var $state = $(
                    '<span><img src="./biblioteca/images/icon/' + baseUrl + '" class="img-flag" /> ' + state.text + '</span>'
                );
                return $state;
            };

            $("#icon-select").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        });      
    </script>



    