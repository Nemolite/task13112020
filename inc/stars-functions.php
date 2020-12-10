<?php
/**
 * Функция создает массив 
 * из стандартных и произвольных полей постов "Звезды"  
 * 
 * @return $arr_result
 */
function universal() {
    $args = array(
        'post_type' => 'stars',
        'nopaging' => true
    );
    $arr_result = array();
    $index = 0;       
    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();                        
            $arr_result[$index]['star'] = get_fields();                     
            $arr_result[$index]['post'] = (array)get_post();            
            $index++;            
        }       
    }
    wp_reset_postdata();
    return $arr_result;
}  
/**
 * Функция получает массив и сортирует его следующим образом
 * 2 pro артиста всегда будут 2 -ух верхних позициях
 *  
 *
 * @param [type] $array
 * @return $array_result
 */
function global_sort( $array ) {
    $array_sort = array();
    $plain      = array();
    $pro        = array();
    $tmp_array  = array();    
    if ( isset( $array ) && $array != '') {
        // Отбрасываем не подтвержденных
        for($i = 0; $i <= count( $array ); $i++){
            if ( true == $array[$i]['star']['is_confirmation'] ) {                
                array_push( $tmp_array, $array[$i] );
            }
        }
        // Разделим массив на 2 части (про и простой)
        for ($i = 0; $i <= count( $tmp_array ); $i++) {
            if ( true == $array[$i]['star']['is_top']) {                
                array_push( $pro, $array[$i] );
            } else {                
                array_push( $plain, $array[$i] );
            }
        }
        $coefficient = 0;
        $n = 0;
        $m = 0;
        $step = 0;
        for ($j = 0; $j <= count( $array ); $j++) {
            if ( ( $coefficient === $j ) ) {
                array_push( $array_sort, $pro[$n] );
                $n++;
                $step++;
                $coefficient++;                
                if ( 2 == $step ) {
                    $coefficient = $coefficient + 8;
                    $step = 0;
                }
            } else {
                array_push( $array_sort, $plain[$m] );
                $m++;
            }            
        }
    }    
    $new_array = array_diff($array_sort, array(''));
    $array_result = array_values($new_array);    
    return $array_result;    
}

// Poster
function allstars_afisha(){
    $labels = array(
		'name' => 'Мероприятия',
		'singular_name' => 'Мероприятие', 
		'add_new' => 'Добавить мероприятие',
		'add_new_item' => 'Добавить новое мероприятие', 
		'edit_item' => 'Редактировать мероприятие',
		'new_item' => 'Новое мероприятие',
		'all_items' => 'Все мероприятии',
		'view_item' => 'Просмотр мероприятий на сайте',
		'search_items' => 'Искать мероприятию',
		'not_found' =>  'Мероприятие не найдено.',
		'not_found_in_trash' => 'В корзине нет мероприятий',
		'menu_name' => 'Мероприятия' 
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true, 
		'has_archive' => true, 
		'menu_icon' => 'dashicons-calendar-alt', 
		'menu_position' => 20, 
		'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail')
	);
	register_post_type('afisha', $args);

}
add_action('init', 'allstars_afisha');

/**
 * Функция вывдит мероприятия на странице афишф (poster)
 * 
 * @param numeric $count - количество постов для вывода
 * @param numeric $offset - cколько постов пропустить
 *  
 * @return template
 */
add_action('allstras_poster_form_before','get_fileds_afisha', 30, 2); 
function get_fileds_afisha( $conut, $offset ){     
    $args = array(
        'post_type' => 'afisha',                   
        'order' => 'ASC',
		'orderby' => 'meta_value',
        'offset'=> $offset,
        'posts_per_page' => $conut,       
        'meta_query' => array(
            array(
                'key' => 'postdate',
                'value' => date( 'Y-m-d H:i:s', strtotime(' 30 days ') ),
                'compare' => '<=',
                'taype' => 'DATETIME',               
            ),
            array(
                'key'           => 'postdate',                
                'value'         =>  date('Y-m-d H:i:s'),
                'compare'       => '>=',
                'type'          => 'DATETIME',
            )
        )                   
    );
    $query = new WP_Query($args);    
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();                                   
            $afishaid = get_the_id();            
            $star_id = get_post_meta( $afishaid, '_staruserid',true ); // Получаем ID звезды из скрытого поля 
            
            $posts = get_posts( 
                array(
                    'p' =>  $star_id,                   
                    'post_type'   => 'stars',
                    'meta_key'    => '',
	                'meta_value'  =>'',
                    'suppress_filters' => true, 
                )
            );            

            foreach($posts as $post){               
                $intemplate = (array)$post;
            } 

            get_template_part( 'template-parts/poster', 'show', $intemplate); 
            
            wp_reset_postdata();
                               
        }       
    }
    wp_reset_postdata();
}

/**
 * The Hook for poster a page. 
 * Adding 3 postes in the table afisha
 * Function allstars_adding_afisha_count
 * 
 * Добавление еще 3 карточек в афишу по нажатию 
 * на кнопку "Показать еще"
 * 
 * @return void
 */

add_action('wp_ajax_adding_afisha', 'allstars_adding_afisha_count'); 
add_action('wp_ajax_nopriv_adding_afisha', 'allstars_adding_afisha_count');
function allstars_adding_afisha_count(){        
    if (isset($_POST['addcount'])) { 
        $offset = $_POST['offset'];
        $count = $_POST['addcount'];
     do_action('allstras_poster_form_before', $count, $offset);                  
     }
    exit;
}

/**
 * The Hook for page-lk a page. 
 * Update  in the Database postes afisha (poster)_
 * Function allstars_create_afisha
 *
 * Создание нового мероприятия  
 * 
 * @return void
 */

add_action('wp_ajax_modal_afisha', 'allstars_create_afisha'); 
add_action('wp_ajax_nopriv_modal_afisha', 'allstars_create_afisha');
function allstars_create_afisha(){     

    // Название мероприятия
    if (isset($_POST['recipient_name'])) { 
        $nameposter = $_POST['recipient_name'];        
    }	

    // place1 - Offline, place2 - Online 
	if (isset($_POST['gridplace'])) { 
        $gridplace = $_POST['gridplace']; 
        if ('place1'==$gridplace) {
            // Место проведения мероприятия (Offline)
            $nameonoff = true;
            if (isset($_POST['place_name'])) { 
                $nameplace = $_POST['place_name'];                 
            }
		} else {
            // Ссылка на сайт мероприятие (Online)
            $nameonoff = false;
            if (isset($_POST['example_url_reg_place'])) { 
                $nameplaceurl = $_POST['example_url_reg_place'];                 
            }
        }
    }  

	// Город в котором будет проведено мероприятие  
	if (isset($_POST['exampleSelect1'])) { 
        $namecity = $_POST['exampleSelect1'];                 
    }
	// Дата проведения мероприятия
	if (isset($_POST['example_date_input'])) { 
        $namedate = $_POST['example_date_input'];                 
    }
	// Время проведения мероприятия
	if (isset($_POST['example_time_input'])) { 
        $nametime = $_POST['example_time_input'];                 
    }
	// Объединение даты и времемни для записи в БД
	$event_etime = date('Y-m-d h:i:s',strtotime($namedate.' '.$nametime)); 
	
	// Анонс мероприятия
	if (isset($_POST['exampleTextarea'])) { 
        $nameannouncement = $_POST['exampleTextarea'];
           	
    }	
	
	// option1 - бесплатное, option2 - платное 
	if (isset($_POST['gridRadios'])) { 
        $nameradiopied = $_POST['gridRadios']; 
        if ('option1'==$nameradiopied) {
			$nameradiopied = false;
		}else{
			$nameradiopied = true;
		}		      
    }

    	// Стоимость мероприятия
	if (isset($_POST['example_number_input'])) { 
        $namepied = $_POST['example_number_input'];                 
    }
	
	// URL адрес мероприятия
	if (isset($_POST['example_url_input'])) { 
        $nameurl = $_POST['example_url_input'];                 
    }

    // URL регистрации на мероприятие
    if (isset($_POST['example_url_reg'])){
        $nameurlreg = $_POST['example_url_reg'];
    }
	// ID - Исполнителя
	if (isset($_POST['nameuserid'])) { 
        $nameuserid = $_POST['nameuserid'];                     
    }    
	
	// Заполнение стандартных полей произвольных записей (Мероприятия)
	if ( !isset( $post_id ) ) { 
		$post_id = wp_insert_post(array(
			'post_title'=>$nameposter,  // Название мероприятия
			'post_type'=>'afisha',
			'post_status' => 'publish',			
			'post_content'=>$nameannouncement  // Анонс мероприятия
		));
	}
	
	// Заполнение произвольных полей (Афиша) произвольных записей (Мероприятия)
    update_post_meta( $post_id, 'poster', $nameposter ); // Назавание мероприятия
    update_post_meta( $post_id, 'on_off', $nameonoff ); // Online/Ofline
    update_post_meta( $post_id, 'posplace', $nameplace ); // Место проведения мероприятия    
    update_post_meta( $post_id, 'url_online', $nameplaceurl ); // Ссылка на сайт online мероприятия 
    update_post_meta( $post_id, 'poscity', $namecity ); // город в котором будет проведено мероприятие
    update_post_meta( $post_id, 'postsale', $nameradiopied ); // Переключатель платное/бесплатное	
    update_post_meta( $post_id, 'postsaleurl', $nameurl ); // Ссылка на официальный сайт
    update_post_meta( $post_id,'nameurlreg', $$nameurlreg ); // Ссылка на сайт регистрации мероприятия
    update_post_meta( $post_id, 'ticketprice', $namepied ); // Стоимость билета
    update_post_meta( $post_id, 'postdate', $event_etime ); // Дата и Время 

    update_post_meta( $post_id, '_staruserid', $nameuserid ); // ID звезды в скрытое поле 
    
    // Загрузка файла анонса

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $attachment_id = media_handle_upload( 'exampleInputFile', $post_id );
    set_post_thumbnail( $post_id, $attachment_id );    
   
    exit;
}

/**
* Получение списка users
*
*/

function allstars_get_users_accunt(){
	global $wpdb;	
	$new_array = array();  
	$table_name = $wpdb->prefix . "users";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
			$stars = $wpdb->get_results("SELECT id, display_name FROM $table_name");
				if($stars){
					foreach($stars as $star){
					$new_array[$star->id] = $star->display_name;
					}
				}
		}
	return $new_array;
}

/**
* Получение списка исполнителей (из раздела stars)
*
*/

function allstars_get_full_stars_for_afisha(){
    $result_array = array();
    $args = array(
        'post_type' => 'stars',
        'posts_per_page' => -1,                               
               
    );
    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();    
            $result_array[get_the_ID()] = get_the_title();         
        }       
    }
    wp_reset_postdata();	
	return $result_array;
}



/**
 *  Вывод мароприятий на странице и в личном кабинете артиста
 * 
 */

add_action('allstars_single_stars_afisha_show','allstar_poster_show_single', 40, 2);
function allstar_poster_show_single( $conut, $offset){
    
    $starsid = get_the_ID();      

    if( is_page( 'lk' ) ){        
        $args = array(
            'post_type' => 'stars',
            'author' => get_current_user_id(),                        
        );
        $post = get_posts($args);        
        setup_postdata($post);        
        foreach( $post as $p ){ 
            $starsid = $p->ID;            
        }
        wp_reset_postdata(); 
   }
              
    $args = array(
        'post_type' => 'afisha',                   
        'order' => 'ASC',
		'orderby' => 'meta_value',
        'offset'=> $offset,
        'posts_per_page' => $conut,              
        'meta_query' => array(
            array(
                'key' => 'postdate',
                'value' => date( 'Y-m-d H:i:s', strtotime(' 30 days ') ),
                'compare' => '<=',
                'taype' => 'DATETIME',               
            ),
            array(
                'key'           => 'postdate',                
                'value'         =>  date('Y-m-d H:i:s'),
                'compare'       => '>=',
                'type'          => 'DATETIME',
            ),
            array(
                'key'     => '_staruserid',
                'value'   => $starsid,
                'compare' => '=',
                'type'    => 'NUMERIC', // по умолчанию 'CHAR'
            ),
        )                   
    );   

    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();                                    
            get_template_part( 'template-parts/singlestars', 'afisha');           
        }       
    }
    wp_reset_postdata();
} 

/**
 *  Добавление одного мероприятия в раздел артиста
 *  
 */ 
 add_action('wp_ajax_show_afisha_star', 'show_afisha_star_count'); 
 add_action('wp_ajax_nopriv_show_afisha_star', 'show_afisha_star_count');
 function show_afisha_star_count(){        
     if (isset($_POST['showcount'])) { 
         $offset = $_POST['offset'];
         $count = $_POST['showcount'];
      do_action('allstars_single_stars_afisha_show', $count, $offset);                  
      }
     exit;
 }

/**
 * Функция получает ID артиста 
 */

function allstars_get_id_stars( $autorid ){    
    $args = array(
        'post_type' => 'stars',
        'author__in' => $autorid,                        
    );
    $post = get_posts($args);
    setup_postdata($post);    
    foreach( $post as $p ){ 
        $result = $p->ID;
    }
    wp_reset_postdata();
    return $result;       	
}
/**
 * 
 * Функция для получения данных услуг
 */

add_action('allstars_modal_servises','set_data_vodal_servises',30,1);
$arr_result = array();
function set_data_vodal_servises($starid) {
    if( have_rows('servises',$starid) ):
        $idx=1;
        while ( have_rows('servises',$starid) ) : the_row();
        $arr_result[$idx]['servis'] = get_sub_field('servis',$starid);
        $arr_result[$idx]['peid_servis'] = get_sub_field('peid_servis',$starid);             
            $idx++;
        endwhile;
    else :
        $arr_result = array();
    endif;
        return $arr_result;
}

/**
 * Комплексный фильтр для выбора 4 параметрам
 * дата, города, формат мероприятия, исполнитель
 */

add_action('wp_ajax_afisha_super_filter', 'allstars_afisha_super_filter'); 
add_action('wp_ajax_nopriv_afisha_super_filter', 'allstars_afisha_super_filter');
function allstars_afisha_super_filter(){   
    // фильтр по дате 
    if (isset($_POST['posterdate'])){
        $posterdate = $_POST['posterdate'];
        $date = $posterdate;
        $datetime = new DateTime($date);
        $datetime->modify('+1 day');
        $date_nxt = $datetime->format('Y-m-d');    
        $datetime->modify('-1 day');
        $date_prv = $datetime->format('Y-m-d');

        $arr_mq_date_prv =  array(
            'key'           => 'postdate',                
            'value'         => $date_prv,
            'compare'       => '>',
            'type'          => 'DATETIME',              
        );
        $arr_mq_date_nxt = array(
            'key'           => 'postdate',                
            'value'         => $date_nxt,
            'compare'       => '<',
            'type'          => 'DATETIME',              
        );
    } 
    
    // фильтр по городу 
    
    if (isset($_POST['postercity'])){
        $postercity = $_POST['postercity'];
        $arr_mq_city = array(
            'key'           => 'poscity',                
            'value'         => $postercity,
            'compare'       => '=',                              
        );
    }

    // Фильтр по формату выступления

    if (isset($_POST['posteroffon'])){
        $tmp_posteroffon = $_POST['posteroffon'];
        if('Online'== $tmp_posteroffon) {
            $posteroffon = false;
        } else {
            $posteroffon = true;
        };
        $arr_mq_on_off =  array(
            'key'           => 'on_off',                
            'value'         => $posteroffon,
            'compare'       => '=',                              
        );
    } 

    // Фильтр по исполнителю

    $arr_author_id = array();    
    if (isset($_POST['posterperformerid'])){
        $posterperformerid = $_POST['posterperformerid'];
        $params = array(
            'role' => $posterperformerid,      
          );
        $uq = new WP_User_Query( $params );      
          foreach ( $uq->results as $u ) {
            array_push($arr_author_id, $u->ID);
        }    
        wp_reset_postdata();                
    }    
    $args = array(
        'post_type' => 'afisha',
        'author__in' => $arr_author_id,
        'order' => 'ASC',
		'orderby' => 'meta_value',
        'offset'=> $offset,
        'posts_per_page' => $conut,
        'meta_query' => array(
            'relation' => 'AND',
            $arr_mq_date_prv,           
            $arr_mq_date_nxt,
            $arr_mq_city,
            $arr_mq_on_off,
            array(
                'key' => 'postdate',
                'value' => date( 'Y-m-d H:i:s', strtotime(' 30 days ') ),
                'compare' => '<=',
                'taype' => 'DATETIME',               
            ),
            array(
                'key'           => 'postdate',                
                'value'         =>  date('Y-m-d H:i:s'),
                'compare'       => '>=',
                'type'          => 'DATETIME',
            )                          
        ),         
    );
    
    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();
            $afishaid = get_the_id();                       
            $star_id = get_post_meta( $afishaid, '_staruserid',true ); // Получаем ID звезды из скрытого поля            
            $posts = get_posts( 
                array(
                    'p' =>  $star_id,                   
                    'post_type'   => 'stars',
                    'meta_key'    => '',
	                'meta_value'  =>'',
                    'suppress_filters' => true, 
                )
            );         
            foreach($posts as $post){               
                $intemplate = (array)$post;
            }                                     
            get_template_part( 'template-parts/poster', 'show',$intemplate);
            wp_reset_postdata();           
        }       
    }
    wp_reset_postdata();    
    wp_die();
}

