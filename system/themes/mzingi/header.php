<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html lang="<?php echo $locale; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>">
	<title>
		<?php 
		$title="";
		$tokens = DB::get_results( 'SELECT id,title FROM {posts} order by  id desc limit 1'  );
		foreach ($tokens as $key => $value) {
				$arr=$value->fields;
				 echo $arr['title'];
				 $title= $arr['title'];
		}
		 ?>
	</title>
	<?php 
		$aa="";
		$tokens = DB::get_results( 'select term from hterms order by rand() LIMIT 3'  );
		foreach ($tokens as $key => $value) {
					$arr=$value->fields;
				 $aa.=  $arr['term']."|";
		}
		 $aa;
		 ?>
	<meta name="description" content="<?php echo $aa ?>" />
	<meta name="keywords" content="<?php echo $title. $aa ?>" />
	<meta name="generator" content="Habari">
	<link rel="stylesheet" type="text/css"  media="print" href="<?php Site::out_url( 'vendor'); ?>/blueprint/print.css">
	<link rel="stylesheet" type="text/css" media ="screen" href="<?php Site::out_url( 'vendor'); ?>/blueprint/screen.css">
	<link rel="stylesheet" type="text/css" media="screen" href="<?php Site::out_url( 'theme' ); ?>/style.css">
	<link rel="Shortcut Icon" href="<?php Site::out_url( 'theme' ); ?>/favicon.ico">
	<style type="text/css">
	.nav_a{
		color: black;
	}
	a{
		text-decoration: none;
	}
		.nav_title,.nav_title_tag{
			padding: 5px;
			border-radius: 10px;
			background: #267FC3;
			width: auto;
			height: auto;
			float: left; margin-right: 5px;
			font-size: 12px;
			color: black;
			margin-top: 5px;
			list-style: none;
			text-decoration: none;
		}
		.nav_title_tag{
			background: orange;
		}
	</style>
	<?php echo $theme->header(); ?>
</head>
<body class="<?php echo $theme->body_class(); ?>">
	<!--begin wrapper-->
	<div id="wrapper" class="container prepend-1 append-1">
		<!--begin masthead-->
		<div id="masthead"  class="span-15 pull-1">
			<div id="branding">
			<?php 
			echo "<h2><a href='http://". $_SERVER['SERVER_NAME'].APP_PRO."'>".$_SERVER['SERVER_NAME']."</a></h2>";
			 ?>
			<!-- <h1><?php echo $_SERVER['SERVER_NAME']; ?></h1> -->
			<?php 
			if($_GET['sitemap']==1){
				 $tokens = DB::get_results( 'SELECT title FROM {posts} '  );
					 foreach ($tokens as $key => $value) {
					 	$arr=$value->fields;
					 	foreach ($arr as $key  ) {
					 		 echo "<li class=''>";

					 		echo "<a href='./{$key}-har-'>".$key."</a><br/>";
					 		echo "</li>";
					 	}
					 }
				exit;
			}
			 ?>

				 <!-- 搜索框 -->
			 <?php Plugins::act( 'theme_searchform_before' ); ?>
			      <form method="get" id="searchform" action="<?php URL::out('display_search'); ?>">
			       <p><input type="text" id="s" name="criteria" value="<?php if ( isset( $criteria ) ) { echo htmlentities($criteria, ENT_COMPAT, 'UTF-8'); } else { _e('Search'); } ?>"><br> <input type="submit" id="searchsubmit" value="<?php _e('Go!'); ?>"></p>
			      </form>
			 <?php Plugins::act( 'theme_searchform_after' ); ?>
<?php 


	 $tokens = DB::get_results( 'SELECT id,title FROM {posts} order by  id desc limit 1,5'  );
	 foreach ($tokens as $key => $value) {
	 	$arr=$value->fields;
	 		 echo "<li class='nav_title'>";
	 		 $href_demo="http://".APP_ROOT.APP_PRO."/".$arr['title']."-har-".$arr['id'].".html";
	 		 // echo "<a href='http://".APP_ROOT.APP_PRO."/".$arr['title']."' class='nav_a'>".$arr['term']."</a>";

	 		// echo "<a href='{$href_demo}' class='nav_a'>".$arr['title']."</a>";
	 		 // echo "<a href='http://".APP_ROOT.APP_PRO."/".$arr['title']."-har-".$arr['id'].".html"' '.">".$arr['title']."</a>";
	 		echo "<a href='http://".APP_ROOT.APP_PRO."/".$arr['title']."-har-".$arr['id'].".html' class='nav_a'>".$arr['title']."</a>";
	 		echo "</li>";
	 }
 ?>

 </ul>
<hr/>
<?php 

$url=explode("/", $_SERVER['REDIRECT_URL']);
$url2=end($url);
// exit;
 ?>

<!-- 面包屑 -->
<h3>
<?php 
// 如果是标签,则显示标签标题
if(strpos($_SERVER['REDIRECT_URL'],"tag"))
{
	$url3=str_replace(".html", "", $url2);
	echo $_SERVER['SERVER_NAME'].">" ."<a href='{$url2}'>".$url3."</a>";
}
// 不是标签，是标题，则显示含有的所有标签
else{
	$url3=str_replace(".html", "", $url2);
	echo $_SERVER['SERVER_NAME'].">" ."<a href='{$url2}'>".$url3."</a>";
}

?>

	
</h3>
			</div>
		</div>
	<!--end masthead-->


