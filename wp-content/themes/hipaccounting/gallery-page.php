<?php
/*
Template Name: Gallery
*/
?>
<?php get_header(); ?>
    <div id="content">
      <?php the_post(); ?>

      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="pHeader"> <h2><?php echo $key_1_value = get_post_meta( get_the_ID(), 'pageHeader', true );?></h2></div>
        <div class="pSlogan"> <h3><?php echo $key_1_value = get_post_meta( get_the_ID(), 'pageSlogan', true );?></h3></div>
        <div class="entry-content">
          <div class="indexwrapper">
            <div id="section1wrap" class="headwrap">
              <?php the_block( 'section1') ?>
              <div class="buttonwrap">
                <a class="button button-border-dark" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'link1', true );?>">read more</a>
              </div>
            </div>
            <div id="section2wrap" class="headwrap">
              <?php the_block( 'section2') ?>
              <div class="buttonwrap">
                <a class="button button-border-dark" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'link2', true );?>">read more</a>
              </div>
            </div>
            <div id="section3wrap" class="headwrap">
              <?php the_block( 'section3') ?>
              <div class="buttonwrap">
                <a class="button button-border-dark" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'link3', true );?>">read more</a>
              </div>
            </div>
          </div>
          <div class="clear"></div>
          <div class="indexcontent">
            <?php the_content(); ?>
            <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
            <?php edit_post_link( __( 'Edit', 'your-theme' ), '<span class="edit-link">', '</span>' ) ?>
          </div>
        </div><!-- .entry-content -->
      </div><!-- #post-<?php the_ID(); ?> -->

      <?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>

    </div><!-- #content -->
		<?php get_sidebar(); ?>

<?php get_footer(); ?>
