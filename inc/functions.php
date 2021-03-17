<?php
/**
* This is helper
*/

function show($inner){
   echo "<pre>";
   print_r($inner);
   echo "</pre>";
}
/*******************************/

/**
* Проверка пользователя на авторизацию
*/

function access_reg(){
  if(!is_user_logged_in()) {
    wp_redirect( home_url() );
    exit;
  }
}
/*
* Регистрация изображения в системе
**/
add_image_size( 'star-preview', 600, 600, true );
add_image_size( 'star-comment-thumbnail', 120, 90, true );
add_image_size( 'main-star-preview', 520, 350, true );

/*
* Подсчет количества элементов в массиве
**/
function isAssoc(array $arr){
  if (array() === $arr) return false;
  return array_keys($arr) !== range(0, count($arr) - 1);
}

/*
* Отключение верхнего панеля, если не администратор
**/
if ( ! current_user_can( 'administrator' ) ) {
  show_admin_bar( false );
}

/*
* Создание в консоле пункт "настрока темы" -> edit_posts
**/

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Настройки темы',
		'menu_title'	=> 'Настройки темы',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

/*
* Создание кстомные роли пользователей
**/


$args_allstars_role = array(
  'read' => true,
);
add_role( 'allstars_artist', __('Артист', 'allstars'), $args_allstars_role);
add_role( 'allstars_group', __('Группа', 'allstars'), $args_allstars_role);
add_role( 'allstars_specialist', __('Специалист', 'allstars'), $args_allstars_role);
add_role( 'allstars_agency', __('Агентство', 'allstars'), $args_allstars_role);


function allstars_change_role_name(){
  $roles = array('allstars_artist', 'allstars_group', 'allstars_specialist', 'allstars_agency');
  foreach($roles as $role):
    $role_init = get_role( $role );
    if($role_init):
      $role_init->add_cap( 'upload_files' );
    endif;
  endforeach;
}
add_action('init', 'allstars_change_role_name');

/*
* Получение полного списка городов из базы данных
**/

function allstars_get_full_cities(){
  $new_array = array();
  global $wpdb;
  $table_name = $wpdb->prefix . "geo_promo_cities";
  if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
    $cities = $wpdb->get_results("SELECT name, translite FROM $table_name");
    if($cities){
      foreach($cities as $city){
        $new_array[$city->translite] = $city->name;
      }
    }
  }
  return $new_array;
}

/*
* Регистрация типов аккаунтов 
**/

function allstars_wp_registration_type_account($field_arr){
  $new_array = array();
  foreach($field_arr as $key => $val){
    if(stristr($key, 'allstars_')){
      $new_array[$key] = $val;
    }
  }
  $field_arr = $new_array;
  return $field_arr;
}
add_filter('wp_registration_type_account', 'allstars_wp_registration_type_account', 10, 1);

/*
* Регистрация типов специализации 
**/

function allstars_wp_registration_specialization($field_arr){
  $new_array = array(
    'photo_video' => __( 'Фото и видео', 'allstars' ),
    'children_events' => __( 'Детские мероприятия', 'allstars' ),
    'artists' => __( 'Артисты для выступлений', 'allstars' ),
    'staff_events' => __( 'Персонал для мероприятий', 'allstars' ),
    'training_master' => __( 'Обучения и мастер-классы', 'allstars' ),
    'event_management' => __( 'Ведение мероприятий', 'allstars' ),
  );
  foreach($new_array as $key => $val){
    $field_arr[$key] = $val;
  }
  return $field_arr;
}
add_filter('wp_registration_specialization', 'allstars_wp_registration_specialization', 10, 1);

/*
* Регистрация городов 
**/

function allstars_wp_registration_cities($field_arr){
  $new_array = allstars_get_full_cities();
  if($new_array != array())
  foreach($new_array as $key => $val){
    $field_arr[$key] = $val;
  }
  return $field_arr;
}
add_filter('wp_registration_cities', 'allstars_wp_registration_cities', 10, 1);

/*
* Регистрация вида деятельности
**/

function allstars_profile_direction($field_arr){
  $new_array = array(
    'photo_video_wedding' => __( 'Свадебная фотосессия', 'allstars' ),
    'photo_video_lovestory' => __( 'Фотосессия Lovestory', 'allstars' ),
    'photo_video_fotographer' => __( 'Фотограф', 'allstars' ),
    'photo_video_videographer' => __( 'Видеограф', 'allstars' ),
    'photo_video_3d_360' => __( 'Предметная съемка 3D/360 градусов', 'allstars' ),
    'photo_video_photobooth' => __( 'Фотобудка', 'allstars' ),
    'photo_video_instaprinter' => __( 'Инстапринтер', 'allstars' ),
    'children_events_animators' => __( 'Аниматоры', 'allstars' ),
    'children_events_chemical_show' => __( 'Химическое шоу', 'allstars' ),
    'children_events_soap_bubbles_show' => __( 'Шоу гигантских мыльных пузырей', 'allstars' ),
    'children_events_ded_moroz_snegurochka' => __( 'Дед Мороз и Снегурочка', 'allstars' ),
    'children_events_foil_paper_show' => __( 'Фольгированное или Бумажное шоу', 'allstars' ),
    'artists_vocalists' => __( 'Вокалисты', 'allstars' ),
    'artists_musicians' => __( 'Музыканты', 'allstars' ),
    'artists_musical_groups' => __( 'Музыкальные коллективы', 'allstars' ),
    'artists_jazz_band' => __( 'Джаз-Бенд', 'allstars' ),
    'artists_cover_bands' => __( 'Кавер-группы', 'allstars' ),
    'artists_dj' => __( 'Dj', 'allstars' ),
    'artists_musical' => __( 'Артисты мюзиклов', 'allstars' ),
    'artists_ethnic_groups' => __( 'Этнические коллективы', 'allstars' ),
    'artists_clowns' => __( 'Клоуны', 'allstars' ),
    'artists_pantomime' => __( 'Мимы', 'allstars' ),
    'artists_walkers' => __( 'Ходулисты', 'allstars' ),
    'artists_magicians' => __( 'Иллюзионисты, фокусники', 'allstars' ),
    'artists_jugglers' => __( 'Жонглеры', 'allstars' ),
    'artists_living_statues' => __( 'Живые статуи', 'allstars' ),
    'artists_equilibrists' => __( 'Эквилибристы', 'allstars' ),
    'artists_dance_groups' => __( 'Танцевальные коллективы', 'allstars' ),
    'artists_dancer' => __( 'Танцоры', 'allstars' ),
    'artists_choreographers' => __( 'Хореографы', 'allstars' ),
    'artists_brakedance' => __( 'Брейк-данс', 'allstars' ),
    'artists_acrobats' => __( 'Акробаты', 'allstars' ),
    'artists_standup_comedians' => __( 'Стендап-комики', 'allstars' ),
    'artists_parodists' => __( 'Пародисты', 'allstars' ),
    'artists_doubles_show' => __( 'Шоу двойников', 'allstars' ),
    'artists_singing_chefs_waiters_show' => __( 'Шоу поющих поваров/официантов', 'allstars' ),
    'artists_humorous_show' => __( 'Юмористическое шоу', 'allstars' ),
    'artists_performances' => __( 'Перформансы', 'allstars' ),
    'artists_light_drum_show' => __( 'Шоу световых барабанов', 'allstars' ),
    'artists_light_show' => __( 'Световое шоу', 'allstars' ),
    'artists_bartender_show' => __( 'Бармен шоу', 'allstars' ),
    'artists_tesla_electric_show' => __( 'Электрическое шоу Тесла', 'allstars' ),
    'artists_fire_show' => __( 'Огненное шоу', 'allstars' ),
    'artists_animals_show' => __( 'Шоу с животными', 'allstars' ),
    'artists_laser_show' => __( 'Лазерное шоу', 'allstars' ),
    'staff_events_waiters' => __( 'Официанты', 'allstars' ),
    'staff_events_bartenders' => __( 'Бармены', 'allstars' ),
    'staff_events_hostess' => __( 'Хостес', 'allstars' ),
    'staff_events_admin_manager' => __( 'Администратор/менеджер сопровождения мероприятия', 'allstars' ),
    'training_master_vocal_educators' => __( 'Педагоги по вокалу', 'allstars' ),
    'training_master_acting_educators' => __( 'Педагоги по актерскому мастерству', 'allstars' ),
    'training_master_stage_speech_public_speaking' => __( 'Педагоги по сценической речи и ораторскому мастерству', 'allstars' ),
    'event_management_sand_ceremony' => __( 'Песочная церемония', 'allstars' ),
    'event_management_workshop_soap_toy' => __( 'Мастер-класс по созданию мыла с игрушкой внутри', 'allstars' ),
    'event_management_ebru' => __( 'Рисование на воде (Эбру)', 'allstars' ),
    'event_management_sand_snow_painting' => __( 'Рисование песком/снегом', 'allstars' ),
    'event_management_painting_tshirts_caps_acrylic' => __( 'Роспись футболок/кепок акриловыми красками', 'allstars' ),
    'event_management_workshop_gel_candle' => __( 'Мастер-класс по созданию гелевой свечи индивидуального дизайна', 'allstars' ),
    'event_management_painting_gingerbread' => __( 'Роспись на пряниках', 'allstars' ),
    'event_management_jewelry_foamiran' => __( 'Создание украшений из фоамирана', 'allstars' ),
  );
  foreach($new_array as $key => $val){
    $field_arr[$key] = $val;
  }
  return $field_arr;
}

/*
* Регистрация полей специализации
**/

function allstars_load_field_specialization($field){
  $new_array = array();
  $new_array = allstars_wp_registration_specialization($new_array);
  foreach( $new_array as $key => $val ) {
    $field['choices'][ $key ] = $val;
  }
  return $field;
}

add_filter('acf/load_field/key=field_5f0dabc1008b3', 'allstars_load_field_specialization');

/*
* Регистрация вида деятельности
**/

function allstars_load_field_profile_direction($field){
  $new_array = array();
  $new_array = allstars_profile_direction($new_array);
  foreach( $new_array as $key => $val ) {
    $field['choices'][ $key ] = $val;
  }
  return $field;
}

add_filter('acf/load_field/key=field_5f3129e974f0f', 'allstars_load_field_profile_direction');

/*
* Регистрация городов
**/

function allstars_load_field_cities($field){
  $new_array = allstars_get_full_cities();
  if($new_array == array()){
    $new_array = array(
      'Moskva' => 'Москва',
      'Sankt-Peterburg' => 'Санкт-Петербург',
      'Kazan' => 'Казань'
    );
  }
  foreach( $new_array as $key => $val ) {
    $field['choices'][ $key ] = $val;
  }
  return $field;
}

add_filter('acf/load_field/key=field_5f0daaf5008b1', 'allstars_load_field_cities');

/*
// Отменяем письма для всех
remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications' );

// Добавляем (если нужно) обратно, но только для пользователя
add_action( 'register_new_user', 'allstars_send_new_user_notifications' );
add_action( 'edit_user_created_user', 'allstars_send_new_user_notifications' );

function allstars_send_new_user_notifications( $user_id ) {
	wp_new_user_notification( $user_id, null, 'user' );
}*/

/*
* Авторизация в системе
**/

function allstars_form_login($request = ''){
  $url = ($request != '') ? $request : explode('?', $_SERVER['REQUEST_URI'], 2)[0];
  $args = array(
    'echo' => true,
    'redirect' => site_url( $url ),
    'form_id' => 'loginform',
    'label_username' => 'Логин',
    'label_password' => 'Пароль',
    'label_remember' => 'Запомнить меня',
    'label_log_in' => 'Войти',
    'id_username' => 'user_login',
    'id_password' => 'user_pass',
    'id_remember' => 'rememberme',
    'id_submit' => 'wp-submit',
    'remember' => true,
    'value_username' => NULL,
    'value_remember' => 1
  );
  wp_login_form($args);
}


//add_action('wpr_promo_after_submit', 'allstars_add_recaptcha_reg_form', 10);

/*
* Шорткод (рекапча)
**/

function allstars_add_recaptcha_reg_form(){
  echo do_shortcode('[bws_google_captcha]');
}

/*
* Создание нового артиста
**/

function create_new_stars($user_id){
  if($user_id){
    $user = get_userdata( $user_id );
    $name = $user->display_name;
    $post = array(
      'post_status' => 'publish',
      'post_type' => 'stars',
      'post_author' => $user_id,
      'post_title' => $name,
      'ping_status' => get_option('default_ping_status'),
      'post_parent' => 0,
      'menu_order' => 0,
      'to_ping' =>  '',
      'pinged' => '',
      'post_password' => '',
      'guid' => '',
      'post_content_filtered' => '',
      'post_excerpt' => '',
      'import_id' => 0
    );
    $post_id = wp_insert_post( $post, true);
    update_user_meta( $user_id, 'user_post_id', $post_id );
  }
}
add_action('wpr_promo_rest_api_success', 'create_new_stars', 20, 1);

/*
* Регистрация произвольных типов записей "Звезды"
**/

function allstars_register_post_type_init() {
	$labels = array(
		'name' => 'Звезды',
		'singular_name' => 'Звезду', 
		'add_new' => 'Добавить звезду',
		'add_new_item' => 'Добавить новую звезду', 
		'edit_item' => 'Редактировать звезду',
		'new_item' => 'Новая звезда',
		'all_items' => 'Все звезды',
		'view_item' => 'Просмотр звезды на сайте',
		'search_items' => 'Искать звезду',
		'not_found' =>  'Звезда не найдена.',
		'not_found_in_trash' => 'В удаленных нет звезды.',
		'menu_name' => 'Все звезды' 
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		//'show_in_nav_menus' = true,
		'show_ui' => true, 
		'has_archive' => false,
		'menu_icon' => 'dashicons-star-filled', 
		'menu_position' => 20, 
		'supports' => array( 'title', 'editor','comments', 'author','custom-fields')
	);
	register_post_type('stars', $args);
}
add_action( 'init', 'allstars_register_post_type_init' );

/*
* Регистрация произвольных типов записей "Биржа"
**/

function allstars_register_post_type_ads() {
	$labels = array(
		'name' => 'Биржа',
		'singular_name' => 'Объявление', // админ панель Добавить->Функцию
		'add_new' => 'Добавить объявление',
		'add_new_item' => 'Добавить новое объявление', // заголовок тега <title>
		'edit_item' => 'Редактировать объявление',
		'new_item' => 'Новое объявление',
		'all_items' => 'Все объявления',
		'view_item' => 'Просмотр объявления на сайте',
		'search_items' => 'Искать объявление',
		'not_found' =>  'Объявление не найдена.',
		'not_found_in_trash' => 'В удаленных нет объявления.',
		'menu_name' => 'Биржа' // ссылка в меню в админке
	);
	$args = array(
		'labels' => $labels,
		'public' => false,
		'show_ui' => true, // показывать интерфейс в админке
		'has_archive' => true,
		'menu_icon' => 'dashicons-analytics', // иконка в меню
		'menu_position' => 21, // порядок в меню
		'supports' => array( 'title', 'editor', 'author')
	);
	register_post_type('ads', $args);
}
add_action( 'init', 'allstars_register_post_type_ads' );

/*
* Обработка при забытии пароля
**/

function add_lost_password_link() {
	return '<p class="lostpassword"><a href="'.esc_url( wp_lostpassword_url() ).'">'.__( 'Забыли пароль?', 'allstars' ).'</a></p>';
}
add_action( 'login_form_middle', 'add_lost_password_link' );

/*
* Ограничения вывода слов предложения
*
* @param  string $string.
* @return string
**/

function do_excerpt($string, $word_limit) {
  $string = strip_tags($string);
  $words = explode(' ', $string, ($word_limit + 1));
  if (count($words) > $word_limit)
	array_pop($words);
  echo implode(' ', $words).' ...';
}

/*
* Различный формат вывода для разных типов заголовоков
*
* @param  string $title.
* @return string
**/

add_filter( 'get_the_archive_title', function ($title) {
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
  } elseif ( is_author() ) {
    $title = '<span class="vcard">' . get_the_author() . '</span>' ;
  } elseif ( is_tax() ) { //for custom post types
    $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
  } elseif (is_post_type_archive()) {
    $title = post_type_archive_title( '', false );
  }
  return $title;
});

/*
* Работа с произвольными полями ACF. Обновление либо получение
*
* @param number $post_ID. 
* @param string $field.
* @param bool   $save.
* @param string $val.
*
* @return bool $res
**/

function allstars_acf_field($post_ID, $field, $save = false, $val = ''){
  $res = false;
  if( have_rows('block_right', $post_ID) ) {
    while( have_rows('block_right', $post_ID) ) {
      the_row();
      if($save){
        update_sub_field($field, $val, $post_ID);
        $res = true;
      }else{
        $res = get_sub_field($field, $post_ID);
      }
    }
  }
  return $res;
}

/*
* Работа с произвольными полями ACF. Сохранение данных.
*
* @param number $post_ID. 
* @param string $post.
* @param bool   $update.
*
**/

function allstar_save_post_stars($post_ID, $post, $update){
  $slug = 'stars';
  if ( $slug != $_POST['post_type'] )
		return;
  if ( $parent_id = wp_is_post_revision( $post_ID ) )
		$post_ID = $parent_id;

  if(!$update){ 
    remove_action( 'save_post', 'allstar_save_post_stars' );
    //update_field( 'name', $post->post_title, $post_ID );
    allstars_acf_field($post_ID, 'name', true, $post->post_title);
    add_action( 'save_post', 'allstar_save_post_stars' );
  }else{
    //$name_field = get_field('name', $post_ID);
    $name_field = allstars_acf_field($post_ID, 'name');
    if($name_field){
      remove_action( 'save_post', 'allstar_save_post_stars' );
      $post_name = sanitize_title($name_field);
      wp_update_post( array( 'ID' => $post_ID, 'post_title' => $name_field, 'post_name' => $post_name) );
      add_action( 'save_post', 'allstar_save_post_stars' );
    }
  }
}
add_action( 'save_post', 'allstar_save_post_stars', 10, 3 );

/*
* Вывод комментарий
*
* @param number $comment. 
* @param mixed $args.
* @param bool   $depth.
*
**/

function allstar_comment( $comment, $args, $depth ){ ?>
<div class="comment" id="comment-<?php comment_ID() ?>">
    <div class="row">
    <div class="col-12 col-lg-3">
      <div class="author"><?php comment_author();?></div>
      <div class="date"><?php comment_date( 'j F Y' );?></div>
      <div class="rating">
        <?php echo do_shortcode('[promo_comment_rating_display]');?>
      </div>
    </div>
    <div class="col-12 col-lg-9">
      <div class="text">
        <?php comment_text() ?>
      </div>
      <?php if(have_rows('images', $comment)): while(have_rows('images', $comment)): the_row();
        $images = array('img_1', 'img_2', 'img_3', 'img_4');
      ?>
      <div class="images">
        <div class="row">
          <?php foreach($images as $img):
          $item = get_sub_field($img);
          if($item):?>
          <div class="col-3 col-sm-6 col-md-3 mt-3">
            <a href="<?php echo $item['url'];?>" class="fancybox-image">
              <img class="fix2-img" src="<?php echo $item['sizes']['star-comment-thumbnail'];?>" alt=""/>
            </a>
          </div>
          <?php endif; endforeach;?>
        </div>
      </div>
      <?php endwhile; endif;?>
    </div>
  </div>
  <?php
}

/*
* Формирования запроса к произвольным полям 
*
**/

function allstars_get_orderby_meta($meta_query){
  $meta_query['relation'] = 'AND';
  $meta_query['is_top'] = array(
    'key' => 'is_top',
    'compare' => 'EXISTS'
  );
  $meta_query['rating_star'] = array(
    'key' => 'rating_star',
    'type' => 'NUMERIC',
    'compare' => 'EXISTS'
  );
  $meta_query['responsibility_star'] = array(
    'key' => 'responsibility_star',
    'type' => 'NUMERIC',
    'compare' => 'EXISTS'
  );
  $orderby = array(
    'is_top' => 'DESC',
    'rating_star' => 'DESC',
    'responsibility_star' => 'DESC',
  );
  return array(
    'meta_query' => $meta_query,
    'orderby' => $orderby
  );
}
/**	
* Функция сортировки звезд
*
*/

function allstars_change_sort_order_for_stars($query){
  if( is_admin() && !$query->is_main_query()) {
		return;
	}
  if( $query->is_post_type_archive('stars') ) {
    if(isset($query->query_vars['meta_query'])){
      $arr_get = allstars_get_orderby_meta($query->query_vars['meta_query']);
    }else{
      $arr_get = allstars_get_orderby_meta(array());
    }
    $meta_query = $arr_get['meta_query'];
    $orderby = $arr_get['orderby'];
		$query->set( 'meta_query', $meta_query );
		$query->set( 'orderby', $orderby);
	}

}
add_action( 'pre_get_posts', 'allstars_change_sort_order_for_stars', 9999);

/**
* Рейтинги
*
*/

function allstar_get_rating($post_id, $type = '', $is_title = false, $is_column = false, $is_req = false){
  $title_1 = 'Качество'; // Рейтинг-Качество
  $title_2 = 'Ответственность';
  $attr_title_1 = 'Качество'; // Рейтинг-Качество
  $attr_title_2 = 'Ответственность';
  $rating = get_post_meta( $post_id, 'rating_star', true );
  $responsibility = get_post_meta( $post_id, 'responsibility_star', true );
  $css_block = '';
  if($is_title){
    $req = ($is_req) ? '*': '';
    $title_1 = '<div class="title">Качество'.$req.'</div>';
    $title_2 = '<div class="title">Ответственность'.$req.'</div>';
    $attr_title_1 = '';
    $attr_title_2 = '';
  }
  if($is_column){
    $css_block = 'col-12 col-md-6';
  }
  if($type !== 'dynamic'):?>
  <div class="comments-rating-promo rating-promo <?php echo $css_block;?>">
    <?php echo $title_1;?>
    <div class="rating static" ><!-- title="Рейтинг" -->
      <?php for ( $i = 5; $i >= 1; $i-- ) : ?>
        <?php if($rating == $i){?>
        <i class="checked"></i>
        <?php }else{?>
        <i></i>
        <?php }?>
      <?php endfor; ?>
    </div>
	</div>
  <div class="comments-rating-promo responsibility-promo <?php echo $css_block;?>">
    <?php echo $title_2;?>
    <div class="rating static" ><!-- title="Ответственность" -->
      <?php for ( $i = 5; $i >= 1; $i-- ) : ?>
        <?php if($responsibility == $i){?>
        <i class="checked"></i>
        <?php }else{?>
        <i></i>
        <?php }?>
      <?php endfor; ?>
    </div>
	</div>
  <?php else: ?>
  <div class="comments-rating-promo rating-promo <?php echo $css_block;?>">
    <?php echo $title_1;?>
    <div class="rating" title="<?php echo $attr_title_1;?>">
      <?php for ( $i = 5; $i >= 1; $i-- ) : ?>
        <input type="radio" name="rating" value="<?php echo esc_attr( $i ); ?>" />
        <i></i>
      <?php endfor; ?>
    </div>
	</div>
  <div class="comments-rating-promo responsibility-promo <?php echo $css_block;?>">
    <?php echo $title_2;?>
    <div class="rating" title="<?php echo $attr_title_2;?>">
      <?php for ( $i = 5; $i >= 1; $i-- ) : ?>
        <input type="radio" name="responsibility" value="<?php echo esc_attr( $i ); ?>" />
        <i></i>
      <?php endfor; ?>
    </div>
	</div>
  <?php endif;
}

function allstar_replace_char($str, $char = '*'){
  $res = '';
  for($i = 1; $i <= strlen($str); $i++){
    $res .= $char;
  }
  return $res;
}

function allstar_hide_part($value, $type){
  $hide_text = $value;
  if(!$type){
    return $hide_text;
  }
  switch($type){
    case 'email':
      $_temp_start = stristr($value, '@', true);
      $_temp_end = stristr($value, '@');
      $hide_text = allstar_replace_char($_temp_start).$_temp_end;
  }
  return $hide_text;
}

// функция поиска ролей пользователя
function allstars_get_role_user(){
  $find = array('allstars_artist', 'allstars_group', 'allstars_specialist', 'allstars_agency');
  $user = get_userdata( get_current_user_id() );
  // Получает данные указанного пользователя в виде объекта WP_User.
  //  false — если не удалось найти указанного пользователя.
  
  
  $roles_user = $user->get_role_caps();
  //get_role_caps() - получает все возможности 
  // роли пользователя и объединяет их с 
  // индивидуальными возможностями пользователя;
  
  
  $keys_role = array_keys($roles_user);
  // array_keys — Возвращает подмножество ключей массива
  
  
  $result = '';
  // перебираем ключ пользователя  в масиве ключей, находим и выходим из цикла
  foreach($keys_role as $role){
    if(in_array($role, $find)){
      $result = $role;
      break;
    }
  }
  
  return $result;
  // возвращаем роль пользователя
}

function allstars_get_rating_and_responsibility($comment_id){
  $cur_comment = get_comment($comment_id);
  $post_id = $cur_comment->comment_post_ID;
  $args = array('post_id' => $post_id, 'post_type' => 'stars', 'status' => 'approve', 'comment__not_in' => $comment_id);
  $comments = get_comments($args);
  $rating_sum = 0;
  $responsibility_sum = 0;
  $count = count($comments);
  if($count > 0){
    foreach($comments as $comment){
      $rating_sum = $rating_sum + get_comment_meta( $comment->comment_ID, 'rating', true );
      $responsibility_sum = $responsibility_sum + get_comment_meta( $comment->comment_ID, 'responsibility', true );
    }
  }
  $result = array(
    'rating' => $rating_sum,
    'responsibility' => $responsibility_sum,
    'count' => $count,
  );
  return $result;
}

function allstars_correct_rating($val, $min = 1, $max = 5){
  if($val > $max){
    $val = $max;
  }
  if($val < $min){
    $val = $min;
  }
  return $val;
}

add_action( 'comment_post', 'allstars_comment_rating_save', 90, 1 );
add_action( 'edit_comment', 'allstars_comment_rating_save', 90, 1 );
function allstars_comment_rating_save($comment_id){
  if( isset($_POST['rating']) && isset($_POST['responsibility'])){
    $cur_comment = get_comment($comment_id);
    if($cur_comment->comment_approved != 1){
      return;
    }
    $data = allstars_get_rating_and_responsibility($comment->comment_ID);
    $count = $data['count'] + 1;
    $rating_sum = $data['rating'] + intval($_POST['rating']);
    $responsibility_sum = $data['responsibility'] + intval($_POST['responsibility']);

    $medium_rating = allstars_correct_rating(round( $rating_sum / $count ));
    $medium_responsibility = allstars_correct_rating(round( $responsibility_sum / $count));

    update_post_meta($post_id, 'rating_star', $medium_rating);
    update_post_meta($post_id, 'responsibility_star', $medium_responsibility);
  }
}

add_action('transition_comment_status', 'allstars_comment_rating_change_status', 10, 3);
function allstars_comment_rating_change_status($new_status, $old_status, $comment){
  if($new_status != $old_status){
    $post_id = $comment->comment_post_ID;
    if($new_status == 'approved'){
      $data = allstars_get_rating_and_responsibility($comment->comment_ID);
      $cur_rating = get_comment_meta( $comment->comment_ID, 'rating', true );
      $cur_responsibility = get_comment_meta( $comment->comment_ID, 'responsibility', true );
      $count = $data['count'] + 1;
      $rating_sum = $data['rating'] + $cur_rating;
      $responsibility_sum = $data['responsibility'] + $cur_responsibility;
      $medium_rating = allstars_correct_rating(round( $rating_sum / $count ));
      $medium_responsibility = allstars_correct_rating(round( $responsibility_sum / $count));
      update_post_meta($post_id, 'rating_star', $medium_rating);
      update_post_meta($post_id, 'responsibility_star', $medium_responsibility);
    }else{
      $data = allstars_get_rating_and_responsibility($comment->comment_ID);
      $cur_rating = get_comment_meta( $comment->comment_ID, 'rating', true );
      $cur_responsibility = get_comment_meta( $comment->comment_ID, 'responsibility', true );
      $count = $data['count'];
      $rating_sum = $data['rating'];
      $responsibility_sum = $data['responsibility'];
      $medium_rating = allstars_correct_rating(round( $rating_sum / $count ));
      $medium_responsibility = allstars_correct_rating(round( $responsibility_sum / $count));
      update_post_meta($post_id, 'rating_star', $medium_rating);
      update_post_meta($post_id, 'responsibility_star', $medium_responsibility);
    }
  }

}

// Функция получения всех городов
function allstars_get_cities($query_vars){
  $stars = new WP_Query($query_vars);
  $result = array();
  if ( $stars->have_posts() ) : while ( $stars->have_posts() ) : $stars->the_post();
    $_temp_arr = allstars_acf_field(get_the_ID(), 'cities');
	foreach($_temp_arr as $_temp){
	  if(!in_array($_temp['label'], $result)){
        $result[$_temp['value']] = $_temp['label'];
      }
    }

  endwhile; endif;
  wp_reset_query();
  asort($result);
  return $result;
}

function allstars_get_performers($query_vars){
  $result = array(
    'private' => 0,
    'agency' => 0
  );

  $users_private = get_users( [
    'role__in'   => array('allstars_artist', 'allstars_specialist', 'allstars_group'),
    'fields' => 'ID'
  ] );
  $users_agency = get_users( [
    'role__in'   => array('allstars_agency'),
    'fields' => 'ID'
  ] );
  if(count($users_private) > 0){
    $query_vars['author__in'] = $users_private;
    $stars_1 = new WP_Query($query_vars);
    $result['private'] = $stars_1->found_posts;
  }
  if(count($users_agency) > 0){
    $query_vars['author__in'] = $users_agency;
    $stars_2 = new WP_Query($query_vars);
    $result['agency'] = $stars_2->found_posts;
  }

  return $result;
}

function allstars_get_specialization($query_vars){
  /*$stars = new WP_Query($query_vars);
  $result = array();
  if ( $stars->have_posts() ) : while ( $stars->have_posts() ) : $stars->the_post();
    $_temp_arr = allstars_acf_field(get_the_ID(), 'specialization');
    foreach($_temp_arr as $_temp){
      if(!in_array($_temp['label'], $result)){
        $result[$_temp['value']] = $_temp['label'];
      }
    }

  endwhile; endif;
  wp_reset_query();*/
  $arr_field = array();
  $result = allstars_wp_registration_specialization($arr_field);
  return $result;
}

function allstars_get_profile_direction($query_vars){
  $arr_field = array();
  $result = allstars_profile_direction($arr_field);
  return $result;
}

function allstars_getFullYears($birthdayDate) {
  $datetime = new DateTime($birthdayDate);
  $interval = $datetime->diff(new DateTime(date("d.m.Y")));
  return $interval->format("%Y");
}

// подбор исполнителя
function allstars_send_online_selection($email, $message){
  $headers[] = 'Content-type: text/html; charset=utf-8';
  $subject = 'Онлайн подбор исполнителя';
  $msg = '';
  ob_start();
  get_template_part( 'template-emails/email', 'header');
  echo $message;
  get_template_part( 'template-emails/email', 'footer');
  $msg = ob_get_clean();
  wp_mail( $email, $subject, $msg, $headers);
}
// обработка его ajax
add_action('wp_ajax_allstars_online_selection', 'allstars_online_selection_func'); // wp_ajax_{ACTION HERE}
add_action('wp_ajax_nopriv_allstars_online_selection', 'allstars_online_selection_func');
function allstars_online_selection_func(){
  if($_POST){
    $args = array(
      'post_type' => 'stars',
      'post_status' => 'publish'
    );
    $meta_query = array();
    if(isset($_POST['cities']) && $_POST['cities'] != ''){
      $meta_query[] = array(
        'key' => 'block_right_cities', //
        'value' => $_REQUEST['cities'],
        'compare' => 'LIKE'
      );
    }
    if( isset($_POST['performers']) && $_POST['performers'] != '') {
      $users_id = array();
      if($_POST['performers'] == 'private'){
        $users_id = get_users( [
          'role__in'   => array('allstars_artist', 'allstars_specialist', 'allstars_group'),
          'fields' => 'ID'
        ] );
        $args['author__in'] = $users_id;
      }elseif($_POST['performers'] == 'agency'){
        $users_id = get_users( [
          'role__in'   => array('allstars_agency'),
          'fields' => 'ID'
        ] );
        $args['author__in'] = $users_id;
      }
    }
    if( isset($_POST['specialization']) && $_POST['specialization'] != ''){
      $meta_query[] = array(
        'key' => 'block_right_specialization',
        'value' => $_POST['specialization'],
        'compare' => 'LIKE'
      );
    }
    /*if( isset($_POST['rating']) && $_POST['rating'] != ''){
      $meta_query[] = array(
        'key' => 'rating_star',
        'value' => $_REQUEST['rating'],
        'compare' => '='
      );
    }
    if( isset($_POST['responsibility']) && $_POST['responsibility'] != '' ){
      $meta_query[] = array(
        'key' => 'responsibility_star',
        'value' => $_REQUEST['responsibility'],
        'compare' => '='
      );
    }*/
    if(isset($_POST['rating']) && $_POST['rating'] == '1'){
      $meta_query[] = array(
        'key' => 'rating_star',
        'value' => 4,
        'type' => 'NUMERIC',
        'compare' => '>='
      );
    }
    $arr_get = allstars_get_orderby_meta($meta_query);
    $args['meta_query'] = $arr_get['meta_query'];
    $args['orderby'] = $arr_get['orderby'];
    $args['posts_per_page'] = intval('10');
    $args['nopaging'] = true;
    ob_start();
    $query = new WP_Query( $args );
    if( $query->have_posts() ) :
      while( $query->have_posts() ): $query->the_post();
        get_template_part( 'template-emails/email', 'stars');
      endwhile;
      wp_reset_postdata();
    else :
      $css = array(
        'notfound' => 'padding: 100px 0;',
        'btn' => 'display: inline-block; width: auto; border: 1px solid #aa219e; color: #000000; text-decoration: none; padding: 10px 20px; border-radius: 30px; font-size: 24px; margin: 20px 0;'
      );
      echo '<div style="'.$css['notfound'].'">По Вашим параметрам ничего не найдено, можете посмотреть всех исполнителей по ссылке<br/><a href="'.get_site_url().'/stars/" style="'.$css['btn'].'">Все звезды</a></div>';
    endif;
    $html = ob_get_clean();
    if(isset($_POST['email']) && $_POST['email'] != ''){
      allstars_send_online_selection($_POST['email'], $html);
      echo '<div class="msg success">Сообщение отправлено Вам на почту '.$_POST['email'].'</div>';
    }else{
      echo '<div class="msg error">Ошибка, попробуйте позже</div>';
    }
  }
  wp_die();
}

// Дата через шорткоды

function allstars_get_date_shortcode($atts){
  $atts = shortcode_atts( array(
      'mask' => 'd.m.Y'
    ), $atts );
 return date($atts['mask']);
}
add_shortcode( 'allstars_get_date', 'allstars_get_date_shortcode' );


// комментарии-куки
add_filter( 'comment_form_default_fields', 'allstars_comment_form_hide_cookies_consent' );
function allstars_comment_form_hide_cookies_consent( $fields ) {
	unset( $fields['cookies'] );
	return $fields;
}
// 
add_filter( 'promo_comment_rating_title_rating', 'allstars_promo_comment_rating_title_rating' );
function allstars_promo_comment_rating_title_rating($title){
  return 'Оцените выступление исполнителя';
}
add_filter( 'promo_comment_rating_title_responsibility', 'allstars_promo_comment_rating_title_responsibility' );
function allstars_promo_comment_rating_title_responsibility($title){
  return 'Исполнитель выполнил всё, что обещал?<br/>Оцените ответственность исполнителя';
}
// отображение оплаты
add_filter('wp_sber_amount', 'allstars_wp_sber_amount', 10, 2);
function allstars_wp_sber_amount($amount, $type){
  $amount = 0;
  if(have_rows('orders', 'options')){
    while( have_rows('orders', 'options') ) : the_row();
      if(get_sub_field('type') == $type){
        $amount = get_sub_field('price');
        break;
      }
    endwhile;
  }
  return $amount;
}

/*
 * Кастомная форма восстановления пароля
 */
add_shortcode( 'allstars_custom_passreset', 'allstars_render_pass_reset_form' ); // шорткод [allstars_custom_passreset]
function allstars_render_pass_reset_form() {

 	// если пользователь авторизован, просто выводим сообщение и выходим из функции
	if ( is_user_logged_in() ) {
		return sprintf( "Вы уже авторизованы на сайте. <a href='%s'>Выйти</a>.", wp_logout_url() );
	}

	$return = ''; // переменная, в которую всё будем записывать

	// обработка ошибок, если вам нужны такие же стили уведомлений, как в видео, CSS-код прикладываю чуть ниже
	if ( isset( $_REQUEST['errno'] ) ) {
		$errors = explode( ',', $_REQUEST['errno'] );

		foreach ( $errors as $error ) {
			switch ( $error ) {
				case 'empty_username':
					$return .= '<p class="errno">Вы не забыли указать свой email?</p>';
					break;
				case 'password_reset_empty':
					$return .= '<p class="errno">Укажите пароль!</p>';
					break;
				case 'password_reset_mismatch':
					$return .= '<p class="errno">Пароли не совпадают!</p>';
					break;
				case 'invalid_email':
				case 'invalidcombo':
					$return .= '<p class="errno">На сайте не найдено пользователя с указанным email.</p>';
					break;
			}
		}
	}

	// тем, кто пришёл сюда по ссылке из email, показываем форму установки нового пароля
	if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {

		$return .= '<h3>Укажите новый пароль</h3>
			<form name="resetpassform" id="resetpassform" action="' . site_url( 'wp-login.php?action=resetpass' ) . '" method="post" autocomplete="off">
				<input type="hidden" name="login" value="' . esc_attr( $_REQUEST['login'] ) . '" autocomplete="off" />
				<input type="hidden" name="key" value="' . esc_attr( $_REQUEST['key'] ) . '" />
        <div class="row">
          <div class="col-12 col-md-6">
					  <label for="pass1">Новый пароль</label>
					  <input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" required/>
				  </div>
          <div class="col-12 col-md-6">
					  <label for="pass2">Повторите пароль</label>
					  <input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" required/>
				  </div>
        </div>
				<p class="description">' . wp_get_password_hint() . '</p>
				<p class="resetpass-submit">
					<input type="submit" name="submit" id="resetpass-button" class="button btn-reset" value="Сбросить" />
				</p>
			</form>';

		// возвращаем форму и выходим из функции
		return $return;
	}

	// всем остальным - обычная форма сброса пароля (1-й шаг, где указываем email)
	$return .= '
		<h3>Забыли пароль?</h3>
		<p>Укажите свой email, под которым вы зарегистрированы на сайте и на него будет отправлена информация о восстановлении пароля.</p>
		<form id="lostpasswordform" action="' . wp_lostpassword_url() . '" method="post">
      <div class="row justify-content-center">
        <div class="col-12 col-md-6 mb-4">
          <label for="user_login">Email</label>
          <input type="text" name="user_login" id="user_login" class="input" required>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-md-6 mb-4">
          <input type="submit" name="submit" class="lostpassword-button btn-reset" value="Отправить" />
        </div>
      </div>
      '.do_shortcode('[bws_google_captcha]').'
		</form>';

	// возвращаем форму и выходим из функции
	return $return;
}

add_action( 'login_form_lostpassword', 'allstars_pass_reset_redir' );

function allstars_pass_reset_redir() {
	// если используете другой ярлык страницы сброса пароля, укажите здесь
	$forgot_pass_page_slug = '/forgot-pass';
	// если используете другой ярлык страницы входа, укажите здесь
	$login_page_slug = '/lk';
	// если кто-то перешел на страницу сброса пароля
	// (!) именно перешел, а не отправил формой,
	// тогда перенаправляем на нашу кастомную страницу сброса пароля
	if ( 'GET' == $_SERVER['REQUEST_METHOD'] && !is_user_logged_in() ) {
		wp_redirect( site_url( $forgot_pass_page_slug ) );
		exit;
	} else if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
    		// если же напротив, была отправлена форма
    		// юзаем retrieve_password()
    		// которая отправляет на почту ссылку сброса пароля
    		// пользователю, который указан в $_POST['user_login']
		$errors = retrieve_password();
		if ( is_wp_error( $errors ) ) {
            		// если возникли ошибки, возвращаем пользователя назад на форму
            		$to = site_url( $forgot_pass_page_slug );
            		$to = add_query_arg( 'errno', join( ',', $errors->get_error_codes() ), $to );
        	} else {
            		// если ошибок не было, перенаправляем на логин с сообщением об успехе
            		$to = site_url( $login_page_slug );
            		$to = add_query_arg( 'errno', 'confirm', $to );
        	}

		// собственно сам редирект
        	wp_redirect( $to );
        	exit;
	}
}

/*
 * Манипуляции уже после перехода по ссылке из письма
 */
add_action( 'login_form_rp', 'allstars_to_custom_password_reset' );
add_action( 'login_form_resetpass', 'allstars_to_custom_password_reset' );

function allstars_to_custom_password_reset(){

	$key = $_REQUEST['key'];
	$login = $_REQUEST['login'];
	// если используете другой ярлык страницы сброса пароля, укажите здесь
	$forgot_pass_page_slug = '/forgot-pass';
	// если используете другой ярлык страницы входа, укажите здесь
	$login_page_slug = '/lk';

	// проверку соответствия ключа и логина проводим в обоих случаях
	if ( ( 'GET' == $_SERVER['REQUEST_METHOD'] || 'POST' == $_SERVER['REQUEST_METHOD'] )
		&& isset( $key ) && isset( $login ) ) {

		$user = check_password_reset_key( $key, $login );

		if ( ! $user || is_wp_error( $user ) ) {
			if ( $user && $user->get_error_code() === 'expired_key' ) {
				wp_redirect( site_url( $login_page_slug . '?errno=expiredkey' ) );
			} else {
				wp_redirect( site_url( $login_page_slug . '?errno=invalidkey' ) );
			}
			exit;
		}

	}

	if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {

		$to = site_url( $forgot_pass_page_slug );
		$to = add_query_arg( 'login', esc_attr( $login ), $to );
		$to = add_query_arg( 'key', esc_attr( $key ), $to );

		wp_redirect( $to );
		exit;

	} elseif ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {

		if ( isset( $_POST['pass1'] ) ) {

 			if ( $_POST['pass1'] != $_POST['pass2'] ) {
				// если пароли не совпадают
				$to = site_url( $forgot_pass_page_slug );

				$to = add_query_arg( 'key', esc_attr( $key ), $to );
				$to = add_query_arg( 'login', esc_attr( $login ), $to );
				$to = add_query_arg( 'errno', 'password_reset_mismatch', $to );

				wp_redirect( $to );
				exit;
			}

			if ( empty( $_POST['pass1'] ) ) {
				// если поле с паролем пустое
 				$to = site_url( $forgot_pass_page_slug );

				$to = add_query_arg( 'key', esc_attr( $key ), $to );
				$to = add_query_arg( 'login', esc_attr( $login ), $to );
				$to = add_query_arg( 'errno', 'password_reset_empty', $to );

				wp_redirect( $to );
				exit;
			}

			// тут кстати вы можете задать и свои проверки, например, чтобы длина пароля была 8 символов
			// с паролями всё окей, можно сбрасывать
			reset_password( $user, $_POST['pass1'] );
			wp_redirect( site_url( $login_page_slug . '?errno=changed' ) );

		} else {
			echo "Что-то пошло не так.";
		}
		exit;

	}
}
add_action( 'wp_login_failed', 'allstars_front_end_login_fail' );
function allstars_front_end_login_fail( $username ) {
	$referrer = $_SERVER['HTTP_REFERER'];  // откуда пришел запрос
	// Если есть referrer и это не страница wp-login.php
	if( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
		wp_redirect( add_query_arg('login', 'failed', $referrer ) );  // редиркетим и добавим параметр запроса ?login=failed
		exit;
	}
}
/* сбер  */
function allstars_wp_sberbank_table_data($row){
  if(isset($row['user_id']) && $row['user_id'] != ''){
    $args = array(
      'post_type' => 'stars',
      'author'        =>  $row['user_id'],
      'orderby'       =>  'post_date',
      'order'         =>  'ASC',
      'posts_per_page' => 1
    );
    $posts = get_posts( $args );
    foreach($posts as $post){
      $name = $post->post_title;
      $href = get_permalink($post);
      $link = '<a href="'.$href.'">'.$name.'</a>';
      $row['user_id'] = $link;
    }
  }
  return $row;
}
add_filter('wp_sberbank_table_data', 'allstars_wp_sberbank_table_data', 10, 1);


/*   */
function allstars_convert_phone($phone){
  $phone= str_replace([' ', '(', ')', '-'], '', $phone);
	return $phone;
}

/* шорткоды WP для CF7  */

add_filter( 'wpcf7_form_elements', 'do_shortcode' );

/* Удаляем H2 из пагинации */ 
add_filter('navigation_markup_template', 'my_navigation_template', 10, 2 );
function my_navigation_template( $template, $class ){
 return '
 <nav class="%1$s" role="navigation">
  <div class="nav-links">%3$s</div>
 </nav>    
 ';
}

/**
* Фильтр выборки испролнителей 
*
**/

function allstars_filter_form_stars(){
  $cities = allstars_get_cities(['post_type' => 'stars']);	
  $perfom = allstars_get_performers(['post_type' => 'stars']);
  $spec = allstars_get_specialization(['post_type' => 'stars']);
  $prof = allstars_get_profile_direction(['post_type' => 'stars']);
  $count_private = $perfom['private'];
  $count_agency = $perfom['agency'];
  $count_all = $count_private + $count_agency;
  if(isset($_POST['cities']) && $_POST['cities'] != ''){
    $selected_city = $_REQUEST['cities'];		
  }else{
    $selected_city = $_COOKIE['geo_promo_city'];
  }
  ?>
  <div id="filter-wrapper" >
  <form id="filter" class="box_forma nohidden" action="<?php echo site_url();?>/wp-admin/admin-ajax.php"
  method="POST">
    <input type="hidden" name="action" value="allstars_filter_test"/>
		<div class="center_forma">
		  <p class="city">Город</p>
			<label class="label">
        <select name="cities" id="cities" class="selectclass">
          <option value="">Любой</option>
          <?php foreach($cities as $key => $city):?>
          <option value="<?php echo $key;?>" <?php selected($selected_city, $city);?>><?php echo $city;?></option>
          <?php endforeach;?>
        </select>
			</label>
     <div class="block-filter performers">
        <p class="title">Исполнители</p>
        <?php if($count_all > 0):?>
        <div class="item">
          <input type="radio" name="performers" value="all"/>
          <div class="link-performers">
              <span	class="text_span">Все</span>
              <span class="number_span" id="count_all_js"><?php echo $count_all;?></span>
          </div>
        </div>
        <?php endif;?>
        <?php if($count_private > 0):?>
        <div class="item">
          <input type="radio" name="performers" value="private"/>
          <div class="link-performers">
            <span class="text_span">Частные</span>
            <span class="number_span" id="count_private_js"><?php echo $count_private;?></span>
          </div>
        </div>
        <?php endif;?>
        <?php if($count_agency > 0):?>
        <div class="item">
          <input type="radio" name="performers" value="agency"/>
          <div class="link-performers">
            <span class="text_span">Агенства</span>
            <span class="number_span" id="count_agency_js"><?php echo $count_agency;?></span>
          </div>
        </div>
        <?php endif;?>
      </div>
      <?php if($spec):?>
      <div class="block-filter">
        <p class="title">Специализация</p>
        <label class="label">
          <select class="spec_select" name="specialization" id="filter_specialization">
            <option value="">Любая</option>
            <?php foreach($spec as $key => $val):?>
            <option value="<?php echo $key;?>"><?php echo $val;?></option>
            <?php endforeach;?>
          </select>
        </label>
      </div>
      <?php endif;?>
      <?php if($prof):?>
      <div class="block-filter profile">
        <p class="title">Профильное направление</p>
        <label class="label">
          <select class="prof_select" name="profile_direction" id="filter_profile_direction">
            <option value="">Любое</option>
            <?php foreach($prof as $key => $val):?>
            <option value="<?php echo $key;?>"><?php echo $val;?></option>
            <?php endforeach;?>
          </select>
        </label>
      </div>
      <?php endif;?>
      <div class="block-filter d-flex" id="fix2-d-flex">
        <input type="radio" class="radio" name="rating" value="1">
				<label class="ml-2"><span>Только высокий рейтинг <br>(4-5 звезд)</span></label>
      </div>
      <div class="block-filter d-flex" id="fix14-d-flex">
				<input type="radio" class="radio" name="rating" value="0" checked>
				<label class="ml-2"><span>Рейтинги не важны</span></label>
			</div>
      <!--
      <div class="text-center">
        <input id="submitid" type="submit" class="btn_forma" value="Найти"/>
        <input type="button" class="btn-reset" value="Сброс"/>
      </div>
      -->
		</div>
	</form>
  </div>
  <?php
}


add_action('wp_ajax_allstars_filter_global', 'allstars_filter_global'); 
add_action('wp_ajax_nopriv_allstars_filter_global', 'allstars_filter_global');

function allstars_filter_global() {
  $meta_query = array();

  if(isset($_POST['filter_city']) && $_POST['filter_city'] != ''){
		$filter_city = $_REQUEST['filter_city'];
    $filter_city_translite = allstars_get_translite_name_city($filter_city);      
  } 

  if(isset($_POST['header_sity']) && $_POST['header_sity'] != ''){
		$header_sity = $_REQUEST['header_sity'];     		
  } 

  if(isset($_POST['cities']) && $_POST['cities'] != ''){
		$cities = $_REQUEST['cities'];    		
  } 

  if (isset($cities)) {
    $city_search = $cities;  
  }

  if (isset($header_sity)) {
    $city_search = $header_sity;  
  }

  if (isset($filter_city_translite)) {
    $city_search = $filter_city_translite;  
  }
  
  if (!empty($city_search)){
    $meta_query[] = array(
      'key' => 'block_right_cities',
      'value' => $city_search,
      'compare' => 'LIKE'                          
    );
  }

  if(isset($_POST['specialization']) && $_POST['specialization'] != ''){
    $specialization_search = $_REQUEST['specialization'];
  } 

  if (!empty($specialization_search)){
    $meta_query[] =  array(
      'key' => 'block_right_specialization',
      'value' => $specialization_search,
      'compare' => 'LIKE'                          
    );
  }

  if(isset($_POST['profile_direction']) && $_POST['profile_direction'] != ''){
    $profile_direction_search = $_REQUEST['profile_direction'];
  } 

  if (!empty( $profile_direction_search)){
    $meta_query[] =  array(
      'key' => 'block_right_profile_direction',
      'value' => $profile_direction_search,
      'compare' => 'LIKE'                          
    );
  }

  if(isset($_POST['rating']) && $_POST['rating'] != ''){
    $rating_search = $_REQUEST['rating'];	
    if('1'== $rating_search){  
      $meta_query[] = array(
        'key' => 'rating_star',
        'value' => 4,
        'type' => 'NUMERIC',
        'compare' => '>='
      );
    }  
  }


  if(isset($_POST['performers']) && $_POST['performers'] != ''){   
    $users_id = array();
    if($_POST['performers'] == 'private'){
      $users_id = get_users( [
        'role__in'   => array('allstars_artist', 'allstars_specialist', 'allstars_group'),
        'fields' => 'ID'
      ] );
      $args['author__in'] = $users_id; 
      
    }elseif($_POST['performers'] == 'agency'){
      $users_id = get_users( [
        'role__in'   => array('allstars_agency'),
        'fields' => 'ID'
      ] );
      $args['author__in'] = $users_id;
    }
  }   
  
  $autors = implode(",", $args['author__in']); 

  if( isset($_POST['specialization']) && $_POST['specialization'] != ''){
    $meta_query[] = array(
      'key' => 'block_right_specialization',
      'value' => $_POST['specialization'],
      'compare' => 'LIKE'
    );           			
  }

  $args = array(
    'post_type' => 'stars',
    'post_status' => 'publish', 
    'author'  => $autors,                              
    'meta_query' =>$meta_query                
);
$ind = 0;	
$query = new WP_Query($args);    
if( $query->have_posts() ){
    while( $query->have_posts() ){            
        $query->the_post();                                              
        $arr_result_fiter[$ind]['star'] = get_fields();                     
        $arr_result_fiter[$ind]['post'] = (array)get_post();            
        $ind++;         
    }       
} else {
  echo "По вашему запросу ничего не найдено. Попробуйте изменить параметры запроса";
}
wp_reset_postdata();

global $sort;
$sort = global_sort($arr_result_fiter);  
get_template_part( 'template-parts/catalog', 'zvezdy');

  die();
}

// Получение названия города из $_COOKIE

function allstars_get_translite_name_city($rus_sity){   
      if ( (isset($rus_sity) ) && (''!=$rus_sity) ){
        $city = array_search($rus_sity,allstars_get_full_cities()); 
      }
      else {
        $city = "all";
      }					
			return $city; 
}

/** 
 * Получение количество агенств и частных артистов
 * для отображения в фильтре
 */


add_action('wp_ajax_allstars_filter_global_quantity', 'allstars_filter_global_quantity'); 
add_action('wp_ajax_nopriv_allstars_filter_global_quantity', 'allstars_filter_global_quantity');

function allstars_filter_global_quantity(){
  $meta_query = array();
  if(isset($_POST['filter_city_quantity']) && $_POST['filter_city_quantity'] != ''){
		$filter_city = $_REQUEST['filter_city_quantity'];
    $filter_city_translite = allstars_get_translite_name_city($filter_city);      
  }   

  if(isset($_POST['header_city_quantity']) && $_POST['header_city_quantity'] != ''){
		$header_city = $_REQUEST['header_city_quantity'];     		
  } 

  if(isset($_POST['cities']) && $_POST['cities'] != ''){
		$cities = $_REQUEST['cities'];    		
  } 

  if (isset($cities)) {
    $city_search = $cities;  
  }

  if (isset($header_sity)) {
    $city_search = $header_city;  
  }

  if (isset($filter_city_translite)) {
    $city_search = $filter_city_translite;  
  }



  if (!empty($city_search)){
    $meta_query[] = array(
      'key' => 'block_right_cities',
      'value' => $city_search,
      'compare' => 'LIKE'                          
    );
  }

  if(isset($_POST['specialization']) && $_POST['specialization'] != ''){
    $specialization_search = $_REQUEST['specialization'];
  } 

  if (!empty($specialization_search)){
    $meta_query[] =  array(
      'key' => 'block_right_specialization',
      'value' => $specialization_search,
      'compare' => 'LIKE'                          
    );
  }

  if(isset($_POST['profile_direction']) && $_POST['profile_direction'] != ''){
    $profile_direction_search = $_REQUEST['profile_direction'];
  } 

  if (!empty( $profile_direction_search)){
    $meta_query[] =  array(
      'key' => 'block_right_profile_direction',
      'value' => $profile_direction_search,
      'compare' => 'LIKE'                          
    );
  }

  if(isset($_POST['rating']) && $_POST['rating'] != ''){
    $rating_search = $_REQUEST['rating'];	
    if('1'== $rating_search){  
      $meta_query[] = array(
        'key' => 'rating_star',
        'value' => 4,
        'type' => 'NUMERIC',
        'compare' => '>='
      );
    }  
  }


  if(isset($_POST['performers']) && $_POST['performers'] != ''){   
    $users_id = array();
    if($_POST['performers'] == 'private'){
      $users_id = get_users( [
        'role__in'   => array('allstars_artist', 'allstars_specialist', 'allstars_group'),
        'fields' => 'ID'
      ] );
      $args['author__in'] = $users_id; 
      
    }elseif($_POST['performers'] == 'agency'){
      $users_id = get_users( [
        'role__in'   => array('allstars_agency'),
        'fields' => 'ID'
      ] );
      $args['author__in'] = $users_id;
    }
  }   
  
  $autors = implode(",", $args['author__in']); 

  if( isset($_POST['specialization']) && $_POST['specialization'] != ''){
    $meta_query[] = array(
      'key' => 'block_right_specialization',
      'value' => $_POST['specialization'],
      'compare' => 'LIKE'
    );           			
  }

  $args = array(
    'post_type' => 'stars',
    'post_status' => 'publish',                                 
    'meta_query' => $meta_query                  
);

$count_frequent = 0;
$count_agency = 0;
$count_all = 0;

$frequent = array('allstars_artist', 'allstars_specialist', 'allstars_group');
$agency = array('allstars_agency');

$query = new WP_Query($args);    
if( $query->have_posts() ){
    while( $query->have_posts() ){            
        $query->the_post();        
        $id = get_post()->post_author;  

        $user_fint = get_user_by( 'id', $id );
        $roles = $user_fint->roles;   

        $frequent_compare = array_intersect($roles,$frequent);
        $agency_compare = array_intersect($roles, $agency);

        if (!empty($frequent_compare)) {
          $count_frequent++;         
        } elseif (!empty($agency_compare)){
          $count_agency++;         
        } 
    }       
} 
wp_reset_postdata();
$count_all = $count_frequent + $count_agency;
$result = compact("count_all", "count_frequent","count_agency");
  echo json_encode($result);
  die();
}
