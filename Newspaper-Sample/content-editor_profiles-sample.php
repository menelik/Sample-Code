<?php
/**
 * Post Content Template
 *
 * This template is the default page content template. It is used to display the content of the
 * `single.php` template file, contextually, as well as in archive lists or search results.
 *
 * @package WooFramework
 * @subpackage Template
 */

/**
 * Settings for this template file.
 *
 * This is where the specify the HTML tags for the title.
 * These options can be filtered via a child theme.
 *
 * @link http://codex.wordpress.org/Plugin_API#Filters
 */
 global $woo_options;
 
 $title_before = '<h1 class="title">';
 $title_after = '</h1>';
 
 //My Code Begins:
 $editor_term = wp_get_object_terms( $post->ID, 'editor_names');
 $editor_name = $editor_term[0]->name;
 //My Code Ends
 
 if ( ! is_single() ) {
 
 	$title_before = '<h2 class="title">';
 	$title_after = '</h2>';
 
	$title_before = $title_before . '<a href="' . get_permalink( get_the_ID() ) . '" rel="bookmark" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
	$title_after = '</a>' . $title_after;
 
 }
 
 $page_link_args = apply_filters( 'woothemes_pagelinks_args', array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) );
 
 woo_post_before();
?>
<div <?php post_class(); ?>>
<?php
	woo_post_inside_before();
	
	//My Code Begins:
	
	//Check if Editorial has been assigned an editor. Only posts with Editors will be displayed.
	if ($editor_term[0]) :
	echo $title_before . $editor_name . $title_after;
	else :	
	the_title( $title_before, $title_after );
	endif ;
	if ( !is_singular() ) { ?>
		
		<?php woo_image( 'width='.$woo_options['woo_thumb_w'].'&height='.$woo_options['woo_thumb_h'].'&class=thumbnail '.$woo_options['woo_thumb_align'] ); ?>
		<div class="post-more">
			<?php echo do_shortcode('[post_categories]'); ?>
		</div>
<?php } ?>
	    <?php if ( is_single() ) { ?>
	    	<?php woo_post_meta(); ?>
	    	<?php the_post_thumbnail( 'single-post-thumbnail' ); ?>
	    	
	   <!-- My Code Ends: -->
	   
	    	<div class="post-more">
		    	<ul class="social_share">
		    		<li>شارك:</li>
					<li><?php echo do_shortcode('[twitter style="horizontal" related="albiladdaily" source="albiladdaily" float="none"]'); ?></li>
					<li><?php echo do_shortcode('[fbshare type="button_count" float="none"]'); ?></li>
					<li><?php echo do_shortcode('[google_plusone size="medium" count="true" float="none"]'); ?></li>
		    	</ul>
		    	<div class="clear"></div>
		    </div>

	    <?php }?>   
	    
	<div class="entry">
	    <?php
	    	if ( $woo_options['woo_post_content'] == 'content' || is_single() ) {
	    	the_content(__('Continue Reading &rarr;', 'woothemes') ); 
	    		    	
			//My Code Begins:
			
			//Check if Editorial has been assigned an editor. Only posts with Editors will be displayed.
	    	if ($editor_term[0]) :
	    	
	    		echo '<h2>
	    		مقالات الكاتب 
	    		' . $editor_name . '</h2>';
	    	  				
	    		//Query to retrieve the Editorials assigned to the editor's name
	    		$editorial_query = new WP_Query( array( 'editor_names' => $editor_term[0]->slug, 'post_type' => 'editorials') );
	    		  				
	    		 //editorial loop
	    		 while ( $editorial_query->have_posts() ) : $editorial_query->the_post();
	    		  
	    			//Display the title
	    			echo '
	    				    			
	    				<h3><a href="'. get_permalink() . '">' . get_the_title() . '</a></h3>
	    				
	    				';
	
				//end the Editor's Profile loop
	    		endwhile;	
	    		// Reset Post Data
	    		wp_reset_postdata();
	    	endif;
	    	
	    	//My Code Ends
	    			
	    	}
	    	if ( $woo_options['woo_post_content'] == 'content' || is_singular() ) wp_link_pages( $page_link_args );
	    ?>
	    
	</div><!-- /.entry -->
	<div class="fix"></div>
<?php
	woo_post_inside_after();
	
?>
</div><!-- /.post -->
<?php
	woo_post_after();

	$comm = $woo_options[ 'woo_comments' ];
	if ( ( $comm == 'post' || $comm == 'both' ) && is_single() ) { comments_template(); }
?>
