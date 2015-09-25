<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SACP - Login Administrator</title>

    <link href="<?php echo assets_url('bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo assets_url('bower_components/metisMenu/dist/metisMenu.min.css') ?>" rel="stylesheet">

    <link href="<?php echo assets_url('dist/css/sb-admin-2.css') ?>" rel="stylesheet">
    <link href="<?php echo assets_url('bower_components/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                    <?php echo $this->session->flashdata('failed') ?>
                        <form role="form" method="post" action="<?php echo site_url('admin/login') ?>">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="user_name" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="user_password" type="password">
                                </div>

                                <button class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo assets_url('bower_components/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?php echo assets_url('bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo assets_url('bower_components/metisMenu/dist/metisMenu.min.js') ?>"></script>
    <script src="<?php echo assets_url('dist/js/sb-admin-2.js') ?>"></script>

</body>
</html>
