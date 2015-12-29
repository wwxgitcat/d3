<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
<?php Plugins::act( 'theme_sidebar_top' ); ?>
	<!--begin secondary content-->
	<div id="secondaryContent" class="span-7 last">
	<h2 id="site"><?php _e('User_login'); ?></h2>
	<ul id="nav">
		<!-- <li><a href="<?php Site::out_url( 'habari' ); ?>"><?php _e('Home'); ?></a></li> -->
		<li><a href="./auth/login"><?php _e('Login'); ?></a></li>

		<?php
		// List Pages
		foreach ( $pages as $page ) {
			echo '<li><a href="' . $page->permalink . '" title="' . $page->title . '">' . $page->title . '</a></li>' . "\n";
		}
		?>
	</ul>

	<h2 id="aside"><?php _e('Tag'); ?></h2>
	<ul id="asides">
		<?php
	          foreach($asides as $post):
              echo '<li><span class="date">';
	      // @locale Date formats according to http://php.net/manual/en/function.date.php
              echo $post->pubdate->out( _t( 'F j, Y' ) ) . ' - ' . '</span>';
              echo '<a href="' . $post->permalink .'">' . $post->title_out . '</a>'. filter_host($post->content_out);
              echo '</li>';

 		?>
	<?php endforeach; ?>
   </ul>
	<?php echo $theme->area( 'sidebar' ); ?>
	<?php
	 	//  $tokens = DB::get_results( 'SELECT  term FROM {terms} '  );
		 // foreach ($tokens as $key => $value) {
			//  	# code...
			//  	$arr=$value->fields;
			//  	// var_dump($arr);
			//  	// exit;
			//  	foreach ($arr as $key  ) {
			//  		 echo "<li class='nav_title_tag'>";
			//  		echo "<a href='./tag/{$key}'>".$key."</a><br/>";
			//  		// echo $key."<br/>";
			//  		echo "</li>";
			//  	}
			//  }

			  $tokens = DB::get_results( 'SELECT distinct term FROM {terms} '  );
	 foreach ($tokens as $key => $value) {
	 	$arr=$value->fields;
	 		 echo "<li class='nav_title_tag'>";
	 		 // $href_demo=$arr['title']."-har-".$arr['id'].".html";
	 		 $href_demo="/tag/".$arr['term'];
	 		 //var_dump($post);
	 		 //exit;
	 		echo "<a href='http://".APP_ROOT.APP_PRO."/tag/".$arr['term']."' class='nav_a'>".$arr['term']."</a>";
	 		echo "</li>";



	 }
	 ?>
		<hr/>
		<br/>
	 <ul>
	 	 <h3>Rencent</h3>
	 <?php 

		 $tokens = DB::get_results( 'select id,title from hposts order by rand() LIMIT 10'  );
	    foreach ($tokens as $key => $value) {
 	 	$arr=$value->fields;
  		 echo "<li class=''>";
  		 $href_demo="/".$arr['title'];
  		echo "<a href='http://".APP_ROOT.APP_PRO."/".$arr['title']."-har-".$arr['id'].".html' class='nav_a'>".$arr['title']."</a>";
  		echo "</li>";

  // 		$tokens = DB::get_results( 'select term from hterms order by rand() LIMIT 3'  );
		// foreach ($tokens as $key => $value) {
		// 			$arr=$value->fields;
		// 		 $aa.=  $arr['term']."|";
		}
	  ?>
	  </ul>
	</div>
	<!--end secondary content-->
<?php Plugins::act( 'theme_sidebar_bottom' ); ?>
