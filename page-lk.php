<?php 
/* 
  Template Name: Личный кабинет
 */ 
//access_reg();
if ( !is_user_logged_in() ){
  get_header(); ?>
 
  <!-- Проверяем авторизацию при входе в личный кабинет 
  Если нет авторизации , то предлагаем различные варианты  -->
  <div class="container">	
    <?php if(isset($_GET['registered'])){ echo '<div class="message">'.__('Проверьте почту, Вам было отправлено письмо с учетными данными для входа.', 'allstars').'</div>';}?>
     <?php if(isset($_GET['errno']) && $_GET['errno'] == 'confirm'){ echo '<div class="message">'.__('Проверьте почту, Вам было отправлено письмо со ссылкой для сброса пароля.', 'allstars').'</div>';}?>
    <div class="row justify-content-center">
      <div class="col-12 col-md-6 mb-4 mt-4">
        <div class="form-login">      
          <?php allstars_form_login();?>
        </div>
      </div>
    </div>    
  </div>
<?php get_footer();
}else{
	// Если авторзован, определяем роли
  $post_id = get_the_author_meta( 'user_post_id', get_current_user_id() );
  // функция определяет к какому типу относиться пользователь
  $role_user = allstars_get_role_user();
  // если артист, то одни стили
  $css_main = 'person';
  if($role_user == 'allstars_group'){
	  // если группа, то другие стили
    $css_main = 'group';
  }
  if($role_user == 'allstars_agency'){
	   // если агенство, то тоже другие стили
    $css_main = 'agency';
  }
  // Подготовка полей формы
  function allstars_acf_prepare_field($field){
    global $role_user;
    $allstats_role = $role_user;
	// скрытые поля 
    $array_hide = array(
      'allstars_artist' => array(
        'field_5f0da80d008ac', //Дата начала рабочей практики
        'field_5f0da821008ad', //График работы
        'field_5f0da8ae008af', //год основания
        'field_5f0da98e008b0', //юрлицо
        'field_5f0dad0b008b4', //Оплата услуг
        'field_5f0daf7a008bc', //ИНН
      ),
	  // скрытые поля для отправки группы
      'allstars_group' => array(
        'field_5f0da6c5008aa', //дата рождения
        'field_5f0da80d008ac', //Дата начала рабочей практики
        'field_5f0da821008ad', //График работы
        'field_5f0da844008ae', //рост
        'field_5f0da8ae008af', //год основания
        'field_5f0da98e008b0', //юрлицо
        'field_5f0dad0b008b4', //Оплата услуг
        'field_5f0daf7a008bc', //ИНН
      ),
	  // скрытые поля для отправки специалиста 
      'allstars_specialist' => array(
        'field_5f0da844008ae', //рост
        'field_5f0da8ae008af', //год основания
        'field_5f0da98e008b0', //юрлицо
        'field_5f0dad0b008b4', //Оплата услуг
        'field_5f0dade1008b5', //райдер
        'field_5f0daf7a008bc', //ИНН
      ),
	   // скрытые поля для отправки агество
      'allstars_agency' => array(
        'field_5f0da6c5008aa', //дата рождения
        'field_5f0da80d008ac', //Дата начала рабочей практики
        'field_5f0da844008ae', //рост
        'field_5f0dade1008b5', //райдер
        'field_5f0daf1d008ba', //паспорт
      ),
    );
    if($allstats_role){
      // Название
      if($field['key'] == 'field_5f0da63b008a8'){
		  // Ищем в массиве значение $allstats_role и возвращает TRUE в случае удачи, FALSE в противном случае.
        if(in_array($allstats_role, array('allstars_artist', 'allstars_specialist'))){
			// в завистимости этого меняем label
          $field['label'] = 'Фамилия Имя Отчество';
        }elseif($allstats_role == 'allstars_group'){
          $field['label'] = 'Название вашего коллектива';
        }elseif($allstats_role == 'allstars_agency'){
          $field['label'] = 'Название агентства / компании';
        }
      }
	  // для остальных обнуляем массив
      if(isset($array_hide[$allstats_role]) && in_array($field['key'], $array_hide[$allstats_role])){        
        $field = array();
      }
    }
    
    return $field;
  }
  // применяем фильтр через хук
  add_filter('acf/prepare_field', 'allstars_acf_prepare_field');
 
  acf_form_head();
  get_header(); ?> 
  <?php	while ( have_posts() ) : the_post();?>
  <div class="container">
    <div id="main-data" class="data-<?php echo $css_main;?>">
	<!-- Вывод даных Исполнителя ACF -->
    <?php 
      add_filter('promo_acf_image_crop', 'allstars_promo_acf_image_crop');
      function allstars_promo_acf_image_crop($uploader){
        $uploader = 'wp';
        return $uploader;
      }
      acf_form(array(
        'post_id'       => $post_id, 		
        'post_title'    => false,     
        'post_content'  => false,
        'fields' => array('field_5f0da43e008a1','field_5f0da622008a7'),
        'uploader' => 'basic',  
        'submit_value'  => __('Сохранить', 'allstars'), 		
        'html_submit_button'  => '<button type="button" class="btn add_modal" data-toggle="modal" data-target="#servisesModal" data-whatever="@getbootstrap">Управление услугами</button><button type="button" class="btn add_modal" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Создать мероприятие</button><input type="submit" class="acf-button button button-primary button-large button--gray" value="%s" />',	
        'html_before_fields' => '<div class="row">',		
	      'html_after_fields' => '</div>',		
        'updated_message' => __('Информация обновлена', 'allstars')
      )); ?>
	  <!-- Вывод даных Исполнителя ACF -->
    </div>
  </div>   
  <!-- Модальное окно Управление услугами-->
  <div class="modal fade" id="servisesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" id="modal-dialog-servises">
  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Управление услугами</h4>
      </div>
      <div class="modal-body">
        <?php
      acf_form(array(
        'post_id'       => $post_id,		
        'post_title'    => false,    
        'post_content'  => false,   
        'fields' => array('servises'),
        'uploader' => 'basic',  
        'submit_value'  => __('Сохранить', 'allstars'),
        'html_submit_button'  => '<input type="submit" class="acf-button button button-primary button-large button--gray" value="%s" />',
        'html_before_fields' => '<div class="row">',		
	      'html_after_fields' => '</div>',
        'updated_message' => __('Информация по услугам обновлена', 'allstars')
      )); ?>
      </div>    
    </div>  
  </div>
</div> 

<!-- Модальное окно создать мероприятие-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="exampleModalLabel">Мероприятия</h4>
        </div>
        <div class="modal-body">
          <form action="" method="POST" name="modal_date" id="modal_date" enctype="multipart/form-data">
            <div class="form-group">
              <label for="recipient_name" class="form-control-label">Название мероприятия</label>
              <input type="text" class="form-control" id="recipient_name" name="recipient_name">
            </div>

            <fieldset class="form-group" id="form-group-radio-place">				
				<label for="place-name" class="form-control-label">Формат мероприятия ( Offline/Online )</label>
            <div class="col-sm-10">
               <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="gridplace" id="gridplace1" value="place1" checked>
                  Offline
                  </label>
                </div>
                <div class="form-check">
                   <label class="form-check-label">
                   <input class="form-check-input" type="radio" name="gridplace" id="gridplace2" value="place2">
                   Online 
                   </label>
                </div>        
            </div>
            </fieldset>			
			     <div class="form-group show-radio-reg-place">
              <label for="place_name" class="form-control-label">Место проведения мероприятия</label>
              <input type="text" class="form-control" id="place_name" name="place_name">
            </div>
			<div class="form-group show-radio-place">
				<label for="example_url_input">Ссылка на сайт мероприятие Online</label>			
				<input class="form-control" type="url" placeholder="http://allstars.ru" id="example_url_reg_place" name="example_url_reg_place">
			</div>

			<div class="form-group">
				<label for="exampleSelect1">Город проведения мероприятия</label>
				<select class="form-control" id="exampleSelect1" name="exampleSelect1">
				<?php $cities = wpr_promo_static_field('cities');?>
				<?php foreach($cities as $key => $val){ ?>
					<option value="<?php echo $key ?>"><?php echo $val ?></option>
				<?php } ?>										
				</select>
			</div>
			<div class="form-group">
				<label for="example_date_input">Дата проведения мероприятия</label>  
				<input class="form-control" type="date" placeholder="гггг-мм-дд" id="example_date_input" name="example_date_input">
			</div>			
			<div class="form-group">
				<label for="example_time_input" class="col-xs-2 col-form-label">Время проведения мероприятия</label>  
				<input class="form-control" type="time" placeholder="чч:мм" id="example_time_input" name="example_time_input">  
			</div>
      <div class="form-group">
				<label for="exampleInputFile">Загрузите фото для анонса мероприятия</label>							
				<input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp" name="exampleInputFile">
				<small id="fileHelp" class="form-text text-muted">* Вы можете загрузить фото (jpg) не более 4Мб</small>
				<small id="fileHelp" class="form-text text-muted">* Рекомендуемый размер изображения 400х250</small>
      </div>
			<div class="form-group">
				<label for="exampleTextarea">Анонс ( Описание мероприятия )</label>
				<textarea class="form-control" id="exampleTextarea" name="exampleTextarea" rows="3" maxlength="255"></textarea>
      </div>      					
			<fieldset class="form-group" id="form-group-radio">				
				<label for="place-name" class="form-control-label">Мероприятие ( Платное/Бесплатное )</label>
            <div class="col-sm-10">
               <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                  Бесплатное
                  </label>
                </div>
                <div class="form-check">
                   <label class="form-check-label">
                   <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                   Платное
                   </label>
                </div>        
            </div>
            </fieldset>
            <div class="form-group show-radio">
				<label for="example_number_input">Стоимость</label>  
				<input class="form-control" type="number" placeholder="от 2000 &#8381" id="example_number_input" name="example_number_input">  
			</div>			
			<div class="form-group show-radio">
				<label for="example_url_input">Ссылка на сайт покупки билетов</label>			
				<input class="form-control" type="url" placeholder="http://allstars.ru" id="example_url_input" name="example_url_input">
      </div>

      <div class="form-group show-radio-reg">
				<label for="example_url_input">Ссылка на сайт регистрации на мероприятие</label>			
				<input class="form-control" type="url" placeholder="http://allstars.ru" id="example_url_reg" name="example_url_reg">
      </div>
      <?php 
      $autorid = get_current_user_id();
      $starsid = allstars_get_id_stars( $autorid );               
       ?>
			<input type="hidden" name="nameuserid" id="nameuserid" value="<?php echo $starsid; ?>">            
			<input type="submit" name="modal_submit" id="modal_submit_poster" class="button button-primary button-large" value="Создать">
          </form>
          
        </div>        
      </div>
    </div>	
  </div>  
  <!-- Модальное окно end-->  
   <!-- Мероприятия -->
   <div class="container">
    <div class="single-afisha">
      <h1>Мероприятия</h1>
      <?php
      $conut = 3;
      $offset = 0;         
      ?>      
      <?php do_action('allstars_single_stars_afisha_show',$conut, $offset)?>
      <div id="show_afisha_star"></div>              
        <div class="single-afisha__footer">
        <div class="single-afisha__footer-btn" id="single-afisha__footer-btn" >
            <p class="single-afisha__input">Показать еще</p>
        </div>

        </div>       
      </div>
  </div> 
  <!-- Мероприятия end --> 
  <?php 
  // Блок отображения отзывов
  $args = array( 'post_id' => $post_id, 'post_type' => 'stars', 'status' => 'approve');  
  $comments = get_comments( $args );   
  if($comments && count($comments) > 0):?>
  <div id="reviews" class="reviews">
    <div class="container">        
      <?php	$comments_number = count($comments);?>
      <div class="row align-items-center mt-3 mb-4">
        <div class="col-12 col-lg-4">
		  <div class="h2">Отзывы о Вас</div>
          <div class="d-lg-none count-title"><?php echo $comments_number;?></div>
        </div>
        <div class="col-12 col-lg-8 d-none d-lg-block">
          <div class="count-reviews"><?php echo $comments_number;?> отзывов</div>
        </div>
      </div>	
      <?php foreach($comments as $comment){		  
        get_template_part( 'template-parts/comments', 'item');
      }?>
    </div>
  </div><!-- .reviews -->
  <?php endif; //$comments ?>
  <?php if(have_rows('orders', 'options')):?>
  <div class="orders">
    <div class="container">
	
      <div class="h1">Хотите получить больше заказов?</div>
      <div class="row">
        <?php $i = 1;
        while( have_rows('orders', 'options') ) : the_row();?>
        <div class="col-12 col-lg-6 mb-4">
          <div class="item color_<?php echo $i;?>">
            <div class="name"><?php the_sub_field('title');?></div>
            <div class="desc"><?php the_sub_field('desc');?></div>
            <div class="bottom">
              <div class="price"><?php echo number_format(get_sub_field('price'), 0, ',', ' ');?> руб.</div>
              <div class="submit">
                <?php echo do_shortcode('[wp_sber_btn class="button" amount="'.get_sub_field('price').'" type="'.get_sub_field('code').'"]');?>
              </div>
            </div>
          </div>
        </div>
        <?php $i++; if($i > 4){ $i = 1;} endwhile;?>
      </div>
    </div>  
  </div>
  <?php endif; //orders ?>
  <?php endwhile;?>  
  
  <?php acf_enqueue_uploader(); get_footer();
}