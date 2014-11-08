<?php
  /*
Template Name: Feature1
*/
  get_header();
?>

  <div id="container">
    <div id="content">
      <?php the_post(); ?>

      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="pHeader"> <?php echo $key_1_value = get_post_meta( get_the_ID(), 'pageHeader', true );?></div>
        <div class="pSlogan"> <?php echo $key_1_value = get_post_meta( get_the_ID(), 'pageSlogan', true );?></div>
        <div class="entry-content">
          <div id="indexwrapper">
            <div id="section1wrap" class="headwrap">
              <?php the_block( 'section1') ?>
            </div>
            <div id="section2wrap" class="headwrap">
              <?php the_block( 'section2') ?>
            </div>
            <div id="section3wrap" class="headwrap">
              <?php the_block( 'section3') ?>
            </div>
          </div>
          <div class="clear"></div>
          <?php the_content(); ?>
          <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
          <?php edit_post_link( __( 'Edit', 'your-theme' ), '<span class="edit-link">', '</span>' ) ?>
        </div><!-- .entry-content -->
      </div><!-- #post-<?php the_ID(); ?> -->

      <?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>

    </div><!-- #content -->
		<?php get_sidebar(); ?>
  </div><!-- #container -->

<?php get_footer(); ?>
