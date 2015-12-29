<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
<?php $theme->display ( 'header' ); ?>
<!--begin content-->
	<div id="content">
		<!--begin primary content-->
		<div id="primaryContent" class="span-15 append-2">
			<!--begin single post navigation-->
			<div id="post-nav">



				<?php if ( $previous = $post->ascend() ): ?>

				<!-- <span class="left"> &laquo; <a href="<?php echo $previous->permalink ?>" title="<?php echo urldecode($previous->slug) ?>"><?php echo $previous->title ?></a></span> -->
				<?php endif; ?>
				<?php if ( $next = $post->descend() ): ?>
				<!-- <span class="right"><a href="<?php echo $next->permalink ?>" title="<?php echo urldecode($next->slug) ?>"><?php echo $next->title ?></a> &raquo;</span> -->
				<?php endif; ?>
				<!-- 上下页 -->
				<?php 
				$arr=$post->fields;

				// 上一页id，下一页id
				 $hposts_up=$arr['id']-1;
				 $hposts_down=$arr['id']+1;
				 $all="";
				 // 上一页名称，下一页名称
				 $up = DB::get_results('SELECT  title FROM `hposts` WHERE id ='.$hposts_up);
				$down = DB::get_results('SELECT  title FROM `hposts` WHERE id ='.$hposts_down);
				 $all = DB::get_row('SELECT  count(*) FROM `hposts`');

				//  exit;
				 foreach ($all->fields as $key => $value) {
				 	$all= $value;
				 }

				$href_up="";
				$href_down="";



				foreach ($up as $key => $value) {
					foreach ($value as $key => $value1) {
						 $href_up=$value1['title']."-har-".$hposts_up.".html";

						 $up=$value1['title'];
						 
					}
				}
				foreach ($down as $key => $value) {
					foreach ($value as $key => $value1) {
						 $href_down=$value1['title']."-har-".$hposts_down.".html";
						 
						 $down=$value1['title'];
					}
				}
				 $href_up="http://".APP_ROOT.APP_PRO."/".$href_up;
				 $href_down="http://".APP_ROOT.APP_PRO."/".$href_down;
				 ?>
				 <?php 
				 if($arr['id']==$all){
						// echo  'up: <a href="{$href_up}">{$up}</a>';
						echo "up: <a href='".$href_up."' > ".$up."</a>";
				 }
				  if($arr['id']==1){
						// echo  'next: <a href="{$href_down}">{$down}</a>';
							echo "next: <a href='".$href_down."'> ".$down."</a>";
				 }
				 else{
				 	echo "up: <a href='".$href_up."' > ".$up."</a>";
				 	echo "<br/>";
				 	echo "next: <a href='".$href_down."'> ".$down."</a>";
				 }
				  ?>

			</div>
			<!--begin loop-->
				<div id="post-<?php echo $post->id; ?>" class="<?php echo $post->statusname; ?>">
						<h2 class="prepend-2"><a href="<?php echo $post->permalink; ?>" title="<?php echo $post->title; ?>"><?php echo $post->title_out; ?></a></h2>
						<div class="entry">
						<?php echo filter_host($post->content_out); ?>
					</div>
					<div class="entryMeta">
						<?php if ( count( $post->tags ) ) { ?>
						<div class="tags"><?php _e('Tagged:'); ?> <?php echo $post->tags_out; ?></div>
						<?php } ?>
					</div><br>
						<?php if ( $loggedin ) { ?>
						<a href="<?php echo $post->editlink; ?>" title="<?php _e('Edit post'); ?>"><?php _e('Edit'); ?></a>
						<?php } ?>
				</div>

				<!-- 关联商品 -->
				<hr/>
				<h3>Similar</h3>
					 <?php 
						 $tokens = DB::get_results( 'select id,title from hposts order by rand() LIMIT 5'  );
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
			<!--end loop-->
			<?php //include 'commentform.php'; ?>
			</div>
		<!--end primary content-->
		<?php $theme->display ( 'sidebar' ); ?>
	</div>
	<!--end content-->
	<?php $theme->display ( 'footer' ); ?>
