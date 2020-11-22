<?php get_header(); ?>
<?php while ( have_posts() ) : the_post();
  /* Admin */
  $is_verify = get_field('is_verify'); // верификация подтверждена?

  $img = get_template_directory_uri().'/assets/img/star-thumbnail.png';
  $img_url = '';
  $block_left = get_field('block_left');
  $block_right = get_field('block_right');
  $media_video = '';
  $rider = '';
  $age = 0;
  $user_email = get_the_author_meta('user_email');
  if($block_left['main_img']){
    $_temp = $block_left['main_img'];
    $img = $_temp['sizes']['main-star-preview'];
    $img_url = $_temp['url'];
    if(isset($_temp['original_image'])){
      $img_url = $_temp['original_image']['url'];
    }
  }
  $user_spec_name = array();
  $arr_specialization = $block_right['specialization'];
  
  if(isAssoc($arr_specialization)){
    $user_spec_name[] = $arr_specialization['label'];
  }else{
    foreach($arr_specialization as $spec){
      $user_spec_name[] = $spec['label'];
    }
  }
  $user_spec = implode(', ', $user_spec_name);

/* теги */
   $user_profile_direction = array(); 
   $arr_profile_direction = $block_right['profile_direction'];
 if(isAssoc($arr_profile_direction)){
    $user_profile_direction[] = $arr_specialization['label'];
  }else{
    foreach($arr_profile_direction as $direction){
      $user_profile_direction[] = $direction['label'];
    }
  }
 
  //show($user_profile_direction);
   
  /* Видео */
  if($block_left['video']){
    if(filter_var($block_left['video'], FILTER_VALIDATE_URL)){
      $arr_url = parse_url($block_left['video']);
      $url_query = preg_match('/v=([^#\&\?]*).*/', $arr_url['query'], $matches);
      if($matches){
        $media_video = $matches[1];
      }
    }else{
      $media_video = $block_left['video'];
    }
  }
  /* Возраст */
  if($block_right['birthday']){
    $age = allstars_getFullYears($block_right['birthday']);
  }
?>
<div class="test"></div>
  <div class="post post-stars">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-5">
          <div class="single-header d-block d-lg-none">
            <div class="name">
              <div class="h1"><?php single_post_title(); ?></div>
			   <?php if($is_verify):?>
              <span class="verify" title="Подтвержденный аккаунт"><i class="fas fa-check"></i></span>
              <?php endif;?>
            </div>
            <div class="subinfo">
              <div class="specialization"><?php echo $user_spec;?></div>
			   <div class="rating-block inline">
                <?php get_template_part( 'template-parts/rating', 'block');?>
              </div>
               <?php if($user_profile_direction):?>

			   <div class="tags">
                <?php foreach($user_profile_direction as $user_tag):?>
                <span><?php echo $user_tag;?></span>
                <?php endforeach;?>
              </div>
              <?php endif;?>
            </div>
          </div>
		    <div class="main-img">
		
		   <?php if($img_url):?>
            <a href="<?php echo $img_url;?>" rel="gallery"><img src="<?php echo $img;?>" alt="<?php $block_right['name'];?>"/></a>
            <?php else:?>
            <img src="<?php echo $img;?>" alt="<?php $block_right['name'];?>"/>
            <?php endif;?>
          </div>
		  		  
		  <!-- Отображние в ряд на ПК sv-->
		   <div class="row fix-row">
  <div class="col-md-3 col-sm-3">
   <div class="inner">
   <a href="https://www.youtube.com/watch?v=<?php echo $media_video;?>" class="video" rel="nofollow">
       <img src="https://i.ytimg.com/vi/<?php echo $media_video;?>/hqdefault.jpg" alt=""/>
   </a>
   </div>
    </div>
  <div class="col-md-3 col-sm-3">
  <div class="inner">
  
  <?php if(trim($block_left['add_img_1']['url'])): { ?>
  
  
   <a href="<?php echo $block_left['add_img_1']['url'];?>" class="image" rel="gallery">
                  <img src="<?php echo $block_left['add_img_1']['sizes']['star-comment-thumbnail'];?>" alt=""/>
                </a>
  <?php } else: { ?>
  <div class="fix22-img"></div>
  <?php } endif ?>   
   </div>
  </div>
  <div class="col-md-3 col-sm-3">
  <div class="inner">
  <?php if(trim($block_left['add_img_2']['url'])): { ?>
  
    <a href="<?php echo $block_left['add_img_2']['url'];?>" class="image" rel="gallery">
        <img src="<?php echo $block_left['add_img_2']['sizes']['star-comment-thumbnail'];?>" alt=""/>
	</a>
	<?php } else: { ?>		
	<div class="fix22-img"></div>
	<?php } endif ?> 
   </div>
  </div>
  <div class="col-md-3 col-sm-3">
  <div class="inner">
  <?php if(trim($block_left['add_img_3']['url'])): { ?>
  <a href="<?php echo $block_left['add_img_3']['url'];?>" class="image" rel="gallery">
                  <img src="<?php echo $block_left['add_img_3']['sizes']['star-comment-thumbnail'];?>" alt=""/>
                </a>
  <?php } else: { ?>		
	<div class="fix22-img"></div>
	<?php } endif ?>  				
   </div>
  </div>
         </div>
		  <!-- Отображение как слайдер на маленьких экранах sv -->
		   <div class="fix-slider" id="mini-slider-adaptiv">
		    <div class="slider-inner">
		       <?php if($img_url):?>
            <a href="<?php echo $img_url;?>" rel="gallery"><img src="<?php echo $img;?>" alt="<?php $block_right['name'];?>"/></a>
            <?php else:?>
            <img src="<?php echo $img;?>" alt="<?php $block_right['name'];?>"/>
            <?php endif;?>
		   </div>
		   
		   
               <div class="slider-inner">
                <a href="https://www.youtube.com/watch?v=<?php echo $media_video;?>" class="video" rel="nofollow">
       <img src="https://i.ytimg.com/vi/<?php echo $media_video;?>/hqdefault.jpg" alt=""/>
   </a>
               </div>
               <div class="slider-inner">
                 <a href="<?php echo $block_left['add_img_1']['url'];?>" class="image" rel="gallery">
                  <img src="<?php echo $block_left['add_img_1']['sizes']['thumbnail'];?>" alt=""/>
                </a>
               </div>
               <div class="slider-inner">
                <a href="<?php echo $block_left['add_img_2']['url'];?>" class="image" rel="gallery">
                  <img src="<?php echo $block_left['add_img_2']['sizes']['thumbnail'];?>" alt=""/>
                </a>
               </div>
			   <div class="slider-inner">
			   
                 <a href="<?php echo $block_left['add_img_3']['url'];?>" class="image" rel="gallery">
                  <img src="<?php echo $block_left['add_img_3']['sizes']['thumbnail'];?>" alt=""/>
                </a>
				
				
               </div>
             </div>
  
         <!-- слайдер finish -->
	 
          <div class="rating-block d-lg-flex justify-content-between mb-4 fix-rating-block">
            <?php get_template_part( 'template-parts/rating', 'block');?>
          </div>
        </div>
        <div class="col-12 col-lg-7">
          <div class="single-header d-none d-lg-block">
            <div class="name">
              <h1><?php single_post_title(); ?></h1>
              <?php if($is_verify):?>
              <span class="verify" title="Подтвержденный аккаунт"><i class="fas fa-check"></i></span>
              <?php endif;?>
            </div>
            <div class="subinfo">
              <div class="specialization"><?php echo $user_spec;?></div>
			  <?php if($user_profile_direction):?>

			   <div class="tags">
                <?php foreach($user_profile_direction as $user_tag):?>
                <span><?php echo $user_tag;?></span>
                <?php endforeach;?>
              </div>
              <?php endif;?>
			             
			  
            </div>
          </div>
          <div class="content fix7">
		    <?php if($age > 0 || $block_right['height']):?>
            <div class="parameters"><?php if($age > 0) echo $age.' лет / '; if($block_right['height']) echo $block_right['height'].' см';?></div>
            <?php endif;?>
            <?php if($block_right['cities']):?>
            <div class="cities"><?php echo implode(', ', array_column($block_right['cities'], 'label'));?></div>
            <?php endif;?>
            <?php if($block_right['rider']):?>
            <div class="rider pdf-icon"><a href="<?php echo $block_right['rider']['url'];?>"><?php echo $block_right['rider']['title'];?></a></div>
            <?php endif;?>
            <?php if($block_right['facts']):
            $arr_facts = explode(';', $block_right['facts']);
            $arr_facts = array_diff($arr_facts, array(''));
            if($arr_facts):
            ?>
            <div class="characteristics">
              <?php foreach($arr_facts as $fact):?>
              <div class="item">
                <i class="fas fa-check"></i>
                <div class="text"><?php echo $fact;?></div>
              </div>
              <?php endforeach;?>
            </div>
            <?php endif; endif;?>
            <div class="action">
              <div class="row">
                <div class="col-6 col-lg-4 col-xs-12 ">
                  <a class="btn-bg text-center fix-btn-bg" href="#" data-toggle="modal" data-target="#star-contacts">Показать контакты</a>
                </div>
                <div class="col-6 col-lg-4 fix-colums">
                  <a class="btn-bgno text-center" href="#" data-toggle="modal" data-target="#comments-form">Оставить отзыв</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <?php if($block_right['about']):?>
          <div class="desc">
            <?php echo $block_right['about'];?>
          </div>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div><!-- .single-post -->
  <!-- Мероприятия -->
  <div class="container">
    <div class="single-afisha">
      <h1>Мероприятия</h1>
       <div class="row">
         <div class="col-md-4">
            <div class="single-afisha__img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/poster/img1.jpg" alt="" />
            </div>
            <div class="single-afisha__sale" id="single-afisha__sale">
              <p>Бесплатно</p>
            </div>
         </div>  
         <div class="col-md-8">
          <div class="single-afisha__txt">
             <h4>Концерт</h4>
              <p class="single-afisha_place">Паб Records</p>
              <p class="single-afisha_date">23 октября 2020, 19:00</p>
              <p class="single-afisha_description">Описание мероприятия. 
               Описание мероприятия.Описание мероприятия.
               Описание мероприятия.Описание мероприятия.
               Описание мероприятия.Описание мероприятия.
               Описание мероприятия.Описание мероприятия. 
               Описание мероприятия. Описание мероприятия.             
              </p> 
              <div class="single-afisha__btn"> 
                <p>Купить билет</p>          
              </div>    
          </div>           
         </div>         
        </div> 
        <div class="row">
         <div class="col-md-4">
            <div class="single-afisha__img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/poster/img1.jpg" alt="" />
            </div>
            <div class="single-afisha__sale" id="single-afisha__sale">
              <p>Бесплатно</p>
            </div>
         </div>  
         <div class="col-md-8">
          <div class="single-afisha__txt">
             <h4>Концерт</h4>
              <p class="single-afisha_place">Паб Records</p>
              <p class="single-afisha_date">23 октября 2020, 19:00</p>
              <p class="single-afisha_description">Описание мероприятия. 
               Описание мероприятия.Описание мероприятия.
               Описание мероприятия.Описание мероприятия.
               Описание мероприятия.Описание мероприятия.
               Описание мероприятия.Описание мероприятия. 
               Описание мероприятия. Описание мероприятия.             
              </p> 
              <div class="single-afisha__btn"> 
                <p>Купить билет</p>          
              </div>    
          </div>           
         </div>         
        </div> 
        <div class="row">
         <div class="col-md-4">
            <div class="single-afisha__img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/poster/img1.jpg" alt="" />
            </div>
            <div class="single-afisha__sale" id="single-afisha__sale">
              <p>Бесплатно</p>
            </div>
         </div>  
         <div class="col-md-8">
          <div class="single-afisha__txt">
             <h4>Концерт</h4>
              <p class="single-afisha_place">Паб Records</p>
              <p class="single-afisha_date">23 октября 2020, 19:00</p>
              <p class="single-afisha_description">Описание мероприятия. 
               Описание мероприятия.Описание мероприятия.
               Описание мероприятия.Описание мероприятия.
               Описание мероприятия.Описание мероприятия.
               Описание мероприятия.Описание мероприятия. 
               Описание мероприятия. Описание мероприятия.             
              </p> 
              <div class="single-afisha__btn"> 
                <p>Купить билет</p>          
              </div>    
          </div>           
         </div>         
        </div>        
      </div>
  </div>
  <?php
  if ( comments_open() || get_comments_number() ) :
    comments_template();
  endif;?>
  <div class="modal fade" id="star-contacts" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
		  
            <div class="title-form mb-4">Контакты</div>
            <div class="contacts row">
              <div class="item col-12 mb-4">
                <span>Email:</span> <a href="mailto:<?php echo $user_email;?>"><?php echo $user_email;?></a>
              </div>
              <?php if($block_right['phone']): $link = allstars_convert_phone($block_right['phone']);?>
              <div class="item col-12 mb-4">
                <span>Телефон:</span> <a href="tel:<?php echo $link;?>"><?php echo $block_right['phone'];?></a>
              </div>
              <?php endif;?>
			  <?php if($block_right['work_time']): ?>
              <div class="item col-12 mb-4">
                <span>График работы:</span> <p class="work_time"> <?php echo ($block_right['work_time'])?></p>
              </div>
              <?php endif;?>
			  <?php if($block_right['payment_method']): ?>
              <div class="item col-12 mb-4">
                <span>Варианты оплаты:</span>
                <div class="paid"> 
				<?php 
				//print_r($block_right['payment_method']);
				/*
				nal : Наличные
				cash : Безналичные
				card : Карта
				*/
				
				foreach($block_right['payment_method'] as $many){
					switch ($many) {
                       case 'nal':
                        echo "<p class=work_time >Оплата наличными</p> ";
		                break;
                      case 'cash':
                        echo "<p class=work_time>Безналичный расчет</p> ";
                        break;
                      case 'card':
                        echo "<p class=work_time>Оплата на карту</p> ";
                        break;
                    }
				}
				?>

              </div>
              <?php endif;?>
              <?php if($block_right['soc_vk']): $link = (filter_var($block_right['soc_vk'], FILTER_VALIDATE_URL)) ? $block_right['soc_vk'] : 'https://vk.com/'.$block_right['soc_vk'];?>
              <div class="item col-6 col-sm-2 mb-4 text-center">
                <a href="<?php echo $link;?>" class="star-soc" title="Вконтакте" target="_blank"><i class="fab fa-vk"></i></a>
              </div>
              <?php endif;?>
              <?php if($block_right['soc_instagram']): $link = (filter_var($block_right['soc_instagram'], FILTER_VALIDATE_URL)) ? $block_right['soc_instagram'] : 'https://www.instagram.com/'.$block_right['soc_instagram'];?>
              <div class="item col-6 col-sm-2 mb-4 text-center">
                <a href="<?php echo $link;?>" class="star-soc" title="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
              </div>
              <?php endif;?>
            </div>

          </div>
        </div>
    </div>
</div>
<?php endwhile;?>
<?php get_footer(); ?>
