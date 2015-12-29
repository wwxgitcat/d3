<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
	<!--begin footer-->
	<div id="footer" class="clear">
	
	<p><?php _e(' powered by'); ?><?php echo "<a href='http://". $_SERVER['SERVER_NAME'].APP_PRO."'>".$_SERVER['SERVER_NAME']."</a>"; ?>
	<br/>
	<a href="./?sitemap=1">sitemap</a> 
	</p>

	<?php echo $theme->footer(); ?>
	</div>
	<!--end footer-->
</div>
<!--end wrapper-->
<?php 

	//$tokens = DB::get_results( 'SELECT id, name, description, token_group, token_type FROM {tokens} where id<10 ORDER BY  name'  );
	 // $tokens = DB::get_results( 'SELECT id, name, description, token_group, token_type FROM {hposts}   ORDER BY  name limit 1,5'  );
 ?>


</body>
</html>
