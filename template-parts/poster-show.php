<?php
/**
 *  Шаблон вывода афишы
 */
?>
<?php
$afisha_id = $args;
?>
<div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">    
  <div class="poster__item">
 
    <div class="poster__img">
      <?php the_post_thumbnail();?>      
    </div>
      

    <?php if (! get_field('postsale', $afisha_id)) :?>
    <div class="poster_sale" id="poster_sale">      
      <a class="poster_outlink" id="poster_outlink" href="<?php the_field('postregurl', $afisha_id);?>" target="_blank">Бесплатно</a>      
    </div>
    <?php endif ?>
    <?php if (get_field('postsale', $afisha_id)) :?>
    <div class="poster_sale" id="poster_sale">      
      <a class="poster_outlink" id="poster_outlink" href="<?php the_field('postsaleurl', $afisha_id);?>" target="_blank">от <?php the_field('ticketprice', $afisha_id)?> &#8381;</a>
    </div>
    <?php endif ?>     
      <div class="poster__miniature"> 
        <!-- вывод аватрок артистов -->
        <?php apply_filters( 'get_array_stars', $afisha_id ); ?>              
      </div><!-- class="poster__miniature" -->     
    <h4><?php 
    $poster = wp_trim_words( the_field('poster', $afisha_id), 50 );
    echo $poster;
    ?></h4>   
    <?php if (! get_field('url_online', $afisha_id)) :?>         
    <p class="poster_place"><?php echo the_field('posplace', $afisha_id); ?></p>  
    
    <?php endif ?>
    <?php if (get_field('url_online', $afisha_id)) :?>         
      <a class="poster_place poster_sale_url" id="poster_outlink" href="<?php the_field('url_online', $afisha_id);?>" target="_blank">Online</a>    
    <?php endif ?>
    <p class="poster_date">
    <?php 
    $date = get_field('postdate', $afisha_id);
	echo $date;
    //$date2 = date("j F Y, H:i", strtotime($date));
    //echo $date2;
    ?>      
    </p>    
  </div>     
</div> 
     