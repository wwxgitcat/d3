<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>


</style>
<?php $theme->display ( 'header' ); ?>
<!--begin content-->
	<div id="content">
	<!-- <h3><?php echo $_SERVER['SERVER_NAME'] ?></h3> -->

		<!--begin primary content-->
		<div id="primaryContent" class="span-15 append-2">
			<!--begin loop-->
			<?php foreach ( $posts as $post ) { ?>
				<div id="post-<?php echo $post->id; ?>" class="<?php echo $post->statusname; ?>">
						<h2 class="prepend-2"><a href="<?php echo $post->permalink; ?>" title="<?php echo $post->title; ?>"><?php echo $post->title_out; ?></a></h2>
					<!--display content-->
					<div class="entry">
					
						<?php echo filter_body(filter_host($post->content_out)); ?>
					</div>
					<!--display post meta-->
					<div class="entryMeta">
						<?php if ( count( $post->tags ) ) { ?>
						<div class="tags"><?php _e('Tagged:'); ?> <?php echo $post->tags_out; ?></div>
						<?php } ?>
					<br>
					<?php if ( $loggedin ) { ?>
					<?php } ?>
					</div>
				</div>
			<?php } ?>
			<!--end loop-->
			<!--pagination-->
			<div id="pagenav" class="clear">
				<?php echo $theme->prev_page_link('&laquo; ' . _t('Newer Posts')); ?> <?php echo $theme->page_selector( null, array( 'leftSide' => 2, 'rightSide' => 2 ) ); ?> <?php echo $theme->next_page_link('&raquo; ' . _t('Older Posts')); ?>
			</div>
			</div>


<?php 
	// include('./system/theme/mzingi/search.php');
 ?>





		<!--end primary content-->
		<?php $theme->display('sidebar'); ?>
	</div>
	<!--end content-->
	<?php $theme->display ( 'footer' ); ?>
