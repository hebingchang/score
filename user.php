<?php
  function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {   
    // ��̬�ܳ׳��ȣ���ͬ�����Ļ����ɲ�ͬ���ľ���������̬�ܳ�   
    $ckey_length = 4;   
       
    // �ܳ�   
    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);   
       
    // �ܳ�a�����ӽ���   
    $keya = md5(substr($key, 0, 16));   
    // �ܳ�b��������������������֤   
    $keyb = md5(substr($key, 16, 16));   
    // �ܳ�c���ڱ仯���ɵ�����   
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): 
substr(md5(microtime()), -$ckey_length)) : '';   
    // ����������ܳ�   
    $cryptkey = $keya.md5($keya.$keyc);   
    $key_length = strlen($cryptkey);   
    // ���ģ�ǰ10λ��������ʱ���������ʱ��֤������Ч�ԣ�10��26λ��������$keyb(�ܳ�b)�� 
//����ʱ��ͨ������ܳ���֤����������   
    // ����ǽ���Ļ�����ӵ�$ckey_lengthλ��ʼ����Ϊ����ǰ$ckey_lengthλ���� ��̬�ܳף��Ա�֤������ȷ   
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :  
sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;   
    $string_length = strlen($string);   
    $result = '';   
    $box = range(0, 255);   
    $rndkey = array();   
    // �����ܳײ�   
    for($i = 0; $i <= 255; $i++) {   
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);   
    }   
    // �ù̶����㷨�������ܳײ�����������ԣ�����ܸ��ӣ�ʵ���϶Բ������������ĵ�ǿ��   
    for($j = $i = 0; $i < 256; $i++) {   
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;   
        $tmp = $box[$i];   
        $box[$i] = $box[$j];   
        $box[$j] = $tmp;   
    }   
    // ���ļӽ��ܲ���   
    for($a = $j = $i = 0; $i < $string_length; $i++) {   
        $a = ($a + 1) % 256;   
        $j = ($j + $box[$a]) % 256;   
        $tmp = $box[$a];   
        $box[$a] = $box[$j];   
        $box[$j] = $tmp;   
        // ���ܳײ��ó��ܳ׽��������ת���ַ�   
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));   
    }   
    if($operation == 'DECODE') {  
        // ��֤������Ч�ԣ��뿴δ�������ĵĸ�ʽ   
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&  
substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {   
            return substr($result, 26);   
        } else {   
            return '';   
        }   
    } else {   
        // �Ѷ�̬�ܳױ������������Ҳ��Ϊʲôͬ�������ģ�������ͬ���ĺ��ܽ��ܵ�ԭ��   
        // ��Ϊ���ܺ�����Ŀ�����һЩ�����ַ������ƹ��̿��ܻᶪʧ��������base64����   
        return $keyc.str_replace('=', '', base64_encode($result));   
    }   
} 

$str = $_GET["username"];
$key = 'hebingchang';
$user = authcode($str,'DECODE',$key,0); //���� 
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
while($row = mysql_fetch_row($rs)) 
{
	if ($user == $row[0]) {
		$score = $row[1];
		$date = $row[2];
	}
}
@mysql_close($dbh); 

?>

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

    <title>����ƽ̨</title>

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
          <a class="navbar-brand" href="#">����ƽ̨</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">���ֹ���</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
			<li class="active"><a href="#">���� <span class="sr-only">(current)</span></a></li>
            <li><a href="#">���ֶһ�(Not available now)</a></li>
            <!--<li><a href="#">Reports</a></li>-->
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div class="alert alert-info" role="alert">��ӭ��, <?php echo($user); ?></div>
			���˻���Ŀǰ�� <?php echo($score); ?> ����֣�����������Ϊ <?php echo($date); ?> ��
        </div>
      </div>
    </div>
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

