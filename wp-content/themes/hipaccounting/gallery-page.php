<?php
/*
Template Name: Gallery
*/
?>
<?php get_header(); ?>
  <div id="galleryContent">
    <?php the_post(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <section id="gallery">
       	<div class="container">
          <div class="row">
            <div class="col-lg-12 text-center">
              <?php the_content(); ?>
            </div>

            <div class="gallery col-lg-12">

						  <div class="item">
							  <figure class="effect-bubba">
								  <img class="img-responsive" src="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'gallerypic01', true );?>" alt="">
								  <figcaption>
									  <h2>Sed <span>nulla</span></h2>
									  <p>Sed at convallis erat</p>
									  <a class="image-link" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'gallerypic01', true );?>">View more</a>
								  </figcaption>
							  </figure>
              </div>

              <div class="item">
                <figure class="effect-bubba">
								  <img class="img-responsive" src="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'gallerypic02', true );?>" alt="">
								  <figcaption>
									  <h2>dolor <span>nibh</span></h2>
									  <p>Sed at convallis erat</p>
									  <a class="image-link" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'gallerypic02', true );?>">View more</a>
								  </figcaption>
                </figure>
               </div>

                        <div class="item">
                            <figure class="effect-bubba">
								<img class="img-responsive" src="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'gallerypic03', true );?>" alt="">
								<figcaption>
									<h2>Fusce <span>vitae</span></h2>
									<p>Sed at convallis erat</p>
									<a class="image-link" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'gallerypic03', true );?>">View more</a>
								</figcaption>
                            </figure>
                        </div>

						  <div class="item">
                <figure class="effect-bubba">
								  <img class="img-responsive" src="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'gallerypic04', true );?>" alt="">
  								<figcaption>
  									<h2>Sed <span>nulla</span></h2>
  									<p>Sed at convallis erat</p>
  									<a class="image-link" href="<?php echo $key_1_value = get_post_meta( get_the_ID(), 'gallerypic04', true );?>">View more</a>
  								</figcaption>
                </figure>
              </div>

            </div> <!-- gallery -->

          </div> <!-- row -->

        </div> <!-- container -->
      </section>
      <div id="gallerybottom"><?php the_block( 'section2') ?></div>
    </div><!-- #post-<?php the_ID(); ?> -->

    <?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>

  </div><!-- #content -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
