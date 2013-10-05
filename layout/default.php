<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo util::getConfig('sitename', 'global');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo util::getConfig('description', 'global');?>"/>
    <meta name="keywords" content="<?php echo util::getConfig('keywords', 'global');?>"/>
    <script src="static/js/jquery.min.js"></script>
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
        <h3 class="muted"><img src="static/img/top.png"/></h3>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul class="nav">
                        <li <?php if($atype=="home"):?> class="active" <?php endif;?>><a href="index.php">Library</a></li>
                        <li <?php if($atype=="downloads"):?> class="active" <?php endif;?>><a href="index.php?a=downloads">Downloads</a></li>
                        <li <?php if($atype=="projects"):?> class="active" <?php endif;?>><a href="index.php?a=projects">Projects</a></li>
                        <li <?php if($atype=="about"):?> class="active" <?php endif;?>><a href="index.php?a=about">About</a></li>
                    </ul>
                </div>
            </div>
        </div><!-- /.navbar -->
    </div>
    <?php echo $layoutContent;?>
    <hr>
    <div class="footer">
        <div class="row-fluid">
                <div class="span4">
                    <p>
                        ShareBook  &copy; Vincentguo<br/>
                        QQ:364054110<br/>
                        Sina Weibo:<a href="http://www.weibo.com/qyclass/" target="_blank">Follow Me</a>
                        Email:Vincentguo@anjuke.com
                    </p>
                </div>
                <div class="span8" style="text-align: right;">
                        <img  style="width: 150px; height: 150px;" src="static/img/follow.jpeg"/>
                </div>
        </div>
    </div>
</div> <!-- /container -->
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="static/js/bootstrap.min.js"></script>
<script src="static/js/common.js"></script>
</body>
</html>
