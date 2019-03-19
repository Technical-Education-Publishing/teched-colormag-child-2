<?php
/**
 * The Widget for EDD Fields
 *
 * @since 1.1.0
 *
 * @package Colormag_Child_2
 * @subpackage Colormag_Child_2/core/widgets
 */

defined( 'ABSPATH' ) || die();

add_action( 'widgets_init', function () {
	register_widget( 'TechEd_Featured_Post_Widget' );
} );

if ( ! class_exists( 'TechEd_Featured_Post_Widget' ) ) {

	class TechEd_Featured_Post_Widget extends WP_Widget {

		/**
		 * TechEd_Featured_Post_Widget constructor.
		 *
		 * @since 1.1.0
		 */
		function __construct() {

			parent::__construct(
				'teched_featured_post_widget', // Base ID
				__( 'Tech Ed Featured Post', 'colormag-child-2' ), // Name
				array(
					'classname' => 'teched-featured-post-widget',
					'description' => __( 'Shows the most recent Post within a Category. For use on the Home Page.', 'colormag-child-2' ),
				) // Args
			);

		}

		/**
		 * Front-end display of widget
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param        array $args Widget arguments
		 * @param        array $instance Saved values from database
		 *
		 * @access        public
		 * @since		  1.1.0
		 * @return        void
		 */
		public function widget( $args, $instance ) {

			$instance = wp_parse_args( $instance, array(
				'category_id' => 0,
			) );

			$category_id = $instance['category_id'];
			
			global $post;
			
			$widget_query = new WP_Query( array(
				'post_type' => 'post',
				'cat' => $category_id,
				'posts_per_page' => 1,
				'post_status' => 'publish',
			) );
			
			if ( $widget_query->have_posts() ) : 
			
				remove_filter( 'excerpt_length', 'colormag_excerpt_length' );
				remove_filter( 'excerpt_more', 'colormag_continue_reading' );
			
				remove_filter( 'the_excerpt', 'wpautop' );
			
				add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
			
				while ( $widget_query->have_posts() ) : $widget_query->the_post(); ?>

					<section class="widget widget_featured_posts widget_featured_meta.clearfix">
						<h3 class="widget-title" style="border-bottom-color:;"><span>
							<?php echo get_cat_name( $category_id ); ?>
						</span></h3>
						
						<div id="author-feature" class="first-post">
							<div class="single-article clearfix">
								<div class="article-content" style="margin-left: 3px; margin-right: 3px;">
									
									<div class="above-entry-meta">
										<span class="cat-links">
											
											<?php 
			
												$post_categories = wp_get_post_categories( get_the_ID() );
			
												foreach ( $post_categories as $index => $term_id ) : ?>
											
													<a href="<?php echo get_category_link( $term_id ); ?>"<?php echo ( $index == 0 ) ? ' style="background:#005151"' : ''; ?> rel="category tag" target="_self">
														<?php echo get_cat_name( $term_id ); ?>
													</a>
													&nbsp;
											
												<?php endforeach; ?>
											
										</span>
									</div>
									
            						<h3 class="entry-title">
										<a href="<?php the_permalink(); ?>" target="_self">
											<?php the_title(); ?>
										</a>
									</h3>
									
									<div class="below-entry-meta">
										
										<?php $post_timestamp = get_post_time( 'U' ); ?>
										
										<span class="posted-on">
											<a href="<?php the_permalink(); ?>" title="<?php echo date( 'g:i a', $post_timestamp ); ?>" rel="bookmark" target="_self">
												<i class="fa fa-calendar-o"></i> <time class="entry-date published" datetime="<?php echo date( 'Y-m-d', $post_timestamp ); ?>T<?php echo date( 'H:i', $post_timestamp ); ?>:00+00:00"><?php echo date( 'F j, Y', $post_timestamp ); ?></time>
											</a>
										</span>
										
										<span class="byline">
											<span class="author vcard">
												<i class="fa fa-user"></i><a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>" target="_self"><?php the_author(); ?></a>
											</span>
										</span>
										
										<span class="comments">
											<i class="fa fa-comment"></i><a href="<?php the_permalink(); ?>#respond" target="_self">
												<?php comments_number( 0, 1, '%s' ); ?>
											</a>
										</span>
										
									</div>
									
									<div class="entry-content">
										
										<figure>
											<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
												<img width="115" height="144" src= "<?php echo get_wp_user_avatar_src( get_the_author_meta( 'ID' ), 'medium' ); ?>" alt="<?php the_author(); ?>" style="float: right; margin-left: 15px; margin-right: 3px;" >
											</a>
											<!--end image code -->
											<figcaption style="text-align: left;">
												<?php the_excerpt(); ?>
											</figcaption>
										</figure>
										
									</div>
									
								</div>
								
							</div>
							
						</div>
						
					</section>
			
				<?php endwhile;
			
				wp_reset_postdata();
			
				remove_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
			
				add_filter( 'the_excerpt', 'wpautop' );
			
				add_filter( 'excerpt_length', 'colormag_excerpt_length' );
				add_filter( 'excerpt_more', 'colormag_continue_reading' );
			
			endif;

		}

		/**
		 * Back-end widget form
		 *
		 * @see WP_Widget::form()
		 *
		 * @param        array $instance Previously saved values from database
		 *
		 * @access        public
		 * @since		  1.1.0
		 * @return        void
		 */
		public function form( $instance ) {

			// Previously saved Values
			$saved_category_id   = ! empty( $instance['category_id'] ) ? $instance['category_id'] : 0;
			
			$categories = get_categories();
			
			$categories_array = wp_list_pluck( $categories, 'name', 'term_id' );

			?>

			<div class="colormag-child-2-widget-form">

				<p>

					<label for="<?php echo $this->get_field_id( 'category_id' ); ?>">
						<?php _e( 'Show the most recent Post from which Category:', 'colormag-child-2' ); ?>
					</label>

					<select id="<?php echo $this->get_field_id( 'category_id' ); ?>" class="widefat colormag-child-2-widget-category-id"
							name="<?php echo $this->get_field_name( 'category_id' ); ?>">

						<?php foreach ( $categories_array as $key => $value ) : ?>

							<option value="<?php echo $key; ?>"<?php echo ( $key == $saved_category_id ) ? ' selected' : ''; ?>>
								<?php echo $value; ?>
							</option>

						<?php endforeach; ?>

					</select>

				</p>

			</div>

			<?php

		}

		/**
		 * Sanitize widget form values as they are saved
		 *
		 * @see WP_Widget::update()
		 *
		 * @param        array $new_instance Values just sent to be saved
		 * @param        array $old_instance Previously saved values from database
		 *
		 * @access       public
		 * @since		 1.1.0
		 * @return       array Updated safe values to be saved
		 */
		public function update( $new_instance, $old_instance ) {

			$instance = array();
			$instance['category_id'] = ( ! empty( $new_instance['category_id'] ) ) ? strip_tags( $new_instance['category_id'] ) : '';

			return $instance;

		}
		
		/**
		 * Change the Excrept More text for our Widget
		 * 
		 * @param		string $more_string More String
		 *                                  
		 * @access		public
		 * @since		1.1.0
		 * @return		string More String
		 */
		public function excerpt_more( $more_string ) {
			
			return ' ... <a href="' . get_the_permalink() . '">' . __( 'READ MORE', 'colormag-child-2' ) . '</a>';
			
		}

	}
	
}