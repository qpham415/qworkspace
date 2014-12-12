<?php
/*
Template Name: Pricing
*/
  get_header();
?>

<div id="pricingContent">
  <?php the_post(); ?>

  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="pricingHeader">
      <?php the_content(); ?>
    </div>
    <div class="clear"></div>
    <div class="pricingContent">
      <div class="pricingBoxWrap">
        <div class="pricingBox">
          <?php the_block('pricing1') ?>
          <div class="buttonwrap">
            <a class="button button-dark" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'pricelink1', true );?>">sign up now</a>
          </div>
        </div>
        <div class="pricingBox">
          <?php the_block('pricing2') ?>
          <div class="buttonwrap">
            <a class="button button-dark" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'pricelink2', true );?>">sign up now</a>
          </div>
        </div>
        <div class="pricingBox">
          <?php the_block('pricing3') ?>
          <div class="buttonwrap">
            <a class="button button-dark" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'pricelink3', true );?>">sign up now</a>
          </div>
        </div>
        <div class="pricingBox">
          <?php the_block('pricing4') ?>
          <div class="buttonwrap">
            <a class="button button-dark" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'pricelink4', true );?>">sign up now</a>
          </div>
        </div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="pricingBottom">
      <?php the_block('Pricing Bottom') ?>
      <div class="buttonwrap">
        <a class="button button-border-dark" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'pricingBottomLink', true );?>">sign up for free</a>
      </div>
    </div>
    <div class="admininfo">
      <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
      <?php edit_post_link( __( 'Edit', 'your-theme' ), '<span class="edit-link">', '</span>' ) ?>
    </div>
  </div><!-- #post-<?php the_ID(); ?> -->

  <?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>

</div><!-- #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
