<?php
global $count;
$is_full = false;
if($count == 1 || ($count+1) % 7  == 1){
  $is_full = true;
}

$size_thumb = 'medium';
$class = 'col-12 col-md-6 col-lg-4 mb-4';
if($is_full){
  $class = 'col-12 col-md-12 col-lg-8 mb-4 full';
  $size_thumb = 'medium_large';
  $class_txt = "fix37-link";
} else {  
  $class_txt = "fix38-link";
}
?>
<div class="news-item <?php echo $class;?>">
  <div class="section">
    <div class="img">
      <a href="<?php the_permalink();?>"><?php the_post_thumbnail($size_thumb);?></a>
    </div>
    <div class="content">
      <div class="title"><a class="<?php echo $class_txt;?>" href="<?php the_permalink();?>"><?php the_title();?></a></div>
      <div class="desc"><?php do_excerpt(get_the_content(), 15);?></div>
    </div>
  </div>
</div>
