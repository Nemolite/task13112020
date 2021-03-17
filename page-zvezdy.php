<?php
/**
 *  Template Name: Артисты
 */
?>
<?php get_header(); ?>
<a href="/birzha/" class="static-container__content">Биржа</a>
<div class="stars">
  <div class="container" >
    <div class="row">
      <div class="col-12 col-md-5 col-lg-3">
        <?php allstars_filter_form_stars();?>
      </div>
      <div class="col-12 col-md-7 col-lg-9">
        <div class="archive-header">
        </div>
        <div class="content" id="content_sroll">
          <div id="stars" class="row">         
          <?php 
// Полный список артистов: 
// - произвольный тип записей Звезды
// - произвольные поля
$list_full = universal();
global $sort;
$sort = global_sort($list_full);          
          get_template_part( 'template-parts/catalog', 'zvezdy'); ?>
          </div>
</div>
</div>       
</div>
</div>
<?php get_footer();