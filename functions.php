<?php
add_theme_support( 'post-thumbnails' );
add_theme_support( 'custom-logo' ); // логотип
require get_template_directory(). '/inc/functions.php';
require get_template_directory(). '/inc/class-widget.php';
require get_template_directory(). '/inc/stars-functions.php';

function allstars_js_css() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '4.5.0' );  
  wp_enqueue_style( 'jquery-ui-css', get_template_directory_uri() . '/assets/css/jquery-ui.min.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/jquery-ui.min.css' )); 

  wp_enqueue_style( 'select2', get_template_directory_uri() . '/assets/css/select2.min.css', array(), '4.1.0' );  
  //wp_enqueue_style( 'bootstrap-grid', get_template_directory_uri() . '/assets/css/bootstrap-grid.min.css', array(), '4.4.1' ); 
  wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', array(), '5.5.0' );  
   wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/slick/slick.css', array(), '1.8.1');
  
  wp_enqueue_style( 'fonts', get_template_directory_uri() . '/assets/fonts/fonts.css', array(), filemtime(get_stylesheet_directory() . '/assets/fonts/fonts.css' ) );  
	wp_enqueue_style( 'allstars', get_template_directory_uri() . '/assets/css/style.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/style.css' ));
  wp_enqueue_style( 'allstars-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/custom.css' ));
  wp_enqueue_style( 'allstars-custom-media', get_template_directory_uri() . '/assets/css/custom.media.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/custom.media.css' ));
  
 
 	
	wp_enqueue_style( 'fix-style', get_template_directory_uri() . '/assets/css/fix-style.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/fix-style.css' ));
	wp_enqueue_style( 'slickstyle', get_template_directory_uri() . '/assets/css/slick/slick.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/slick/slick.css' ));
	wp_enqueue_style( 'slicktheme', get_template_directory_uri() . '/assets/css/slick/slick-theme.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/slick/slick-theme.css' ));
	
	
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '4.5.0', true );
  wp_enqueue_script( 'jquery-ui-js', get_template_directory_uri() . '/assets/js/jquery-ui.min.js', array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/jquery-ui.min.js' ), true );
  wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/select2/select2.full.min.js', array(), '4.1.0', true );
  wp_enqueue_script( 'select2-ru', get_template_directory_uri() . '/assets/js/select2/i18n/ru.js', array(), '4.1.0', true );
  wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/slick/slick.min.js', array(), '1.8.1', true );
  wp_enqueue_script( 'mask', get_template_directory_uri() . '/assets/js/jquery.mask.js', array(), '1.14.16', true );
	wp_enqueue_script( 'allstars', get_template_directory_uri() . '/assets/js/script.min.js', array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/script.min.js' ), true );
  wp_enqueue_script( 'allstars-custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/custom.js' ), true );

    
  if( is_page('lk') ){
    wp_enqueue_style( 'page-lk', get_template_directory_uri() . '/assets/css/page-lk.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/page-lk.css' ) ); 
    wp_enqueue_script( 'page-lk', get_template_directory_uri() . '/assets/js/page-lk.js', array(), filemtime(get_stylesheet_directory() . '/assets/js/page-lk.js' ) );
  }

  if( is_page('afisha') ){
    
    wp_enqueue_style( 'poster-style', get_template_directory_uri() . '/assets/css/poster.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/poster.css' ) ); 
    wp_enqueue_script( 'poster-script', get_template_directory_uri() . '/assets/js/poster.js', array(), filemtime(get_stylesheet_directory() . '/assets/js/poster.js' ) );
  }

  if( is_page_template('page-zvezdy.php') ){
    wp_enqueue_script( 'page-zvezdy-script', get_template_directory_uri() . '/assets/js/page-zvezdy.js', array(), filemtime(get_stylesheet_directory() . '/assets/js/page-zvezdy.js' ), true);
  }
}
add_action( 'wp_enqueue_scripts', 'allstars_js_css' );

function allstars_admin_js_css(){
  wp_enqueue_style( 'allstars_admin', get_template_directory_uri() . '/assets/css/admin.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/admin.css' ));
}
add_action('admin_enqueue_scripts', 'allstars_admin_js_css');
function allstars_register_nav_menu() {
	register_nav_menu( 'header', 'Меню в шапке' );
    register_nav_menu( 'footer', 'Меню в подвале' );
	
}
add_action( 'after_setup_theme', 'allstars_register_nav_menu' );

function allstars_widgets_init() {
  register_sidebar( array(
    'name' => 'Доп.секция 1 в меню шапки',
    'id' => 'hm-add-1',
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
  ) );
  register_sidebar( array(
    'name' => 'Доп.секция 2 в меню шапки',
    'id' => 'hm-add-2',
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
  ) );
  register_sidebar( array(
    'name' => 'Доп.секция 3 в меню шапки',
    'id' => 'hm-add-3',
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
  ) );
  register_sidebar( array(
    'name' => 'Подвал. Секция 1',
    'id' => 'footer-section-1',
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
  ) );
  register_sidebar( array(
    'name' => 'Подвал. Секция 2',
    'id' => 'footer-section-2',
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
  ) );
  register_sidebar( array(
    'name' => 'Подвал. Секция 3',
    'id' => 'footer-section-3',
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
  ) );
}
add_action( 'widgets_init', 'allstars_widgets_init' );


function only_admin(){
  if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
    wp_redirect( site_url() );
  }
}
add_action( 'admin_init', 'only_admin', 1 );

// Регистрация класса виджета
add_action( 'widgets_init', 'allstars_register_widgets' );
function allstars_register_widgets() {
	register_widget( 'Allstars_single_post' );
}