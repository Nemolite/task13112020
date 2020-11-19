<?php
/**
 * 
 */
?>
<div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
    <a href="#" class="poster_redirect">
        <div class="poster__item">
            <div class="poster__img">
             <?php the_post_thumbnail();?>
            </div>
            <div class="poster_sale" id="poster_sale">
              <p>Бесплатно</p>
            </div>
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6><?php echo the_title(); ?></h6>       
            </div>
            <h4><?php echo the_field('poster'); ?></h4>
            <p class="poster_place"><?php echo the_field('posplace'); ?></p>            
            <p class="poster_date"><?php echo the_field('postdate'); ?></p>
        </div>
    </a>   
</div> 
     