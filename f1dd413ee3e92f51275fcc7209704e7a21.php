<?php
/**
*Date:2015-12-1
*author:boboit
* method:Habari 自动配置程序
 * 
 */

// include './checkParameter.php';

header("Content-type: text/html; charset=utf-8");
set_time_limit(0);
$istatus = 0;

$front = <<<FRONT
<?php if ( !defined( 'HABARI_PATH' ) ) { die( 'No direct access' ); }
define('APP_ROOT', "www.{DBNAME}.com");
define('APP_NAME', "/tempEP/");
define('APP_PRO', "");  //填写当前行项目路径，服务器默认为空
Config::set( 'db_connection', array(
	'connection_string'=>'mysql:host=localhost;dbname={DBNAME}',
	'username'=>'{DBUSER}',
	'password'=>'{DBPASS}',
	'prefix'=>'h'
));

// Config::set('locale', 'en-us');
?>

FRONT;


// $domain = $_POST['domain'];
$domain = $_SERVER['SERVER_NAME'];
$suffix = $domain;
if (strpos($domain, 'www.') !== false) $suffix = substr($domain, 4);
if (strpos($suffix, ':') > 0) $suffix = substr($suffix, 0, strpos($suffix, ':'));

$short_host = $suffix;
if (strrpos($suffix, '.') > 0) $short_host = substr($suffix, 0, strrpos($suffix, '.'));

$ht_domain = $suffix;
// $root_dir = $_POST['root_dir'];
$root_dir = realpath(dirname(__FILE__));

//添加了p_path的定义 -- boboit 2015.10.23
$p_path = trim(trim(dirname($_SERVER['PHP_SELF']), '/'),'\\');

$catalog = isset($_POST['catalog']) ? $_POST['catalog'] : '';

$db_user = '';
$db_name = '';
$db_pass = '';


if (!empty($_POST['db_user'])) $db_user = $_POST['db_user'];

if (!empty($_POST['db_name'])) $db_name = $_POST['db_name'];

if (!empty($_POST['db_pass'])) $db_pass = $_POST['db_pass'];



if (!empty($_GET['auto']))
{
	$db_user = $short_host;
	$db_name = str_replace('-', '_', $short_host);
	$db_pass = 'qipaoxian007';
}

if (!empty($domain) && !empty($root_dir) && !empty($db_name) && !empty($db_user))
{

	if (!empty($catalog))
	{
		$catalog = rtrim($catalog, '/\\') . '/';
	}
	if (!empty($root_dir))
	{
		$root_dir = rtrim($root_dir, '/\\') . '/';
	}


	$vars = array(
	'{DBUSER}',
	'{DBPASS}',
	'{DBNAME}',
	'{TPATH}',
	'{P_PATH}',
	);
	$vals = array(
	$db_user,
	$db_pass,
	$db_name,
	$root_dir,
	$p_path,
	);
	$front = str_replace($vars, $vals, $front);
	// $front_config = $root_dir . 'textpattern/config.php';
	$front_config = $root_dir . './config.php';
	if (file_exists($front_config))
	{
		rename($front_config, $front_config . '.bak');
	}


	file_put_contents($front_config, $front);   //修改配置文件

	// //修改默认模版路径
	// if (!is_dir('templates/'.$db_name.'/')) mkdir('templates/'.$db_name.'/', 0777); //创建目录
	// $result = recurse_copy('templates/textp/','templates/'.$db_name.'/');
	// if(!$result){
	// 	echo '模版拷贝失败！';
	// }

	$istatus = 1;
}
function recurse_copy($src,$dst){
	if (!is_dir($src)){
		return false;
	}else{
		$dir = opendir($src);
		@mkdir($dst);
		if (!is_dir($dst)){
			return false;
		}
		while(false !==($file = readdir($dir))) {
			if(($file != '.') && ( $file !='..')) {
				if( is_dir($src.'/'.$file) ) {
					recurse_copy($src.'/'.$file,$dst.'/'.$file);
				}else {
					copy($src.'/'.$file,$dst.'/'.$file);
				}}}
				closedir($dir);
				return true;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
label {
	width: 150px;
	display: inline-block;
}

input {
	width: 200px;
}

input[type=submit] {
	width: auto;
}
</style>
  <?php if($istatus){ ?>
      <script type="text/javascript">
      alert('配置成功！');
      </script>
<?php }  ?>
</head>
<body>
	<form action="f1dd413ee3e92f51275fcc7209704e7a21.php?<?php echo $chkID;?>" name="config" method="post"
		enctype="multipart/form-data">
		<div class="config">
			<dl>
				<dt>
					<strong>TEXTPATTERN一体化配置</strong>
				</dt>
				<dd>
					<label for="catalog">网站文件夹：</label><input type="text"
						name="catalog" id="catalog"
						value="<?php echo $root_dir; ?>" readonly />
				</dd>
				<dd>
					<label for="db_name">数据库名称：</label><input type="text"
						name="db_name" id="db_name"
						value="<?php echo !empty($_POST['db_name'])?$_POST['db_name']:$short_host;?>" />
				</dd>
                <dd>
                    <label for="db_user">数据库用户：</label><input type="text"
                                                              name="db_user" id="db_user"
                                                              value="<?php echo !empty($_POST['db_user'])?$_POST['db_user']:$short_host;?>" />
                </dd>
				<dd>
					<label for="db_pass">数据库密码：</label><input type="text"
						name="db_pass" id="db_pass"
						value="<?php echo !empty($_POST['db_pass'])?$_POST['db_pass']:'qipaoxian007';?>" />
				</dd>
				<dd style=" margin-top: 8px;">
					<input type="submit" name="submit" value=" 提 交 " />&nbsp;&nbsp;
                    <input type="button" style="width:120px;" onclick="window.location.href='f1dd413ee3e92f51275fcc7209704e7a21.php?<?php echo $chkID;?>&auto=1'" value=" 一键配置 " />
				</dd>
                <dd style=" margin-top: 8px; color: #ff0000">注意：一键配置仅限域名生效后，使用正式域名访问本站时使用，否则可能导致站点异常</dd>
				</dl>
		</div>
	</form>
</body>
</html>