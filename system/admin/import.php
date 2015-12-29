<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
<?php include('header.php'); ?>
<?php 
	@ini_set('max_input_time', '1800');
	set_time_limit(0);
 ?>
 <style type="text/css">
 .import_button{
 	float: right;
 	border-radius: 10px; 
 	background: #D6E0E9;;
 	width: 80px;
 	height: 20px;
 	display:block;
 	text-align: center;
 }
 .csv_file{
 	color: red;
 }
 .success{
 	color: green;
 }
 </style>
<div class="container">
<script type="text/javascript">
</script>
<?php //echo $enctype; 
$file_root = $_SERVER['DOCUMENT_ROOT'].APP_PRO.APP_NAME;
?>
<h3>导入CSV</h3>
		<form enctype="multipart/form-data" method="get" action="<?php URL::out( 'admin', array( 'page' => 'import' ) ); ?>"> 
<table class="am-table  am-table-striped am-table-compact am-table-hover">
  <thead>
  <tr>
    <th>id</th>
    <th>文件名</th>
    <th class="am-text-right" style="margin-right:10px;">操作</th>
  </tr>
  </thead>
  <tbody>
  <?php 
  // echo $_SERVER['DOCUMENT_ROOT'].APP_PRO.APP_NAME;exit;
	 // $dir="./tempEP/";
	$file=scandir("./".APP_NAME);
	for($i=2;$i<count($file);$i++){
		// $file_geshi=end(explode(".", $file[$i]));
		
			echo "<tr>";
			echo "<td >".($i-1)."</td>";
			// echo '<td >'.APP_ROOT."/tempEP/".$file[$i]."</td>";
			echo '<td >'.$_SERVER['DOCUMENT_ROOT'].APP_PRO.APP_NAME.$file[$i]."</td>";
			// $test="http://localhost/BOLG/Habari/admin/import?filecsv=".APP_ROOT.APP_PRO.APP_NAME.$file[$i];
			$test="./import?filecsv=".$file[$i];
			// echo '<td class="am-text-right"><button><a href="'.$test.'">导入</a></button></td>';
			echo '<td class="am-text-right"><a href="'.$test.'" class="import_button">导入</a></td>';
			echo "</tr>";
		
		
	}
   ?>
  </tbody>
</table>
  <div class="am-text-left">
		<input class="am-text-left" type="submit" value="清空数据" name="clear_on"/>
	</div>
</form>
<?php

// echo  DB::insert( '{terms}', array( 'id' =>110, 'term' => "asdasd") );
// echo $slugcount = DB::query( 'insert into  {posts}') ;
// exit;
 // echo "最后一条id：".DB::get_row("select id from {posts} where id='51'" );
 // exit;
$test= $file_root.$_GET['filecsv'];
	if(!isset($_GET['filecsv'])){
		// 为空
	}
	else{
		echo "<hr/>";
		 echo "<b>当前正在导入：</b><span class='csv_file'>".$_GET['filecsv']."</span>";
		echo "<hr/>";
	    $star=time();
		$file = fopen($test,'r'); 

		$num=0;
		$num_id=0;

		$term_id_test=1;
		$num_test1=1;
		while ($data = fgetcsv($file)) { 
			 // DB::query('INSERT INTO {terms} (term) VALUES (?)', array("zhansgan") );
			 
			$goods_list[] = $data;
			 $goods_list[$num][0]=filter_urlstr($goods_list[$num][0]);
			 // $goods_list[$num][0]=$goods_list[$num][0];
			$time1=time();
			// echo ($num+1).":"."<span class='success'>".($goods_list[$num][0])."</span><br/>";

			$slug=$goods_list[$num][0]."-har-".($num+1).".html";
			$content_type=1;
			 $title=$goods_list[$num][0];

			 $guid="tag:localhost,2015:".$title."/". $time1;
		
			 $content=filter_gen($goods_list[$num][1]);
			 // $content=$content);
			 // var_dump($content);

			$cached_content=$goods_list[$num][1];
			$user_id=1;
			$pubdate=$time1;
			$status=2;
			$modified=$time1;

			//object_terms 标签 id
			$object_id=($num_id+1);
			$term_id=($num+1);
			$object_type_id=1;

			// terms标签
			$num_tag_id=0;
			$term=$goods_list[$num][3];
			
			$term_display=$goods_list[$num][3];
			$vocabulary_id=1;
			// $num_tag_id=$num_tag_id+1;

			$mptt_left=++$num_tag_id;
			$mptt_right=++$num_tag_id;
			// $num_tag_id=$num_tag_id+1;

			// 切割标签
			$arr=explode(",", $term);
			// if($num==4)
			// {
			// 		$arr=explode(",", $goods_list[$num][3]);
			// 	var_dump($arr);
			// exit;
			// }

			$fir_id= DB::query( 'INSERT INTO {posts} (slug,content_type,title,guid,content,cached_content,user_id,pubdate,status) VALUES (?,?,?,?,?,?,?,?,?)', array( $slug,$content_type,$title,$guid,$content,$cached_content,$user_id,$pubdate,$status) );
			
			 $haha=1;
			foreach ($arr as $key) {
				$key=filter_urlstr($key);
				$sec_id=DB::query('INSERT INTO {terms} (term,term_display,vocabulary_id,mptt_left,mptt_right) VALUES (?,?,?,?,?)',array(filter_urlstr($key),filter_urlstr($key),1,$term_id_test,$term_id_test+1));
				// echo $haha."-------------".$key."<br/>";
			 $num_id=DB::last_insert_id()."<br/>";
				$three_id=DB::query( 'INSERT INTO {object_terms} (object_id,term_id,object_type_id) VALUES (?,?,?)', array($num_test1 ,$num_id,$object_type_id) );
				$haha=$haha++;
				$term_id_test=$term_id_test+2;
			}
			$num_test1=$num_test1+1;
			// 插入数据
			 // DB::query( 'INSERT INTO {object_terms} (object_id,term_id,object_type_id) VALUES (?,?,?)', array($num+1 ,$num+1,$object_type_id) );
			 $num_id=DB::last_insert_id();
			// $num_id=DB::last_insert_id();

			// $vocabulary_id=DB::last_insert_id();
			// DB::query('INSERT INTO {terms} (term,term_display,vocabulary_id) VALUES ("zhansgasn","qqqq",1)');
			// $terms = DB::query( 'INSERT INTO {terms} (term,term_display,vocabulary_id,mptt_left,mptt_right) VALUES (?,?,?,?,?)', array( $term,$term_display,$vocabulary_id,$mptt_left,$mptt_right) );
			// DB::query('INSERT INTO {terms} (term) VALUES (?)', array("zhansgan") );
			// $terms = DB::query( 'INSERT INTO {terms} (term) VALUES (?)', array( $term) );
			//echo "返回结果：".DB::get_row("select count(*) from {posts}");
			// $result = DB::query( 'INSERT INTO {posts} (slug, content_type, title, guid,content,cached_content,user_id,pubdate,modified) VALUES (?, ?, ?, ? ?, ?, ?,?, ?)', array( $slug, $content_type, $title, $guid,$content,$cached_content,$user_id ,$pubdate,$modified) );
			//$result = DB::query( 'delete from {posts} where id>107' );
			// exit;
			$$vocabulary_id=$vocabulary_id++;


			if($fir_id!=1||$sec_id!=1||$three_id!=1){

			}
			else{
				echo ($num+1).":"."<span class='success'>".($goods_list[$num][0])."</span><br/>";
			}
			$num++;


			ob_flush();
			flush();
		 }
		  $end=time();
		 echo "耗时：".($end-$star+1)."秒";
		 fclose($file);
		 exit;
		
		 exit;
	// echo $ptable = DB::table("posts");exit;
		 //$result = DB::query( 'INSERT INTO {tokens} (name, description, token_group, token_type) VALUES (?, ?, ?, ?)', array( $name, $description, $group, $crud ) );
		// echo "插入结果：". $result = DB::query( 'INSERT INTO {posts} (title,slug) VALUES (? ,?)', array( "标题" ,"标题-1") );
		 	// $result = DB::query( 'INSERT INTO {tokens} (name, description, token_group, token_type) VALUES (?, ?, ?, ?)', array( $name, $description, $group, $crud ) );
	}
	if(isset($_GET['clear_on'])){
		DB::query( 'truncate table {posts}' );
		DB::query( 'truncate table {terms}' );
		DB::query( 'truncate table {log}' );
		DB::query( 'truncate table {object_terms}' );
		echo "<span style='color:orange'>清空完成！</span>";
	}
?>
</div>
<?php include('footer.php'); ?>
<script type="text/javascript" src="http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.min.js"></script>