<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo util::getConfig('sitename', 'global');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo util::getConfig('description', 'global');?>"/>
    <meta name="keywords" content="<?php echo util::getConfig('keywords', 'global');?>"/>
    <!-- Le styles -->
    <link href="static/css/bootstrap.min.css" rel="stylesheet">
    <link href="static/css/common.css" rel="stylesheet">
    <link href="static/css/bootstrap-responsive.min.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="static/js/html5shiv.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="masthead">
        <h3 class="muted">以书会友</h3>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul class="nav">
                        <li class="active"><a href="index.php">Library</a></li>
                        <li><a href="javascript:void(0);">Downloads</a></li>
                        <li><a href="javascript:void(0);">Projects</a></li>
                        <li><a href="javascript:void(0);">About</a></li>
                        <li><a href="javascript:void(0);">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div><!-- /.navbar -->
    </div>
    <?php echo $layoutContent;?>
    <hr>
    <div class="footer">
        <p>&copy; Company 2013</p>
    </div>
</div> <!-- /container -->
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="static/js/jquery.min.js"></script>
<script src="static/js/bootstrap.min.js"></script>
</body>
</html>
