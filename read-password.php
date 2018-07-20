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
                            全部密码
                        </h1>
						<ol class="breadcrumb">
                      <li><a href="./list-user.php">列表</a></li>
					  <li><a href="./all-log.php">日志</a></li>
					  <li><a href="./index.php">仪表盘</a></li>
					</ol> 
									
		</div>
            <div id="page-inner">

			            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="card">
                        <div class="card-action">
                             用户 <?php echo $user->username; ?>全部密码
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th class="center">ID</th>
                                            <th class="center">用户名</th>
                                            <th class="center">密码</th>
                                            <th class="center">url</th>
                                            <th class="center">tags</th>
                                            <th class="center">创建时间</th>
                                            <th class="center">修改时间</th>
                                            <th class="center">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <?php
                                        $logcon=$password->Read_Password($mysql);

                                        for($i = 0; $i < sizeof($logcon); $i++){
                                            echo "  <tr>
                                                        <td class=\"center\">".($i + 1)."</td>
                                                        <td class=\"center\">".$logcon[$i]['user']."</td>
                                                        <td class=\"center\">".$password->A_decrypt($logcon[$i]['password'], SECRETKEY)."</td>
                                                        <td class=\"center\"><a href=\"".$logcon[$i]['url']."\"><i class=\"material-icons dp48\">language</i></a></td>
                                                        <td class=\"center\">".$logcon[$i]['tags']."</td>
                                                        <td class=\"center\">".date("Y-m-d h:i:s", $logcon[$i]['newtime'])."</td>
                                                        <td class=\"center\">".date("Y-m-d h:i:s", $logcon[$i]['revisetime'])."</td>
                                                        <td class=\"center\">
                                                                <a class=\"waves-effect waves-light btn\" href='r-password.php?id=".$logcon[$i]['id']."'>改</a> 
                                                                <a class=\"waves-effect waves-light btn\" href='del-password.php?id=".$logcon[$i]['id']."'>删</a></td>
                                                    </tr>";
                                        }
                                        $log->WriteLog($mysql,$user->username,'see password');
                                        ?>

                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>


				<footer><p>All right reserved. by: <a href="https://www.5ibug.net/">吾爱bug</a></p></footer>
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
     <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable({
                    
                language: {
                    "sProcessing": "处理中...",
                    "sLengthMenu": "显示 _MENU_ 项结果",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                }
                });
            });
    </script>
	<script src="assets/js/morris/morris.js"></script>
    <script src="assets/js/custom-scripts.js"></script> 
 

</body>

</html>