<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
<?php $theme->display ( 'header' ); ?>
<!--begin content-->
	<div id="content">
		<!--begin primary content-->
		<div id="primaryContent" class="span-15 append-2">
			<!--begin loop-->
			<?php foreach ( $posts as $post ) { ?>
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
					<?php } ?>
				</div>
			<?php } ?>
			<!--end loop-->
			<div id="pagenav">
				<?php echo $theme->prev_page_link('&laquo; ' . _t('Newer Posts')); ?> <?php echo $theme->page_selector( null, array( 'leftSide' => 2, 'rightSide' => 2 ) ); ?> <?php echo $theme->next_page_link('&raquo; ' . _t('Older Posts')); ?>
			</div>
			</div>

		<!--end primary content-->
		<?php $theme->display ( 'sidebar' ); ?>
	</div>
	<!--end content-->
	<?php $theme->display ( 'footer' ); ?>
