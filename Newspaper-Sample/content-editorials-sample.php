<?php
/**
 * Editorial Content Template
 *
 * This template is the default page content template. It is used to display the content of the
 * `single-editorials.php` template file, as well as in archive lists or search results.
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
 
//Editor's name retrieved from its assigned editorial
$editorial_author_term = wp_get_object_terms( $post->ID, 'editor_names');
$editorial_author_name = $editorial_author_term[0]->name;

//Check if Editorial has been assigned an editor. Only posts with Editors will be displayed.
if ($editorial_author_term[0]) :
	
	//Query to retrieve the Editor's Profile info that is associated with the Editor's name
	$editorial_author_query = new WP_Query( array( 'editor_names' => $editorial_author_term[0]->slug, 'post_type' => 'editor_profiles', 'posts_per_page' =>1 ) );
 	//The Editor's Profile loop
	while ( $editorial_author_query->have_posts() ) : $editorial_author_query->the_post();
		
		//collect the thumbnail
		$editor_thumbnail_id = get_post_thumbnail_id();
		$editor_thumbnail_link = wp_get_attachment_url($editor_thumbnail_id);
		$editor_photo_link = '<a href="'. get_permalink() . '"><img src="'. $editor_thumbnail_link . '"></a>';
		//collect the name
		$editor_name  = '<a href="'. get_permalink() . '">' . $editorial_author_name . '</a>';
 	
 	//end the Editor's Profile loop
 	endwhile;	
 		// Reset Post Data
 		wp_reset_postdata();
 	endif;
 
 //My Code Ends
 
 if ( !is_single() ) :
 
 	$title_before = '<h2 class="title">';
 	$title_after = '</h2>';
 
	$title_before = $title_before . '<a href="' . get_permalink( get_the_ID() ) . '" rel="bookmark" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
	$title_after = '</a>' . $title_after;
 
 endif;
  
 $page_link_args = apply_filters( 'woothemes_pagelinks_args', array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) );
 
 woo_post_before();
?>

<div <?php post_class(); ?>>

	<?php
	woo_post_inside_before();	
	if ( !is_singular() ) :
	
	//My Code Begins:
	
	if ($editor_photo_link) :
	
		echo $editor_photo_link;
	
	endif;
	
	?>
		<div class="clear"></div>
		<div class="editorial_main">
  			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  			<span class="editorial_author_name"><?php echo $editor_name; ?></span>

<!--My Code Ends -->

			<div class="post-more">
				<?php echo do_shortcode('[post_tags]'); ?>
				<?php echo do_shortcode('[post_comments]'); ?>
					<div class="clr"></div>
			</div> 
		</div>	  
		
	
	<?php
	//end !is_singular()
	endif;
 	?>

	<?php
	
	//My Code Begins:
	
	if ( is_single() ) :
 
 		if ($editor_photo_link) :
 		
 			echo $editor_photo_link;
			
		endif;
?>					

		<div class="clear"></div>

		<div class="editorial_main">
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<span class="editorial_author_name"><?php echo $editor_name; ?></span>
		</div>	  

<!-- My Code Ends -->

		<div class="post-more">
			<ul class="social_share">
				<li>شارك:</li>
				<li><?php echo do_shortcode('[twitter style="horizontal" related="albiladdaily" source="albiladdaily" float="none"]'); ?></li>
				<li><?php echo do_shortcode('[fbshare type="button_count" float="none"]'); ?></li>
				<li><?php echo do_shortcode('[google_plusone size="medium" count="true" float="none"]'); ?></li>
				<li class="post-reply"><a href="#respond">أضف تعليق</a></li>
			</ul>
					
			<?php echo do_shortcode('[post_comments]'); ?>

			<div class="clear"></div>
		
		</div>
					
		<?php echo albilad_reaction_buttons_html();?>
		    
	 <?php
	 //end if is_single()
	 endif;
	 ?>
	   
	<div class="entry">
	    <?php
	    	if ( $woo_options['woo_post_content'] == 'content' || is_single() ) { the_content(__('Continue Reading &rarr;', 'woothemes') ); }
	    	if ( $woo_options['woo_post_content'] == 'content' || is_singular() ) wp_link_pages( $page_link_args );
	    ?>

	</div><!-- /.entry -->
	
	<div class="fix"></div>

</div><!-- /.post -->

<?php
	woo_post_after();
	$comm = $woo_options[ 'woo_comments' ];
	if ( ( $comm == 'post' || $comm == 'both' ) && is_single() ) :
		comments_template();
	endif;
?>
