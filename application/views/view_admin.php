<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Horizon Game Panel</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/iCheck/flat/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker-bs3.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <!-- DATEPICKER --> <script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>

        <!-- datepicker --> <link href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />


        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>images/lo1go.png" type="image/x-icon">

        <script src="<?php echo base_url(); ?>js/admin/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin/sweetalert.css">
        <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.2.0.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.loading.block.js"></script>



    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php
            include('admin_layout/header.php');
            include('admin_layout/sidebar.php');
            include('admin_layout/content.php');
            ?>
        </div>

        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo base_url(); ?>js/admin/bootstrap.min.js"></script>
        <!-- Morris.js charts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="<?php echo base_url(); ?>plugins/morris/morris.min.js"></script>
        <!-- Sparkline -->
        <script src="<?php echo base_url(); ?>plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

        <!-- jQuery Knob Chart -->

        <!-- ChartJS 1.0.1 -->
        <script src="<?php echo base_url(); ?>plugins/chartjs/Chart.min.js"></script>


        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Slimscroll -->
        <script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?php echo base_url(); ?>dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    </body>


    <!-- jQuery 2.2.0 -->
    <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>/js/admin/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    <!-- page script -->
    <script>
            $(function() {
                $("#example1").DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]]
                });
                $("#example2").DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]]
                });
                $("#example3").DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]]
                });
                $("#example4").DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]]
                });
                $("#example5").DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]]
                });
                $("#example6").DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]]
                });
                $("#example7").DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]]
                });
                $("#example8").DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]]
                });
            });
    </script>

    <script>
<?php
if (isset($message)) {
                ?>
            if ('<?php echo $message; ?>' != '')
            {
                swal('<?php echo $message; ?>');
            }
    <?php
            }
if (isset($error)) {
    ?>
            if ('<?php echo $error; ?>' != '')
            {
                swal('<?php echo $error; ?>', '', "error");
            }
    <?php
}
?>
    </script>



</html>
