<?php
/**
 * Shows during the Archive loop
 *
 * @package Colormag_Child_2
 * @since {{VERSION}}
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'row' ) ); ?>>
   <?php do_action( 'colormag_before_post_content' ); ?>

   <?php if ( has_post_thumbnail() ) : ?>
      <div class="small-12 medium-4 columns">
         <div class="featured-image">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'colormag-featured-image' ); ?></a>
         </div>
      </div>
   <?php endif; ?>

   <div class="article-content clearfix small-12 columns<?php echo ( has_post_thumbnail() ) ? ' medium-8' : ''; ?>">

      <header class="entry-header">
         <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
         </h2>
      </header>

      <div class="entry-content clearfix">
      
         <?php get_template_part( 'template-parts/teched-directory', 'meta' ); ?>

      </div>

   </div>

   <?php do_action( 'colormag_after_post_content' ); ?>
</article>