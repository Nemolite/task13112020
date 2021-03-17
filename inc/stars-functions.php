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
 * Функция вывдит мероприятия на странице афиш (poster)
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
                'type' => 'DATETIME',               
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

            get_template_part( 'template-parts/poster', 'show', $afishaid); 
                
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
    if ( empty($_POST) || ! wp_verify_nonce( $_POST['name_of_nonce_field'], 'name_of_my_action') ){
        print 'Извините, проверочные данные не соответствуют.';
        exit;
     }
     else {     

    // Название мероприятия
    if (isset($_POST['recipient_name'])) { 
        $nameposter = sanitize_text_field($_POST['recipient_name']);        
    }	

    // Ключевое слово
    if (isset($_POST['key_word_afisha'])) { 
        $key_word_afisha = sanitize_text_field($_POST['key_word_afisha']);        
    }	

    // place1 - Offline, place2 - Online 
	if (isset($_POST['gridplace'])) { 
        $gridplace = $_POST['gridplace']; 
        if ('place1'==$gridplace) {
            // Место проведения мероприятия (Offline)
            $nameonoff = true;
            if (isset($_POST['place_name'])) { 
                $nameplace = sanitize_text_field($_POST['place_name']);                 
            }
		} else {
            // Ссылка на сайт мероприятие (Online)
            $nameonoff = false;
            if (isset($_POST['example_url_reg_place'])) { 
                $nameplaceurl = sanitize_text_field($_POST['example_url_reg_place']);                 
            }
        }
    }  

	// Город в котором будет проведено мероприятие  
	if (isset($_POST['exampleSelect1'])) { 
        $namecity = sanitize_text_field($_POST['exampleSelect1']);                 
    }
	// Дата проведения мероприятия
	if (isset($_POST['example_date_input'])) { 
        $namedate = sanitize_text_field($_POST['example_date_input']);                 
    }
	// Время проведения мероприятия
	if (isset($_POST['example_time_input'])) { 
        $nametime = sanitize_text_field($_POST['example_time_input']);                 
    }
	// Объединение даты и времемни для записи в БД
	$event_time = date('Y-m-d H:i:s',strtotime($namedate.' '.$nametime)); 
	
	// Анонс мероприятия
	if (isset($_POST['exampleTextarea'])) { 
        $nameannouncement = sanitize_text_field($_POST['exampleTextarea']);
           	
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
        $nameurl = sanitize_text_field($_POST['example_url_input']);                 
    }

    // URL регистрации на мероприятие
    if (isset($_POST['example_url_reg'])){
        $nameurlreg = sanitize_text_field($_POST['example_url_reg']);
    }
	// ID - Исполнителя
	if (isset($_POST['nameuserid'])) { 
        $nameuserid = $_POST['nameuserid'];                     
    }  
    
     // применяем функцию поиска хеш-тега, по мероприятиям
     $check = allstars_shearch_key_word_afisha($key_word_afisha);
    
     if ( false == $check ) { 
	
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
    update_post_meta( $post_id, 'key_word_afisha', $key_word_afisha ); // Ключевое слово, хештег
    update_post_meta( $post_id, 'on_off', $nameonoff ); // Online/Ofline
    update_post_meta( $post_id, 'posplace', $nameplace ); // Место проведения мероприятия    
    update_post_meta( $post_id, 'url_online', $nameplaceurl ); // Ссылка на сайт online мероприятия 
    update_post_meta( $post_id, 'poscity', $namecity ); // город в котором будет проведено мероприятие
    update_post_meta( $post_id, 'postsale', $nameradiopied ); // Переключатель платное/бесплатное	
    update_post_meta( $post_id, 'postsaleurl', $nameurl ); // Ссылка на официальный сайт
    update_post_meta( $post_id,'nameurlreg', $nameurlreg ); // Ссылка на сайт регистрации мероприятия
    update_post_meta( $post_id, 'ticketprice', $namepied ); // Стоимость билета
    update_post_meta( $post_id, 'postdate', $event_time ); // Дата и Время 

    // Загрузка файла анонса

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $attachment_id = media_handle_upload( 'exampleInputFile', $post_id );
    set_post_thumbnail( $post_id, $attachment_id );    

    // Добавление (Приваязка) заезды к данному мероприятию

    $arr_userid = array(
        'id_star' => $nameuserid
    );
    
    add_row( 'star_user_id', $arr_userid, $post_id );          

    }
    else     
    {   
        // Если такое мероприятие с таким же хеш тегом найдено,            
        // Добавляем ID звезды при этом мероприятие не создаеться

        $arr_userid = array(
            'id_star' => $nameuserid
        );
        $other_post_id = (int)$check;
        add_row( 'star_user_id', $arr_userid, $other_post_id );  
       
      
    }
    exit;
    }  
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

add_action('allstars_single_stars_afisha_show','allstar_poster_show_single', 40, 1);
function allstar_poster_show_single( $starsid ){       
              
    $args = array(
        'suppress_filters' => true,
        'post_type' => 'afisha',                   
        'order' => 'ASC',
		'orderby' => 'meta_value',        
        'posts_per_page' => -1,              
        'meta_query' => array(
            array(
                'key' => 'postdate',
                'value' => date( 'Y-m-d H:i:s', strtotime(' 30 days ') ),
                'compare' => '<=',
                'type' => 'DATETIME',               
            ),
            array(
                'key'           => 'postdate',                
                'value'         =>  date('Y-m-d H:i:s'),
                'compare'       => '>=',
                'type'          => 'DATETIME',
            ),     
         
        )                   
    );     
    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();                               
            
            $check = apply_filters( 'filter_on_filed_repeater', get_the_ID() , $starsid );
        
           if (!empty($check)) { 
                                
           get_template_part( 'template-parts/singlestars', 'afisha');
            
           } 
 
        }       
    }
    wp_reset_postdata();
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
    
    if ( ( isset($_POST['posterdate'] ) ) && ( $_POST['posterdate'] != '') ){
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
    } else {
        $arr_mq_date_prv =   array(
            'key' => 'postdate',
            'value' => date( 'Y-m-d H:i:s', strtotime(' 30 days ') ),
            'compare' => '<=',
            'type' => 'DATETIME',               
        );
        $arr_mq_date_nxt =  array(
            'key'           => 'postdate',                
            'value'         =>  date('Y-m-d H:i:s'),
            'compare'       => '>=',
            'type'          => 'DATETIME',
        );

    }
    
    // фильтр по городу 
    
    if(isset($_POST['city_header_new']) && $_POST['city_header_new'] != ''){
        $city_header_new = $_REQUEST['city_header_new']; 
       
        $filter_city_new_translite = allstars_get_translite_name_city($city_header_new);
         		
    }    


    if(isset($_POST['postercity']) && $_POST['postercity'] != ''){
        $postercity = $_REQUEST['postercity'];    		
    }    
  
    if(isset($_POST['header_sity']) && $_POST['header_sity'] != ''){
        $header_sity = $_REQUEST['header_sity'];    		
    }    
   
    if (isset($postercity)) {        
        $arr_mq_city = array(
            'key'           => 'poscity',                
            'value'         => $postercity,
            'compare'       => '=',                              
        );
    } else {
        $arr_mq_city = array(
            'key'           => 'poscity',                
            'value'         => $header_sity,
            'compare'       => '=',                              
        );
    } 
    
    if ( !isset($postercity) && ( !isset($header_sity ) ) ) {
        $arr_mq_city = array(
            'key'           => 'poscity',                
            'value'         => $filter_city_new_translite,
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
    if (isset($_POST['posterperformer'])&& $_POST['posterperformer'] != ''){        
        $posterperformerid = $_POST['posterperformer'];
        $params = array(
            'role' => $posterperformerid,      
          );
        $uq = new WP_User_Query( $params );  
        
          foreach ( $uq->results as $u ) {           
            $arr_author_id[] = $u->ID;
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
            $arr_mq_on_off                                   
        ),         
    );
    
    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();
            $afishaid = get_the_id();          
                                                 
            get_template_part( 'template-parts/poster', 'show',$afishaid);
                     
        }       
    }
    wp_reset_postdata();    
    wp_die();
}

/**
 *  Подсчет количество мероприятий у артиста
 */

add_filter( 'count_afisha_star', 'allatars_count_afisha_star', 30, 1 );
function allatars_count_afisha_star( $starsid ){
    $conut=0;
    $args = array(
        'post_type' => 'afisha',                      
        'order' => 'ASC',
		'orderby' => 'meta_value',        
        'posts_per_page' => -1,              
        'meta_query' => array(
            array(
                'key' => 'postdate',
                'value' => date( 'Y-m-d H:i:s', strtotime(' 30 days ') ),
                'compare' => '<=',
                'type' => 'DATETIME',               
            ),
            array(
                'key'           => 'postdate',                
                'value'         =>  date('Y-m-d H:i:s'),
                'compare'       => '>=',
                'type'          => 'DATETIME',
            ),
          
        )                   
    );   

    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();

            $check = apply_filters( 'filter_on_filed_repeater', get_the_ID() , $starsid );
                    
           if ($check) {
            $conut++; 
           }
   
        }       
    }
    wp_reset_postdata();
    
	return $conut;
}

/**
 *  Поиск в афише по ключевому слову
 * @param $key_word_afisha хештег
 *  @return false - если мероприятие по хештегу не найдено
 *          id - мероприятия
 */

function allstars_shearch_key_word_afisha($key_word_afisha){
    $args = array(
            'post_type' => 'afisha',                   
            'order' => 'ASC',
            'orderby' => 'meta_value',        
            'posts_per_page' => -1,       
            'meta_query' => array(
                array(
                    'key' => 'key_word_afisha',
                    'value' => $key_word_afisha,
                    'compare' => '=',
                    'type' => 'CHAR',               
                ),
                array(
                    'key' => 'postdate',
                    'value' => date( 'Y-m-d H:i:s', strtotime(' 30 days ') ),
                    'compare' => '<=',
                    'type' => 'DATETIME',               
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
        $count = 0;	
        if( $query->have_posts() ){
            while( $query->have_posts() ){		
                $query->the_post();                            
                $count++;
                if($count>0) {
                    return get_the_ID();
                    break;			
                } 			
            }       
        }
        wp_reset_postdata();
        return false;
    }

/**
 * Функция извлечения массива артистов прикрепленных
 * к данному мероприятию
 *  @param numeric $afisha_id
 * 
 * @return array
 * */

add_filter( 'get_array_stars', 'allatars_get_array_stars',30,1 );
function allatars_get_array_stars( $afisha_id ){
    $arr_star_id_full = get_field( 'star_user_id', $afisha_id);
    $arr_star_id = array();   
    foreach ($arr_star_id_full as $value){ 
        foreach ($value as $star_id){        
            array_push($arr_star_id, $star_id);
        }
    }   
    
    $args = array(
        'post_type' => 'stars', 
        'post__in' =>  $arr_star_id,              
                
    );   
    $counter = 0; 
    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();      
              ?>    
        <div class="poster__circle">
        <a href="<?php echo get_permalink();?>" class="poster_redirect">
          <img 
          title="<?php echo get_the_title();?>" 
          src="<?php 
          $tmp_arr_stars = get_field('block_left');
          echo $tmp_arr_stars['main_img']['url'];
            ?>" alt="<?php echo get_the_title(); ?>" /> 
        </a>                                    
        </div>
        <?php 
         $counter++;               
        }       
        if(1==$counter)  {?>
        <a href="<?php echo get_permalink();?>" class="poster_redirect">
        <h6><?php echo get_the_title(); ?></h6>
        </a>    
          
        <?php } 
    }
    wp_reset_postdata();	
}

/** 
 * Фильтр по полю репитера
 */

// apply_filters( 'filter_on_filed_repeater', $afisha_id );
add_filter( 'filter_on_filed_repeater', 'allatars_filter_on_filed_repeater',30,2 );
function allatars_filter_on_filed_repeater( $afisha_id, $starsid ){
    $arr_result = array();
    $i=0;
    if( have_rows('star_user_id', $afisha_id) ):

        while( have_rows('star_user_id', $afisha_id) ) : the_row();
            
            $value = get_sub_field('id_star');    
            
            $arr_result[$i] = $value;
            $i++;
            
        endwhile;
    
    endif;


    if (in_array($starsid, $arr_result)) {
        $result = true;
    } else {
        $result = false; 
    }
   
    return   $result;

}

/**
 * Функция извлечения количества артистов прикрепленных
 * к данному мероприятию
 *  @param numeric $afisha_id
 * 
 * @return numeric count
 * */

add_filter( 'get_array_stars_full', 'allatars_get_array_stars_full',30,1 );
function allatars_get_array_stars_full( $afisha_id ){
    $arr_star_id_full = get_field( 'star_user_id', $afisha_id);
    $arr_star_id = array();   
    foreach ($arr_star_id_full as $value){ 
        foreach ($value as $star_id){        
            array_push($arr_star_id, $star_id);
        }
    }   
    
    $args = array(
        'post_type' => 'stars', 
        'post__in' =>  $arr_star_id,              
                
    );   
    $counter = 0;

    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();      
            $counter++;    
        }       
    }
    wp_reset_postdata();
    return $counter;	
}

/**
 * Функция получения общего количества мероприятия 
 *  
 * @param void 
 *  
 * @return numeric
 */
add_filter('allstars_poster_full_count','get_count_afisha', 30,1); 
function get_count_afisha( ){     
    $args = array(
        'post_type' => 'afisha',                   
        'order' => 'ASC',
		'orderby' => 'meta_value',        
        'posts_per_page' => -1,       
        'meta_query' => array(
            array(
                'key' => 'postdate',
                'value' => date( 'Y-m-d H:i:s', strtotime(' 30 days ') ),
                'compare' => '<=',
                'type' => 'DATETIME',               
            ),
            array(
                'key'           => 'postdate',                
                'value'         =>  date('Y-m-d H:i:s'),
                'compare'       => '>=',
                'type'          => 'DATETIME',
            )
        )                   
    );
    $count = 0;
    $query = new WP_Query($args);    
    if( $query->have_posts() ){
        while( $query->have_posts() ){            
            $query->the_post();                             
                  

            $count++;
                
        }       
    }
    return $count;
    wp_reset_postdata();
    
}

// Перенесено ----- start

add_action('acf/save_post', 'allstars_acf_save_post_crop_img', 10, 1);
function allstars_acf_save_post_crop_img($post_id){
  if(isset($GLOBALS['acf_form'])){
    $args = $GLOBALS['acf_form'];
    if(isset($_POST['acf_image_promo_crop_new'])){
      session_start();
      $_SESSION['acf-promo-crop'] = 'true';
      //$args['return'] = add_query_arg( 'acf-promo-crop', 'true', $args['return']);
    }    
    $GLOBALS['acf_form'] = $args;
  }  
}

function allstars_js_css_crop_img(){
  session_start();
  if( is_page('lk') && $_SESSION && isset($_SESSION['acf-promo-crop'])){
    wp_enqueue_script( 'callcrop', get_template_directory_uri() . '/assets/js/callcrop.js', array(), filemtime(get_stylesheet_directory() . '/assets/js/callcrop.js' ) );
    unset($_SESSION['acf-promo-crop']);
  }
}
add_action( 'wp_enqueue_scripts', 'allstars_js_css_crop_img' );

// Перенесено ----- end