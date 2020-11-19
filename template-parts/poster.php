<?php
/* 
  Template Name: Афиша
 */
?>
<?php get_header(); ?>
<form action="" method="POST" >
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
                <option value="value1">Казань</option> 
                <option value="value2" selected>Москва</option>
                <option value="value3">Нижний Новогород</option>
              </select>
            </div>
           </div>
        </div> 
      </div>
        <div class="col-sm-6 col-md-6 col-12">
          <div class="poster__performer">
            <select name="posterperformer" id="posterperformer" class="posterperformer">
              <option value="" selected>Исполнители</option> 
              <option value="value2" >Артист1</option>
              <option value="value3">Артист2</option>
            </select>
          </div>
        </div>
      </div>          
    </div>
    <?php 
    /**
     *  @hooks allstras_poster_form_before
     *  function get_fileds_afisha, 30
     */
    ?>   
    <div class="row">
    <?php do_action('allstras_poster_form_before');?>   
    </div>    
      <div class="poster__footer">
        <div class="poster__btn">
          <input class="poster__input" type="submit" value="Показать еще">
        </div>
      </div>
    </div>      
</div>
</form>
<?php get_footer();