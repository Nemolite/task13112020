<?php
/**
 * Блок заказаов в личном кабинете звезды
 * 
 */
?>
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