<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Horizon Game</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/iCheck/square/blue.css">

        <script src="<?php echo base_url(); ?>js/admin/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin/sweetalert.css">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>images/lo1go.png" type="image/x-icon">


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?php echo base_url() . ADMIN_PAGE_HOME; ?>">Horizon Game Panel</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="<?php echo base_url() . ADMIN_ACTION_LOGIN; ?>" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="UserName" name='user'>                        
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name='pw'>                        
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">

                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.0 -->
        <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.2.0.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function() {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
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
    </body>
</html>
