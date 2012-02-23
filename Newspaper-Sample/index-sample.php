<?php
/**
 * Index Template
 *
 * The index template is a placeholder for all cases that don't have a template file. 
 * Ideally, all fases would be handled by a more appropriate template according to the
 * current page context (for example, `tag.php` for a `post_tag` archive or `single.php`
 * for a single blog post).
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options;
 get_header();
?> 

<!-- #content Starts -->

<?php woo_content_before(); ?>

<div id="content" class="col-full">

<!--My Code Begins: -->

	<div class="hot_story">
<?php
		//STEP 1: Setup the Hot Topic Loop to display as a Big Story
		
		//check if page you're on the homepage
			if ( is_home() ) :
		
				//zeroes out do_not_duplicate variable which is also used to check if main loop has run
				$do_not_duplicate = 0;
				// get list of Hot Topic terms
				$hot_terms = get_terms('hot_topics', 'orderby=none&hide_empty');
				// reset the counter for the hot_choices array, which will be used to collect the id's of the latest "Hot Topic post" from each catagory
				$hot_counter = 0;
				// declare the hot_choices array, which will hold the latest post from each "Hot Topic Catagory"
				$hot_choices = array();
				//declare the big_displayed and array, which will hold the Hot Topics that are displayed as Big Stories, to prevent duplication in the main loop
				$big_displayed = array();
				// loop through each Hot Topic terms
				foreach ($hot_terms as $hot_term) :

 					// The query for each Hot Topic term
					 $hot_query = new WP_Query( array( 'hot_topics' => $hot_term->slug, 'meta_value'=>'bigstory', 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => 1) );
				  				 				
	 				// The Loop to get the latest post from each Hot Topic term and store its ID into hot_choices variable
 					while ( $hot_query->have_posts() ) : $hot_query->the_post();
		 					
		 					$hot_choices[$hot_counter] = $post->ID;

 							$hot_counter++;
 						
 					endwhile;
 				
 					// Reset Post Data
					 wp_reset_postdata();

				 endforeach;
			 
				 if (!empty($hot_choices)) :
				 //	Query the hot_choices array for the latest Hot Topic across all Hot Topic terms
				 $the_hot_query = new WP_Query( array( 'post__in' => $hot_choices, 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' =>1 ) );
			 
				 // STEP 2: Display the latest Hot Topic
				 while ( $the_hot_query->have_posts() ) : $the_hot_query->the_post();
		 
				 		//Setting the do_not_duplicate variable with the post ID, so that it doesn't appear later in the "related Hot Topics" loop
				 		$do_not_duplicate = $post->ID;
				 		$big_displayed[0] = $do_not_duplicate;
				 					 	
				 		//Collecting the Hot Topic terms that are associated with the post
				 		$hot_query_terms = wp_get_object_terms( $post->ID, 'hot_topics');
				 		
				 		$big_story_title = get_post_meta($post->ID, "big-story-title", true);
				 		
				 		$big_story_body = get_post_meta($post->ID, "big-story-body", true);
			 	
				 		if (empty($big_story_title)) :
				 		
				 		echo '<h2><a href="' . get_permalink( $post->ID ) . '" rel="bookmark" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">' . get_the_title() . '</a></h2>';				 	
 		   				
 		   				else :
 		   				
 		   				echo '<h2><a href="' . get_permalink( $post->ID ) . '" rel="bookmark" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">'.$big_story_title.'</a></h2>';
 		   				
 		   				endif;
 		   				
	 		   			echo '<div class="hot_more">';	
						echo do_shortcode('[post_comments]');
						echo do_shortcode('[post_categories]');
											
						echo '<div class="hot_topics_list">
									<div class="hot_topic_right"></div>';
						echo do_shortcode('[post_terms]') .'
									<div class="hot_topic_left"></div>
									<div class="clr"></div>
									<div class="clr"></div>
								</div>';
						
						echo '<div class="big_story_list"><div class="big_story_right"></div>';
						echo '<div class="big_story_left"></div><div class="clr"></div></div><div class="clr"></div></div>';

						
						if(empty($big_story_body)) :
						echo '<a class="hot_thumb" href="' . get_permalink( $post->ID ) . '" rel="bookmark" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">'; the_post_thumbnail( 'homepage-thumb' ); echo '</a><br class="clr" />';
						
						else :
						echo '<p class="hot_thumb">'.$big_story_body.'</p>';
						endif;
				
				
				// END LOOP FOR DISPLAYING THE LATEST HOT TOPIC AS A BIG STORY
				endwhile;
				endif;
				
				$big_story_subtitle = get_post_meta($post->ID, "big-story-subtitle", true);
				
				if (empty($big_story_subtitle)) :
				
				// Reset Post Data
				wp_reset_postdata();
				 
				 //STEP 3: Prepare loop for the related Hot Topics
				 //If Hot Topics loop has been run, and do_not_duplicate has been assigned the Hot Topic's post ID
				 if ($do_not_duplicate != 0) :
			 
				 	//Loop through the Hot Topic's terms. Although it should only be assigned a single Hot Topic term, this is to make sure that mistakingly giving it more than one term won't bork the site.
				 	foreach ($hot_query_terms as $hot_query_term) :
			 
				  		// Query each Related Hot Topic term until 3 posts of each are shown
				 		$hot_sub_query = new WP_Query( array( 'hot_topics' => $hot_query_term->slug, 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => 3) );
			 				  				 				
				  		// STEP 4: Displaying the related Hot Topics: Loop to get the latest three posts from each Hot Topic term
				  		while ( $hot_sub_query->have_posts() ) : $hot_sub_query->the_post();

							//if the ID of the related post does NOT equal to the main Hot Topic
							if (get_the_ID() != $do_not_duplicate)
							{ 
								echo '<div class="hot_related"><a href="' . get_permalink( $post->ID ) . '" rel="bookmark" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">'.get_the_title(get_the_ID()).'</a></div>';
								$big_displayed[] = $post->ID;
							}
						endwhile;
					
	 					// Reset Post Data				
						wp_reset_postdata();
							  
 				  //END LOOP FOR RELATED HOT TOPICs
 				  endforeach;
 				  
 			 
 				 //END "DO NOT DUPLICATE" CHECK 
				endif; 
				
				else :
				
				echo '<h3>'.$big_story_subtitle.'</h3>';
				
				endif;		
				
				// Reset Post Data				
				wp_reset_postdata();
				
			//END HOT TOPICS
			endif;
		unset($hot_choices);
		$hot_choices = array();	
	?>
	
	<!--My Code Ends -->	
	    <br />
	    </div>
    	<div id="main-sidebar-container">    
			
            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <div id="main" class="col-left">
            	
			<?php get_template_part( 'loop', 'index' ); ?>
                    
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar(); ?>
    
		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>       

    </div><!-- /#content -->
	<?php woo_content_after(); ?>
		
<?php get_footer(); ?>