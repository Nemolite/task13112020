<?php
/* 
  Template Name: Афиша
 */
?>
<?php get_header(); ?>
<form action="" method="POST" >
<div class="poster">
  <div class="container">
    <h1>Афиша</h1>
    <p>Посмотрите как артист выступает на других мероприятиях 
    и будьте уверены в своём выборе на 100%!
    Обратите внимание, что афиша отображается в 
    соответствии с выбранным городом.</p>
    <div class="poster__filter">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
          <div class="poster__date">
            <!-- <select name="posterdate" id="posterdate" class="posterdate">
              <option value="value1">Москва</option> 
              <option value="value2" selected>Казань</option>
              <option value="value3">Нижний Новогород</option>
            </select> -->
            <input type="date" value="Дата" name="posterdate" id="posterdate" class="posterdate">
          </div>
        </div>
        <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
         <div class="poster__city">
            <select name="postercity" id="postercity" class="postercity">
              <option value="value1">Казань</option> 
              <option value="value2" selected>Москва</option>
              <option value="value3">Нижний Новогород</option>
            </select>
         </div>
        </div>
        <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">         
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
    <div class="row">
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <div class="poster__item">
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <div class="poster__item">        
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <div class="poster__item">        
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <div class="poster__item">
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <div class="poster__item">        
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <div class="poster__item">        
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <div class="poster__item">
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <div class="poster__item">        
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <div class="poster__item">        
        </div>
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