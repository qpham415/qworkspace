<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
    <title><?php
        if ( is_single() ) { single_post_title(); }
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); get_page_number(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); get_page_number(); }
    ?></title>

    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />

    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

    <?php wp_head(); ?>

    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'hbd-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'hbd-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


        <meta charset="utf-8">
        <meta name="description" content="HIP Accounting">
        <meta name="author" content="aresthemes">

        <!-- viewport settings -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- CSS -->
        <link rel="stylesheet" href="/wp-content/themes/hipaccounting/css/bootstrap.css">
        <link rel="stylesheet" href="/wp-content/themes/hipaccounting/css/font-awesome.min.css">
        <link rel="stylesheet" href="/wp-content/themes/hipaccounting/css/headhesive.css">
        <link rel="stylesheet" href="/wp-content/themes/hipaccounting/css/revolution.css">
        <link rel="stylesheet" href="/wp-content/themes/hipaccounting/css/jquery.countdown.css">
        <link rel="stylesheet" href="/wp-content/themes/hipaccounting/css/magnific-popup.css">
        <link rel="stylesheet" href="/wp-content/themes/hipaccounting/css/owl.carousel.css">
        <link rel="stylesheet" href="/wp-content/themes/hipaccounting/css/owl.theme.css">
        <link rel="stylesheet" href="/wp-content/themes/hipaccounting/css/main.css">

        <!-- modernizr -->
            <script src="/wp-content/themes/hipaccounting/js/modernizr.custom.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/jquery-1.11.0.min.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/bootstrap.min.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/headhesive.min.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/jquery.themepunch.plugins.min.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/jquery.themepunch.revolution.min.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/owl.carousel.min.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/jquery.magnific-popup.min.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/jquery.stellar.min.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/smooth-scroll.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/retina-1.1.0.min.js"></script>
            <script src="/wp-content/themes/hipaccounting/js/main.js"></script>

        <!-- Font -->
        <link href='http://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>

        <!-- Favicon -->
        <link rel="shortcut icon" href="img/favicon.ico">

</head>
<body>

      <!-- NAVIGATION -->
        <header class="banner">
       	<nav class="navbar navbar-custom" role="navigation">
          <!-- We use the fluid option here to avoid overriding the fixed width of a normal container within the narrow content columns. -->
          <div class="container">
            <div data-scroll-header class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" data-scroll href="#top" style="text-decoration: none; font-weight:bold;color:#333;line-height:36px;font-size:36px;"><span style="color:orange">HIP</span> Accounting</a>
            </div>

            <div class="collapse navbar-collapse" id="nav">
            <!--<div class="skip-link"><a href="#content" title="<?php _e( 'Skip to content', 'hbd-theme' ) ?>"><?php _e( 'Skip to content', 'hbd-theme' ) ?></a></div>-->
            <?php #wp_page_menu( 'sort_column=menu_order' ); ?>
            <?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right nav-effect uppercase', ) ); ?>
            </div><!-- /.navbar-collapse -->
          </div>
        </nav>
        </header>

    <div id="main">
