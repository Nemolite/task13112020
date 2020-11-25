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
 * @return void
 */

add_action('wp_ajax_modal_afisha', 'allstars_create_afisha'); 
add_action('wp_ajax_nopriv_modal_afisha', 'allstars_create_afisha');
function allstars_create_afisha(){        
    if (isset($_POST['nameposter'])) { 
        $nameposter = $_POST['nameposter'];
        echo $nameposter;    	
    }
	 
	if (isset($_POST['nameplace'])) { 
        $nameplace = $_POST['nameplace'];                 
    }
	 
	if (isset($_POST['namecity'])) { 
        $namecity = $_POST['namecity'];                 
    }
	
	if (isset($_POST['namedate'])) { 
        $namedate = $_POST['namedate'];                 
    }
	
	if (isset($_POST['nametime'])) { 
        $nametime = $_POST['nametime'];                 
    }
	
	if (isset($_POST['namefile'])) { 
        $namefile = $_POST['namefile'];                 
    }
	
	if (isset($_POST['namepied'])) { 
        $namepied = $_POST['namepied'];                 
    }
	
	if (isset($_POST['nameradiopied'])) { 
        $nameradiopied = $_POST['nameradiopied'];                 
    }
	
	if (isset($_POST['nameurl'])) { 
        $nameurl = $_POST['nameurl'];                 
    }
	
	if (isset($_POST['nameuserid'])) { 
        $nameuserid = $_POST['nameuserid'];                 
    }
	
		
	
    exit;
}
?>
