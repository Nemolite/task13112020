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
 * Функция получает массив и сортирует его следующимобразом
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
 * The Hook for poster a page. Show dates of the table afisha
 * Function get_fileds_afisha
 * @param numeric $count
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
        )                   
    );
    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();                                    
            get_template_part( 'template-parts/poster', 'show');           
        }       
    }
    wp_reset_postdata();
}

/**
 * The Hook for poster a page. 
 * Adding 3 postes in the table afisha
 * Function allstars_adding_afisha_count
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
    if (isset($_POST['nameposter'])) { 
        $nameposter = $_POST['nameposter'];
        echo $nameposter;    	
    }	
	// Место проведения мероприятия 
	if (isset($_POST['nameplace'])) { 
        $nameplace = $_POST['nameplace'];                 
    }
	// Город в котором будет проведено мероприятие  
	if (isset($_POST['namecity'])) { 
        $namecity = $_POST['namecity'];                 
    }
	// Дата проведения мероприятия
	if (isset($_POST['namedate'])) { 
        $namedate = $_POST['namedate'];                 
    }
	// Время проведения мероприятия
	if (isset($_POST['nametime'])) { 
        $nametime = $_POST['nametime'];                 
    }
	// Объединение даты и времемни для записи в БД
	$event_etime = date('Y-m-d h:i:s',strtotime($namedate.' '.$nametime)); 
	
	// Анонс мероприятия
	if (isset($_POST['nameannouncement'])) { 
        $nameannouncement = $_POST['nameannouncement'];
        echo $nameannouncement;    	
    }	
	
	// Загрузка файла анонса мероприятия
	if (isset($_POST['namepied'])) { 
        $namepied = $_POST['namepied'];                 
    }
	
	// option1 - бесплатное, option2 - платное 
	if (isset($_POST['nameradiopied'])) { 
        $nameradiopied = $_POST['nameradiopied']; 
        if ('option1'==$nameradiopied) {
			$nameradiopied = false;
		}else{
			$nameradiopied = true;
		}		      
    }
	
	// URL адрес мероприятия
	if (isset($_POST['nameurl'])) { 
        $nameurl = $_POST['nameurl'];                 
    }
	// ID - ???
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

    // Загрузка файла изображения мероприятия
	if( wp_verify_nonce( $_POST['fileup_nonce'], 'exampleInputFile' ) ){
		
		if ( ! function_exists( 'wp_handle_upload' ) ) 
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		
        $file = & $_FILES['exampleInputFile'];

		$overrides = [ 'test_form' => false ]; // убрать тестирование

		$movefile = wp_handle_upload( $file, $overrides );		
		
	
		$filename = basename($movefile['file']);
		$parent_post_id = $post_id;
		$filetype = wp_check_filetype( basename( $filename ), null );
	
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );
	}
	
	
	// Заполнение произвольных полей (Афиша) произвольных записей (Мероприятия)
    update_post_meta( $post_id, 'poster', $nameposter ); // Назавание мероприятия
	update_post_meta( $post_id, 'posplace', $nameplace ); // Место проведения мероприятия
    
    update_post_meta( $post_id, 'postsale', $nameradiopied ); // Переключатель платное/бесплатное	
	update_post_meta( $post_id, 'postsaleurl', $nameurl ); // Ссылка на официальный сайт
    update_post_meta( $post_id, 'ticketprice', $namepied ); // Стоимость билета
    update_post_meta( $post_id, 'postdate', $event_etime ); // Дата и Время
	
    exit;
}

/**
* Получение полного списка исполнителей из базы данных
*
*/

function allstars_get_full_stars_for_afisha(){
	global $wpdb;	
	$new_array = array();  
	$table_name = $wpdb->prefix . "users";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
			$stars = $wpdb->get_results("SELECT display_name FROM $table_name");
				if($stars){
					foreach($stars as $star){
					$new_array[$star->display_name] = $star->display_name;
					}
				}
		}
	return $new_array;
}
?>
