<?php
/**
 *  Шаблон вывода афиш на странице артиста
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
                        <p>Бесплатно</p>      
                    </div>
                <?php endif ?>
                <?php if (get_field('postsale')) :?>
                    <div class="poster_sale" id="poster_sale">      
                        <a class="poster_outlink" id="poster_outlink" href="<?php the_field('postsaleurl');?>" target="_blank"><?php the_field('ticketprice')?> &#8381;</a>
                    </div>
                <?php endif ?>
            </div>
         </div>  
         <div class="col-md-8">
          <div class="single-afisha__txt">
             <h4><?php echo the_field('poster'); ?></h4>
              <p class="single-afisha_place"><?php echo the_field('posplace'); ?></p>
              <p class="single-afisha_date"><?php echo the_field('postdate'); ?></p>
              <p class="single-afisha_description"><?php the_content(); ?>       
              </p>               
             <?php if (get_field('postsale')) :?>
                <a id="poster_outlink" href="<?php the_field('postsaleurl');?>" target="_blank">
                <div class="single-afisha__btn">
                    <div class="poster_sale" id="poster_sale">      
                        <p>Купить билет</p>
                    </div>
                </div>
                </a>  
            <?php endif ?>        
          </div>           
         </div>         
        </div> 