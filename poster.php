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
    <div class="row">
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>   
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>   
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>   
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
        <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>   
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4">
      <a href="#" class="poster_redirect">
          <div class="poster__item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/img1.svg" alt="" />
            <div class="poster__miniature">               
              <div class="poster__circle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/imgmini1.svg" alt="" />                                  
              </div>
              <h6>Шоу Fire monster</h6>       
            </div>
            <h4>Благотворительная выставка</h4>
            <p class="poster_place">Онлайн</p>            
            <p class="poster_date">25 октября 2020, 18:00</p>
          </div>
        </a>
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