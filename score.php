
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
      <?php
		header("Content-Type: text/html; charset=gb2312");
	  ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ����3��meta��ǩ*����*������ǰ�棬�κ��������ݶ�*����*������� -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>����ϵͳ ����̨</title>

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
          <a class="navbar-brand" href="#">����ϵͳ ����̨</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">����̨</a></li>
            <li><a href="#">����</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
			<li><a href="index.php">��ҳ</a></li>
            <li class="active"><a href="score.php">���� <span class="sr-only">(current)</span></a></li>
            <!--<li><a href="#">Reports</a></li>-->
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">����̨</h1>
		  <a class="btn btn-default" href="#" role="button" data-toggle="modal" data-target="#ModalAdd">����û�</a>

          <h2 class="sub-header">���ָ���</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>����</th>
                  <th>����</th>
                  <th>����������</th>
                  <th>�޸�</th>
				  <th>ɾ��</th>
                </tr>
              </thead>
              <tbody>
                <tr>
				<?php
$dbh = @mysql_connect("localhost:3306","root","gerenyinsi"); 
/* �������dbh , mysql_connect()��������˼������mysql���ݿ�, "@"����˼�����α��� */ 
if(!$dbh){die("error");} 
/* die()��������˼�ǽ���������ִ��͵���������ж�PHP��ʽ (Script)��������Ĳ���Ϊ���ͳ����ִ��� */
@mysql_select_db("score", $dbh); 
/* ѡ��mysql���������һ�����ݿ�,����ѡ�����ݿ���Ϊ ok */ 
$q = "SELECT * FROM score"; 
/* �������q, "SELECT * FROM abc"��һ��SQL���,��˼�Ƕ�ȡ��abc�е����� */ 
$rs = mysql_query($q, $dbh); 
/* ������� rs ,����mysql_query()����˼��:�ͳ� query �ִ��� MySQL ����صĴ������ִ��.����php�Ǵ�������ִ�е�,����,rs��ֵ�Ƿ���������mysql_query()�����󷵻ص�ֵ */ 
mysql_query("SET NAMES UTF8");
if(!$rs){die("Valid result!");} 
while($row = mysql_fetch_row($rs)) echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td><td><p><a class="btn btn-default" href="#" role="button">�޸Ļ��� &raquo;</a></p></td>
				  <td><p><a class="btn btn-default" href="#" role="button">ɾ���û� &raquo;</a></p></td></tr>'; 
/* ��������(����)row,������whileѭ��,������һһд����.  
����mysql_fetch_row()����˼��:����ѯ���$rs���в����б�����.  
$row[0] �� $row[1] ��λ�ÿ��Ի�*/ 
@mysql_close($dbh); 
/* �رյ�mysql���ݿ������ */ 
?> 
                  <td>����</td>
                  <td>233</td>
                  <td>2015/5/24</td>
                  <td><p><a class="btn btn-default" href="#" role="button">�޸Ļ��� &raquo;</a></p></td>
				  <td><p><a class="btn btn-default" href="#" role="button">ɾ���û� &raquo;</a></p></td>
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
			<h4 class="modal-title" id="myModalLabel">ɾ���û�
		  <div class="modal-body">
			<div class="input-group">
			  <span class="input-group-addon" id="basic-addon1">����</span>
			  <input type="text" class="form-control" placeholder="Ҫɾ�����û�" aria-describedby="basic-addon1">
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">�ر�</button>
			<button type="button" class="btn btn-primary" onclick="javascript:add();">���</button>
		  </div>
		</div>
	  </div>
	</div>
<script>
     function deleteuser(){
      //����д��Ҫִ�е����
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
