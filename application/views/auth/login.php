<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    // Load the style settings
		 $this -> load -> view('Custom');
		 Customize::generateStyles();
		 
		 Customize::generateFonts();

    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container-fluid ">
    <div class="login row-fluid centering col-lg-4 col-md-5 col-sm-6 col-xs-10 row">
        <div class="panel form">
            <h1 class="panel-heading row"><?php echo lang('login_heading'); ?></h1>

            <div class="modal-body row">
                <div class="subheading col-md-12"><?php echo lang('login_subheading'); ?></div>

                <div class="col-md-12 message"><?php echo $message; ?></div>

                <div class="col-md-12"><?php echo form_open("auth/login"); ?></div>

                <div class="form-group">
                    <div class="col-md-12 control-label"><?php echo lang('login_identity_label', 'identity'); ?></div>
                    <div
                        class="col-md-12"><?php echo form_input(array_merge( $identity, array('class' => 'form-control'))); ?></div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 control-label"> <?php echo lang('login_password_label', 'password'); ?></div>
                    <div
                        class="col-md-12"><?php echo form_input(array_merge( $password, array('class' => 'form-control'))); ?></div>

                </div>

                <div class="form-group">
                    <div class="col-md-12  checkbox">
                        <label>
                            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
                            Запомнить меня
                        </label>
                    </div>
                </div>


                <div
                    class="col-md-4 button"><?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-primary btn-block"') ?></div>

                <div class="col-md-12"><?php echo form_close(); ?></div>

                <div class="col-md-4"><p class="bg-info"><a href="forgot_password"><?php echo lang('login_forgot_password'); ?></a></p></div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('body').on('show', '.container', function () {
        $(this).css({'margin-top': ($(window).height() - $(this).height()) / 2, 'top': '0'});
    });
</script>
</body>
</html>