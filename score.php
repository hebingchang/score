
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
      <?php
		header("Content-Type: text/html; charset=gb2312");
	  ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>积分系统 控制台</title>

    <!-- Bootstrap core CSS -->
    <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">积分系统 控制台</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">控制台</a></li>
            <li><a href="#">关于</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
			<li><a href="index.php">首页</a></li>
            <li class="active"><a href="score.php">概览 <span class="sr-only">(current)</span></a></li>
            <!--<li><a href="#">Reports</a></li>-->
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">控制台</h1>
		  <a class="btn btn-default" href="#" role="button" data-toggle="modal" data-target="#ModalAdd">添加用户</a>

          <h2 class="sub-header">积分概览</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>姓名</th>
                  <th>积分</th>
                  <th>最后积分日期</th>
                  <th>修改</th>
				  <th>删除</th>
                </tr>
              </thead>
              <tbody>
                <tr>
				<?php
$dbh = @mysql_connect("localhost:3306","root","gerenyinsi"); 
/* 定义变量dbh , mysql_connect()函数的意思是连接mysql数据库, "@"的意思是屏蔽报错 */ 
if(!$dbh){die("error");} 
/* die()函数的意思是将括号里的字串送到浏览器并中断PHP程式 (Script)。括号里的参数为欲送出的字串。 */
@mysql_select_db("score", $dbh); 
/* 选择mysql服务器里的一个数据库,这里选的数据库名为 ok */ 
$q = "SELECT * FROM score"; 
/* 定义变量q, "SELECT * FROM abc"是一个SQL语句,意思是读取表abc中的数据 */ 
$rs = mysql_query($q, $dbh); 
/* 定义变量 rs ,函数mysql_query()的意思是:送出 query 字串供 MySQL 做相关的处理或者执行.由于php是从右往左执行的,所以,rs的值是服务器运行mysql_query()函数后返回的值 */ 
mysql_query("SET NAMES UTF8");
if(!$rs){die("Valid result!");} 
while($row = mysql_fetch_row($rs)) echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td><td><p><a class="btn btn-default" href="#" role="button">修改积分 &raquo;</a></p></td>
				  <td><p><a class="btn btn-default" href="#" role="button">删除用户 &raquo;</a></p></td></tr>'; 
/* 定义量变(数组)row,并利用while循环,把数据一一写出来.  
函数mysql_fetch_row()的意思是:将查询结果$rs单列拆到阵列变数中.  
$row[0] 和 $row[1] 的位置可以换*/ 
@mysql_close($dbh); 
/* 关闭到mysql数据库的连接 */ 
?> 
                  <td>康琦</td>
                  <td>233</td>
                  <td>2015/5/24</td>
                  <td><p><a class="btn btn-default" href="#" role="button">修改积分 &raquo;</a></p></td>
				  <td><p><a class="btn btn-default" href="#" role="button">删除用户 &raquo;</a></p></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
	<!-- Modal -->
	<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">删除用户
		  <div class="modal-body">
			<div class="input-group">
			  <span class="input-group-addon" id="basic-addon1">姓名</span>
			  <input type="text" class="form-control" placeholder="要删除的用户" aria-describedby="basic-addon1">
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			<button type="button" class="btn btn-primary" onclick="javascript:add();">添加</button>
		  </div>
		</div>
	  </div>
	</div>
<script>
     function deleteuser(){
      //这里写你要执行的语句
}
</script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="./js/vendor/holder.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
