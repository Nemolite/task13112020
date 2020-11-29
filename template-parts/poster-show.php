<?php
/**
 *  Шаблон вывода афишы
 */
?>
<div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">    
  <div class="poster__item">
  <a href="#" class="poster_redirect">
    <div class="poster__img">
      <?php the_post_thumbnail();?>
    </div>
  </a>      
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
    <a href="#" class="poster_redirect">
      <div class="poster__miniature">               
        <div class="poster__circle">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/poster/imgmini1.jpg" alt="" />                                  
        </div>
          <h6><?php echo the_title(); ?></h6>       
      </div>
    </a>  
    <h4><?php echo the_field('poster'); ?></h4>
    <p class="poster_place"><?php echo the_field('posplace'); ?></p>            
    <p class="poster_date"><?php echo the_field('postdate'); ?></p>    
  </div>     
</div> 
     