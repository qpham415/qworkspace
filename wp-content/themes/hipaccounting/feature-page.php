<?php
/*
Template Name: Features
*/
  get_header();
?>
    <div id="content">
      <?php the_post(); ?>

      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="featContainer">
          <div class="featWrap">
            <div class="featHeader">
              <?php the_content(); ?>
            </div>
            <div class="featRow">
              <div class="feature1 featuresAll">
                <?php the_block('feat1') ?>
              </div>
              <div class="feature2 featuresAll">
                <?php the_block('feat2') ?>
              </div>
            </div>
            <div class="featRow">
              <div class="feature3 featuresAll">
                <?php the_block('feat3') ?>
              </div>
              <div class="feature4 featuresAll">
                <?php the_block('feat4') ?>
              </div>
            </div>
          </div>  
        </div>
      </div><!-- #post-<?php the_ID(); ?> -->

      <?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>

    </div><!-- #content -->
		<?php get_sidebar(); ?>

<?php get_footer(); ?>
