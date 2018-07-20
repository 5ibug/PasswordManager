<?php
require_once 'Config.php';
session_start();
$user=new User();
$log=new log();
if (!$user->Auth($mysql)){ //验证否登陆过
    header("Location: login.php");
}else{
    $password=new password($user->username);
}
if($_GET['id']==null){
    ?>
    <script>
    alert('未找到id');
    window.location.href='add-password.php';
    </script>
    <?php
    exit();
}
$temp = $password->checkpwd($mysql,$_GET['id'])[0];
if($temp['name'] != $user->username){
    ?>
    <script>
    alert('归属权不是您');
    window.location.href='read-password.php';
    </script>
    <?php
    exit();
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>小可爱的密码管理 - 吾爱bug</title> 

	<link href="https://fonts.lug.ustc.edu.cn/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="assets/materialize/css/materialize.min.css" media="screen,projection" />
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />

    <link rel="stylesheet" href="assets/js/Lightweight-Chart/cssCharts.css"> 
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle waves-effect waves-dark" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand waves-effect waves-dark" href="index.html"><i class="large material-icons">track_changes</i> <strong>密码管理</strong></a>
				
		<div id="sideNav" href=""><i class="material-icons dp48">toc</i></div>
            </div>

            <ul class="nav navbar-top-links navbar-right"> 
				<li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown1"><i class="fa fa-user fa-fw"></i> <b><?php echo $user->username; ?></b> <i class="material-icons right">arrow_drop_down</i></a></li>
            </ul>
        </nav>
<ul id="dropdown1" class="dropdown-content">
<li><a href="#"><i class="fa fa-user fa-fw"></i> 个人信息</a>
</li>
<li><a href="#"><i class="fa fa-gear fa-fw"></i> 设置</a>
</li> 
<li><a href="./logout.php"><i class="fa fa-sign-out fa-fw"></i> 注销</a>
</li>
</ul>
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu waves-effect waves-dark" href="index.html"><i class="fa fa-dashboard"></i> 仪表盘</a>
					</li>
					<li>
						<a href="#" class="waves-effect waves-dark"><i class="fa fa-desktop"></i> 用户管理<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
                            <li>
                                <a href="list-user.php">用户列表</a>
                            </li>
                        </ul>
					</li>
                    <li>
						<a href="#" class="waves-effect waves-dark"><i class="fa fa-edit"></i> 密码管理<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
                            <li>
                                <a href="add-password.php">添加密码</a>
                            </li>
                            <li>
                                <a href="read-password.php">查看密码</a>
                            </li>
                        </ul>
					</li>
                    <li>
                        <a href="#" class="waves-effect waves-dark"><i class="fa fa-sitemap"></i> 用户日志<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="login-log.php">登录日志</a>
                            </li>
                            <li>
                                <a href="all-log.php">全部日志</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="https://www.5ibug.net" class="waves-effect waves-dark"><i class="fa fa-fw fa-file"></i> 吾爱bug</a>
                    </li>
                </ul>

            </div>

        </nav>
      
		<div id="page-wrapper">
		  <div class="header"> 
                        <h1 class="page-header">
                            添加密码
                        </h1>
						<ol class="breadcrumb">
					  <li><a href="list-user.php">列表</a></li>
					  <li><a href="all-log.php">日志</a></li>
					  <li class="active">仪表盘</li>
					</ol> 
									
		</div>
            <div id="page-inner">
            <form class="col s12" tautocomplete="off" name="form2" action='update-password.php?id=<?php echo $_GET['id'];?>' method='post'>
			<div class="row">
			 <div class="col-lg-12">
			 <div class="card">
                        <div class="card-action">
                            更新密码
                        </div>
                        <div class="card-content">
                        <form class="col s12" tautocomplete="off" name="form2" action='update-password.php' method='post'>
                        <div class="row">
                            <div class="input-field col s12">
                            <input id="user_name" name="user_name" type="text" class="validate" value="<?php echo $temp['user'];?>">
                            <label for="user_name" class="active">user</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                            <input id="password" name="password" type="text" class="validate" value="<?php echo $password->A_decrypt($temp['password'], SECRETKEY);?>">
                            <label for="password" class="">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                            <input id="url" name="url" type="url" class="validate" value="<?php echo $temp['url'];?>">
                            <label for="url" class="">url</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                            <input id="tags" name="tags" type="text" class="validate" value="<?php echo $temp['tags'];?>">
                            <label for="tags" class="">tags</label>
                            </div>
                        </div>
                        <a class="waves-effect waves-light btn" href='javascript:document.form2.submit();'>更新密码</a>
                        </form>
                        <div class="clearBoth"></div>
                    </div>
                        </div>
                    </div>	
                        </div>
                
				<footer><p>All right reserved. by: <a href="https://www.5ibug.net/">吾爱bug</a></p>
				
        
				</footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>

    <script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/materialize/js/materialize.min.js"></script>

    <script src="assets/js/jquery.metisMenu.js"></script>

	
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>

	 <script src="assets/js/Lightweight-Chart/jquery.chart.js"></script>

	<script src="assets/js/morris/morris.js"></script>
    <script src="assets/js/custom-scripts.js"></script> 
 

</body>

</html>