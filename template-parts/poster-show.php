<?php
/**
 *  Шаблон вывода афишы
 */
?>
<?php
$tmpid = $args['ID'];
$tmp_arr_stars = get_fields($tmpid);
$tmp_url = $tmp_arr_stars['block_left']['main_img']['url'];
?>
<div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">    
  <div class="poster__item">
  <a href="<?php echo $args['guid']; ?>" class="poster_redirect">
    <div class="poster__img">
      <?php the_post_thumbnail();?>      
    </div>
  </a>      

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
    <a href="<?php echo $args['guid']; ?>" class="poster_redirect">
      <div class="poster__miniature">               
        <div class="poster__circle">
          <img src="<?php echo $tmp_url; ?>" alt="" />                                  
        </div>
          <h6><?php echo $args['post_title']; ?></h6>       
      </div>
    </a>  
    <h4><?php echo the_field('poster'); ?></h4>   
    <?php if (! get_field('url_online')) :?>         
    <p class="poster_place"><?php echo the_field('posplace'); ?></p>  
    
    <?php endif ?>
    <?php if (get_field('url_online')) :?>         
      <a class="poster_place poster_sale_url" id="poster_outlink" href="<?php the_field('url_online');?>" target="_blank">Online</a>    
    <?php endif ?>
    <p class="poster_date"><?php echo the_field('postdate'); ?></p>    
  </div>     
</div> 
     