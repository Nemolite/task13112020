<?php get_header();?>
<a href="/birzha/" class="static-container__content">Биржа</a>
<div class="stars mb-3">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-5 col-lg-3">
        <?php allstars_filter_form_stars();?>
      </div>
      <div class="col-12 col-md-7 col-lg-9">
        <div class="archive-header">
          <h1><?php the_archive_title();?></h1>
        </div>
        <div class="content">
          <div id="stars" class="row">
            <?php while ( have_posts() ) : the_post();            
              if(have_rows('block_right')):
              get_template_part( 'template-parts/catalog', 'star');
              endif;
            endwhile;?>
          </div>                  
          <?php the_posts_pagination();?>
        </div> 
      </div>
    </div>
       
  </div>
</div>
<?php get_footer();?>