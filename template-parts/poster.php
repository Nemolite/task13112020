<?php
/* 
  Template Name: Афиша
 */
?>
<?php get_header();?>
<div class="poster">
  <div class="container">
    <div class="poster_header">
      <h1>Афиша</h1>
      <p>Посмотрите как артист выступает на других мероприятиях 
         и будьте уверены в своём выборе на 100%!
         Обратите внимание, что афиша отображается в 
         соответствии с выбранным городом.
      </p>
    </div> 
    <form action="" method="POST" >   
    <div class="poster__filter">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-12">
          <div class="row">
           <div class="col-sm-6 col-6">
            <div class="poster__date">            
             <input type="date" value="Дата" name="posterdate" id="posterdate" class="posterdate">
            </div>
           </div>
           <div class="col-sm-6 col-6">
            <div class="poster__city">            
              <select name="postercity" id="postercity" class="postercity">
                <?php $cities = allstars_get_full_cities();?>
				<?php foreach($cities as $key => $val){ ?>
					<option value="<?php echo $key ?>"><?php echo $val ?></option>
				<?php } ?>	
              </select>
            </div>
           </div>
        </div> 
      </div>
        <div class="col-sm-6 col-md-6 col-12">
          <div class="poster__performer">
            <select name="posterperformer" id="posterperformer" class="posterperformer">
			    <?php $stars = allstars_get_full_stars_for_afisha();?>
				<?php foreach($stars as $key => $val){ ?>
					<option value="<?php echo $key ?>"><?php echo $val ?></option>
				<?php } ?>
            
            </select>
          </div>
        </div>
      </div>          
    </div>
    </form>
    <?php 
    /**
     *  @hooks allstras_poster_form_before
     *  function get_fileds_afisha, 30
     */    
    ?>
    <div class="row poster_counter" id="show_post2">
      <?php 
      $count = 18;
      $offset = 0; 
      do_action('allstras_poster_form_before', $count, $offset);
      ?> 
    </div>
    <div id="show_post"></div>             
      <div class="poster__footer">
        <div class="poster__btn" id="poster__btn">
          <p class="poster__input">Показать еще</p>          
        </div>
      </div>      
    </div>
</div>
<?php get_footer();