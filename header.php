<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <title><?php wp_title();?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <header class="fix7-shodow">
    <div class="container">
      <div class="row">
          <?php
            /*$custom_logo_id = get_theme_mod( 'custom_logo' );
            $logo_url_m = wp_get_attachment_image_url( $custom_logo_id , 'medium' );
            $logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );*/
            $logo_url = get_template_directory_uri().'/assets/img/logo.png';
            $logo_url_m = get_template_directory_uri().'/assets/img/mini-logo.png';
          ?>
          <div class="header col-12">
            <a href="#" class="burger" data-toggle="collapse" data-target="#mob-menu"></a>
            <a href="/"><img class="logo" src="<?php echo $logo_url_m;?>" alt="<?php bloginfo( 'name' );?>"/></a>
            <?php if ( is_user_logged_in() ) :?>
            <a href="<?php echo wp_logout_url(get_permalink());?>"><img class="exit" src="<?php echo get_template_directory_uri(); ?>/assets/img/exit.png" alt=""></a>
            <?php else:?>
            <a href="#" data-toggle="modal" data-target="#login"><img class="exit" src="<?php echo get_template_directory_uri(); ?>/assets/img/exit.png" alt=""></a>
            <?php endif;?>
          </div>
          <div class="col-sm-12 col-md-10 col-lg-9 col-xl-9">
            <div class="box_menu">
              <a href="/"><img src="<?php echo $logo_url;?>" class="logo" alt="<?php bloginfo( 'name' );?>"/></a>
              <div class="drop_menu">
                <a class="menu_katalog" href="#">Каталог</a>
                  <div class="drop_down_menu">
                    <div class="drop_down_menu-redactor">
                      <div class="container">
                      <div class="row">
                        <div class="col-8">
                          <div class="row">
                            <div class="col-4">
                                <?php wp_nav_menu( array(
                                  'theme_location' => 'header',
                                  'container' => '',
                                  'menu_class' => 'menu main-menu',
                                  'menu_id' => 'header-menu',
                                  'echo' => true,
                                  'depth' => 0,
                                ) );?>
                            </div>
                            <div class="col-4">
                              <?php if( is_active_sidebar( 'hm-add-1' ) ){
                                dynamic_sidebar( 'hm-add-1' );
                              } ?>
                            </div>
                            <div class="col-4">
                              <?php if( is_active_sidebar( 'hm-add-2' ) ){
                                dynamic_sidebar( 'hm-add-2' );
                              } ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-4">
                          <?php if( is_active_sidebar( 'hm-add-3' ) ){
                            dynamic_sidebar( 'hm-add-3' );
                          } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php get_search_form(); ?>
            </div>
          </div>
          <div class="d-none d-md-block col-md-2 col-lg-3 col-xl-3">
            <div class="menu_links row align-items-center">
                <div class="col-7 text-center" id="headercity" data-city="<?php echo allstars_get_translite_name_city($_COOKIE['geo_promo_city']); ?>">               
                  <?php echo do_shortcode('[geo_promo_getLink is_popover="0"]');?>
                </div>
                <div class="col-5 text-right d-flex flex-end">
                  <?php if ( is_user_logged_in() ) :
                  $current_user = wp_get_current_user();
                  ?>
                  <a class="user_link" href="/lk/"><?php echo stristr($current_user->user_email, '@', true);?></a>
                  <a class="exit_link" href="<?php echo wp_logout_url(get_permalink());?>" title="Выход"></a>
                  <?php else:?>
                  <a class="entry_link" href="#" data-toggle="modal" data-target="#login">Вход</a>
                  <?php endif;?>
                </div>
            </div>
          </div>
        </div>
    </div>
    <div class="header-menu-mob collapse navbar-collapse mob-collapse" id="mob-menu">
      <div class="mob-header text-right">
        <a href="#" class="close" data-toggle="collapse" data-target="#mob-menu"></a>
      </div>
      <div class="mob-content">
        <ul class="top-menu-mob">
          <li class="menu-item-has-children icon icon-cursor"><?php echo do_shortcode('[geo_promo_getLink is_popover="0"]');?></li>
          <li class="menu-item-has-children icon icon-search"><a href="#" data-toggle="collapse" data-target="#search-mob">Поиск исполнителя</a></li>
          <li class="menu-item-has-children icon icon-catalog"><a href="#" data-toggle="collapse" data-target="#catalog-mob">Каталог</a></li>
        </ul>
        <?php wp_nav_menu( array(
          'theme_location' => 'header',
          'container' => '',
          'menu_class' => 'menu main-menu',
          'menu_id' => 'header-menu-mob',
          'echo' => true,
          'depth' => 0,
        ) );?>
      </div>
    </div>
    <div class="mob-collapse collapse navbar-collapse" id="search-mob">
      <div class="mob-header text-center hover sub-menu">
        <a href="#" class="close" data-toggle="collapse" data-target="#search-mob">Поиск</a>
      </div>
      <div class="mob-content">
        <div class="text-center mt-4">
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
    <div class="mob-collapse collapse navbar-collapse" id="catalog-mob">
      <div class="mob-header text-center hover sub-menu">
        <a href="#" class="close" data-toggle="collapse" data-target="#catalog-mob">Каталог</a>
      </div>
      <div class="mob-content">
        <?php if( is_active_sidebar( 'hm-add-1' ) ){
          dynamic_sidebar( 'hm-add-1' );
        } ?>
        <?php if( is_active_sidebar( 'hm-add-2' ) ){
          dynamic_sidebar( 'hm-add-2' );
        } ?>
      </div>
    </div>
  </header>
	<div id="content" class="site-content">
  <?php if(!is_front_page()){?>
    <!-- <div class="background-color"> -->
      <?php
      if ( function_exists('yoast_breadcrumb') && !get_field('is_breadcrumbs') ) {
        yoast_breadcrumb( '<div class="container"><p class="breadcrumbs">','</p></div>' );
      }
      ?>
  <?php } ?>
