<?php
/**
 *  Шаблон вывода афиш на странице артиста
 *  Личный кабинет и на front
 */
?>
<div class="row">
         <div class="col-md-4">
            <div class="single-afisha__img">
                <?php the_post_thumbnail();?>
            </div>
            <div class="single-afisha__sale" id="single-afisha__sale">
                <?php if (! get_field('postsale')) :?>
                    <div class="poster_sale" id="poster_sale">
                    <a class="poster_outlink" id="poster_outlink" href="<?php the_field('postregurl');?>" target="_blank">Бесплатно</a>
                    </div>
                <?php endif ?>
                <?php if (get_field('postsale')) :?>
                    <div class="poster_sale" id="poster_sale">      
                        <a class="poster_outlink" id="poster_outlink" href="<?php the_field('postsaleurl');?>" target="_blank">от <?php the_field('ticketprice')?> &#8381;</a>
                    </div>
                <?php endif ?>
            </div>
         </div>  
         <div class="col-md-8">
          <div class="single-afisha__txt">
             <h4><?php echo the_field('poster'); ?></h4>
             <p class="single-afisha_place">
                <?php if( !empty(the_field('posplace')) ) { ?>
                <?php echo the_field('posplace'); ?>
                <?php } ?>
              </p> 
              <?php if( !empty(get_field('url_online')) ): ?>
                <a class="single-afisha_place_url" href="<?php the_field('url_online'); ?>">Online</a>
              <?php endif?>                          
              <p class="single-afisha_date"><?php echo the_field('postdate'); ?></p>
              <div class="single-afisha_description"><?php the_content(); ?>       
                </div> 
             
              <a id="poster_outlink" href="<?php the_field('postregurl');?>" target="_blank">
                <div class="single-afisha__btn-invers">
                    <div class="poster_sale" id="poster_sale">      
                        <p>Подробнее</p>
                    </div>
                </div>
                </a> 
                           
             <?php if (get_field('postsale')) :?>
                <a id="poster_outlink" href="<?php the_field('postsaleurl');?>" target="_blank">
                <div class="single-afisha__btn">
                    <div class="poster_sale" id="poster_sale">      
                        <p>Купить билет</p>
                    </div>
                </div>
                </a>  
            <?php endif ?>
            <?php if (! get_field('postsale')) :?>
                <a id="poster_outlink" href="<?php the_field('postregurl');?>" target="_blank">
                <div class="single-afisha__btn">
                    <div class="poster_sale" id="poster_sale">      
                        <p>Регистрация</p>
                    </div>
                </div>
                </a>  
            <?php endif ?>         
          </div>           
         </div>         
        </div> 