<?php
/**
 * Шаблон отображения артистов (звезд)
 */
?>
<?php

class ArrayPaginator
{
	public  $page    = 1;   /* Текущая страница */
	public  $amt     = 0;   /* Кол-во страниц */
	public  $limit   = 10;  /* Кол-во элементов на странице */
	public  $total   = 0;   /* Общее кол-во элементов */
	public  $display = '';	/* HTML-код навигации */
 
	private $url     = '';       
	private $carrier = 'list';
 
	/**
	 * Конструктор.
	 */
	public function __construct($url, $limit = 0)
	{
		$this->url = $url;		
		
		if (!empty($limit)) {
			$this->limit = $limit;
		}		
 
		$page = intval(@$_GET['list']);
		if (!empty($page)) {
			$this->page = $page;
		}
 
		$query = parse_url($this->url, PHP_URL_QUERY);
		if (empty($query)) {
			$this->carrier = '?' . $this->carrier . '=';
		} else {
			$this->carrier = '&' . $this->carrier . '=';
		}
	}
 
	/**
	 * Срез массива и формирование HTML-кода навигации в переменную display.
	 */
	public function getItems($array)
	{
		$this->total = count($array);
		$this->amt = ceil($this->total / $this->limit);	
		if ($this->page > $this->amt) {
			$this->page = $this->amt;
		}
 
		if ($this->amt > 1) {
			$adj = 2;	
			$this->display = '<nav class="pagination-row"><ul class="pagination justify-content-center">';
 
			/* Назад */
			if ($this->page == 1) {
				$this->addSpan('&#8592', 'prev disabled');
			} elseif ($this->page == 2) {
				$this->addLink('&#8592', '', 'prev');
			} else {
				$this->addLink('&#8592', $this->carrier . ($this->page - 1), 'prev');
			}
 
			if ($this->amt < 7 + ($adj * 2)) {
				for ($i = 1; $i <= $this->amt; $i++){
					$this->addLink($i, $this->carrier . $i);			
				}
			} elseif ($this->amt > 5 + ($adj * 2)) {
				$lpm = $this->amt - 1;
				if ($this->page < 1 + ($adj * 2)){
					for ($i = 1; $i < 4 + ($adj * 2); $i++){
						$this->addLink($i, $this->carrier . $i);
					}
					$this->addSpan('...', 'separator');	
					$this->addLink($lpm, $this->carrier . $lpm);
					$this->addLink($this->amt, $this->carrier . $this->amt);	
				} elseif ($this->amt - ($adj * 2) > $this->page && $this->page > ($adj * 2)) {
					$this->addLink(1);
					$this->addLink(2, $this->carrier . '2');
					$this->addSpan('...', 'separator');	
					for ($i = $this->page - $adj; $i <= $this->page + $adj; $i++) {
						$this->addLink($i, $this->carrier . $i);
					}
					$this->addSpan('...', 'separator');	
					$this->addLink($lpm, $this->carrier . $lpm);
					$this->addLink($this->amt, $this->carrier . $this->amt);	
				} else {
					$this->addLink(1, '');
					$this->addLink(2, $this->carrier . '2');
					$this->addSpan('...', 'separator');	
					for ($i = $this->amt - (2 + ($adj * 2)); $i <= $this->amt; $i++) {
						$this->addLink($i, $this->carrier . $i);
					}
				}
			}
 
			/* Далее */
			if ($this->page == $this->amt) {
				$this->addSpan('&#8594', 'next disabled');				
			} else {			
				$this->addLink('&#8594', $this->carrier . ($this->page + 1));
			}
 
			$this->display .= '</ul></nav>';
		}
 
		$start = ($this->page != 1) ? $this->page * $this->limit - $this->limit : 0;		
		return array_slice($array, $start, $this->limit);	
	}
 
	private function addSpan($text, $class = '')
	{
		$class = 'page-item ' . $class;
		$this->display .= '<li class="' . trim($class) . '"><span class="page-links">' . $text . '</span></li>';		
	}	
 
	private function addLink($text, $url = '', $class = '')
	{
		if ($text == 1) {
			$url = '';
		}
 
		$class = 'page-item ' . $class . ' ';
		if ($text == $this->page) {
			$class .= 'active';
		}
		$this->display .= '<li class="' . trim($class) . '"><a class="page-links" href="' . $this->url . $url . '">' . $text . '</a></li>';
	}	
	
	/**
	 * Метод для title страниц.
	 */
	public function getTitle()
	{
		if ($this->page > 1) {
			return ' - страница ' . $this->page;
		} else {
			return '';
		}
	}
}

global $sort;

$peger = new ArrayPaginator(get_site_url().'/allstars/', 10); 
$items = $peger->getItems($sort);
foreach ($items as $arr_sort) {
  // Маркер подтверждения регистрации артиста
  //$marker_is_confirmation = $arr_sort[$i]['star']['is_confirmation'];
  $marker_is_confirmation = true;
  // Маркер топ-звезда
  $top_star = false;
  // Заглушка для изображения
  $img = get_template_directory_uri().'/assets/img/star-thumbnail.png';
  $block_left = $arr_sort['star']['block_left'];
  $block_right = $arr_sort['star']['block_right'];
  if ( $block_left['main_img'] ) {
    $_temp = $block_left['main_img'];
    $img = $_temp['sizes']['thumbnail'];
  }
  if ( $arr_sort['star']['is_top'] ) {
    $top_star = true;
  };
  $user_spec_name = array();
  $arr_specialization = $block_right['specialization'];
  if( isset($arr_specialization) ) {
    $user_spec_name[] = $arr_specialization['label'];
  } else {
    foreach($arr_specialization as $spec){
      $user_spec_name[] = $spec['label'];
    }
  };
  $user_spec = implode(', ', $user_spec_name);

  $the_permalink = $arr_sort['post']['guid'];  
  $the_title = $arr_sort['post']['post_title'];
?>
<?php if($marker_is_confirmation):?>
<?php if($top_star):?>
<div class="col-12 mb-4">
  <div class="star top">
    <div class="top">
      <div class="row justify-content-center">
        <div class="col-12 col-md-3">
          <div class="img star-img"><a href="<?php echo $the_permalink; ?>"><img src="<?php echo $img;?>" alt="<?php echo $the_title;?>"/></a></div>
        </div>
        <div class="col-12 col-md-9 star-item-top-left">
          <div class="name"><a href="<?php echo $the_permalink; ?>"><?php echo $the_title;?></a><span class="label-pro">PRO</span></div>
          <div class="info">
            <span class="region"><?php echo implode(', ', array_column($block_right['cities'], 'label'));?></span>
			<br/>
			<span class="specialization"><?php echo $user_spec;?></span>
          </div>
          <div class="rating-block inline">
            <?php get_template_part( 'template-parts/rating', 'block');?>
          </div>
          <div class="about">
            <?php //do_excerpt($block_right['what_do_you_do'], 25);
			$tmp_arr_block_right = $block_right;
			do_excerpt($tmp_arr_block_right['about'], 25)
			
			?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php else:?>
<div class="col-12 col-md-6 mb-4">
  <div class="star star--tile" data-link="<?php echo $the_permalink; ?>">
    <div class="top">
      <div class="row star--list align-items-center justify-content-center">
        <div class="star-item-left col-5 col-sm-5 col-md-5">
          <div class="img star-img"><a href="<?php echo $the_permalink; ?>"><img src="<?php echo $img;?>" alt="<?php echo $the_title;?>"/></a></div>
        </div>
        <div class="star-item-right col-7 col-sm-7 col-md-7">
          <div class="name"><a href="<?php echo $the_permalink; ?>"><?php echo $the_title;?></a></div>
          <div class="info">
            <span class="region"><?php echo implode(', ', array_column($block_right['cities'], 'label'));?></span>
			<br/>
            <span class="specialization"><?php echo $user_spec;?></span>
          </div>
          <div class="rating-block">
            <?php get_template_part( 'template-parts/rating', 'block');?>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom">
      <div class="about">
        <?php //do_excerpt($block_right['what_do_you_do'], 25);
		$tmp_arr_block_right_test = $block_right;
		do_excerpt($tmp_arr_block_right_test['about'], 17)
		?>
      </div>
    </div>
  </div>
</div>
<?php endif;?>
<?php endif; ?> <!-- $marker_is_confirmation -->
<?php
} //while  
?>
<?php if($peger->display != ''):?>
<div class="stars_pagination">
<?php echo $peger->display; ?>
</div>
<?php endif;?>


