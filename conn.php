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
$pwd = $_GET["password"];
$key = 'hebingchang'; 
$strenc = authcode($pwd,'ENCODE',$key,0); //���� 
$usrenc = authcode($str,'ENCODE',$key,0); //���� 


$dbh = @mysql_connect("localhost:3306","root","gerenyinsi"); 
/* �������dbh , mysql_connect()��������˼������mysql���ݿ�, "@"����˼�����α��� */ 
if(!$dbh){die("error");} 
/* die()��������˼�ǽ���������ִ��͵���������ж�PHP��ʽ (Script)��������Ĳ���Ϊ���ͳ����ִ��� */
@mysql_select_db("score", $dbh); 
/* ѡ��mysql���������һ�����ݿ�,����ѡ�����ݿ���Ϊ ok */ 
$q = "SELECT * FROM user"; 
/* �������q, "SELECT * FROM abc"��һ��SQL���,��˼�Ƕ�ȡ��abc�е����� */ 
$rs = mysql_query($q, $dbh); 
/* ������� rs ,����mysql_query()����˼��:�ͳ� query �ִ��� MySQL ����صĴ������ִ��.����php�Ǵ�������ִ�е�,����,rs��ֵ�Ƿ���������mysql_query()�����󷵻ص�ֵ */ 
mysql_query("SET NAMES UTF8");
if(!$rs){die("Valid result!");} 
while($row = mysql_fetch_row($rs)) 
{
	if ($str == $row[0]) {
		if ($pwd == authcode($row[1],'DECODE',$key,0)) {
			header("Location: user.php?username=" . $usrenc); 
			//ȷ���ض���󣬺������벻�ᱻִ�� 
			@mysql_close($dbh); 
			exit;
		} else {
			header("Location: login.php?info=wrongpwd"); 
			@mysql_close($dbh); 
			exit;
		}
	}
	header("Location: login.php?info=nouser"); 
	@mysql_close($dbh); 
}
	

/* ��������(����)row,������whileѭ��,������һһд����.  
����mysql_fetch_row()����˼��:����ѯ���$rs���в����б�����.  
$row[0] �� $row[1] ��λ�ÿ��Ի�*/ 
@mysql_close($dbh); 
/* �رյ�mysql���ݿ������ */ 



//$str = '56f4yER1DI2WTzWMqsfPpS9hwyoJnFP2MpC8SOhRrxO7BOk'; 
//echo authcode($str,'DECODE',$key,0); //���� 
?>