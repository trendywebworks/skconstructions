        <!--  BEGIN FOOTER  -->
        <?php require_once('partials/footer/copyright.php'); ?> 
        <!--  END CONTENT AREA  -->
    </div>
    <!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->

<!-- Jquery -->
<script src=
"https://code.jquery.com/jquery-3.6.1.min.js" 
        integrity=
"sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" 
        crossorigin="anonymous">
    </script>

<!-- GLOBAL MANDATORY SCRIPTS -->
<script src="src/plugins/src/global/vendors.min.js"></script>
<script src="src/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="src/plugins/src/mousetrap/mousetrap.min.js"></script>
<script src="src/plugins/src/waves/waves.min.js"></script>
<script src="src/layouts/js/app.js"></script>
<script src="src/assets/js/custom.js"></script>

<!-- DASHBOARD SCRIPTS -->
<!--
<script src="src/plugins/src/apex/apexcharts.min.js"></script>
<script src="src/assets/js/dashboard/dash_2.js"></script>
-->

<!-- DATATABLES SCRIPTS -->
<script src="src/plugins/src/table/datatable/datatables.js"></script>
<script src="src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="src/plugins/src/table/datatable/button-ext/jszip.min.js"></script>
<script src="src/plugins/src/table/datatable/button-ext/buttons.html5.min.js"></script>
<script src="src/plugins/src/table/datatable/button-ext/buttons.print.min.js"></script>
<script src="src/plugins/src/table/datatable/custom_miscellaneous.js"></script>
<!-- END DATATABLES SCRIPTS --> 

    <script>
        $(function () {
            $("#datepicker").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                todayBtn : "linked",
            }).datepicker('update', new Date());
        });

        $(function () {
            $("#datepicker2").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                todayBtn : "linked",
            }).datepicker('update', new Date());
        });
        $(function () {
            $("#datepicker3").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                todayBtn : "linked",
            }).datepicker('update', new Date());
        });
        $(function () {
            $("#datepicker4").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                todayBtn : "linked",
            }).datepicker('update', new Date());
        });
    </script>

<!-- DATEPICKER SCRIPTS -->
<script src=
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>


</body>
</html>