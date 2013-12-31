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
                        <li <?php if($atype=="Media"):?> class="active" <?php endif;?>><a href="index.php?a=media">Media</a></li>
                        <li <?php if($atype=="projects"):?> class="active" <?php endif;?>><a href="index.php?a=projects">Projects</a></li>
                        <li <?php if($atype=="about"):?> class="active" <?php endif;?>><a href="index.php?a=about">About</a></li>
                        <li><a href="<?php echo uri::englishComUri();?>">YYABC</a></li>
                        <li><a href="<?php echo uri::homeinterUri();?>">IH</a></li>
                    </ul>
                    <form action="index.php" class="navbar-search pull-left">
                        <input name="bookname" type="text" placeholder="输入书籍名称" class="search-query span2">
                    </form>
                    <?php if($logstatus==1):?>
                    <ul class="nav pull-right">
                        <li><a href="javascript:void(0);"><?php echo $userinfo['uname'];?></a></li>
                        <li class="divider-vertical"></li>
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">Setting<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?c=tools">knapsack</a></li>
                                <li><a href="javascript:void(0);">Info</a></li>
                                <li><a href="index.php?a=logout">LogOut</a></li>
                            </ul>
                        </li>
                    </ul>
                    <?php else:?>
                    <ul class="nav pull-right">
                        <li class="divider-vertical"></li>
                        <li><a href="<?php echo uri::loginUri();?>">Login</a></li>
                    </ul>
                    <?php endif;?>
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
                        ShareBook  &copy; 狂神<br/>
                        QQ:1586538192<br/>
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
