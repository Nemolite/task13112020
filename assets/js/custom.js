jQuery(document).ready(function($) {
  $('.wpr-promo-registration select').select2({
    language: "ru",
    width: "100%",
    minimumResultsForSearch: Infinity,
    dropdownParent: $("#registration"),
  });

  $('.wpr-promo-registration select[name="user_city"]').select2({
    language: "ru",
    width: "100%",
    dropdownParent: $("#registration"),
  });
  $('.wpcf7 select').select2({
    language: "ru",
    width: "100%"
  });
  $('.box_forma select').select2({
    language: "ru",
    width: "100%"
  });
  $('.form select').select2({
    language: "ru",
    width: "100%"
  });
  /* Плесхолдер */
    
  $("select.wpcf7-select").select2({
    placeholder: "Выбрать",
	marginLeft: "10px",
	
  });
 
  
  $('.slick-media').slick({
    dots: false,
    infinite: false,
    slidesToShow: 4,
    slidesToScroll: 1,
    adaptiveHeight: true
  })

  $('#filter').submit(function(){
		var filter = $('#filter');
		$.ajax({
			url:filter.attr('action'),
			data:filter.serialize(), // form data
			type:filter.attr('method'), // POST
			beforeSend:function(){
				console.log('send filter');				
				
			},
			success:function(data){
                console.log('success');
				$('#stars').html(data); // insert data
				
			}
		});
		return false;
	});
  $('.online-selection').submit(function(){
		var form = $('.online-selection');
		$.ajax({
			url:form.attr('action'),
			data:form.serialize(), // form data
			type:form.attr('method'), // POST
			beforeSend:function(xhr){

			},
			success:function(data){
				form.html(data); // insert data
			}
		});
		return false;
	});
  $('#filter').on('click', 'input.btn-reset', function(){
    $('#filter')[0].reset();
    $('#filter select').trigger('change.select2');
    $('#filter').trigger('submit');
  });

  $('.modal-link a').on('click', function(){
    var id = $(this).attr('href');
    $(id).modal();
  });

  function allstars_spec_sort(){
    if($('.spec_select select, select.spec_select').length > 0 && $('.prof_select select, select.prof_select').length > 0){
      var choice_spec = $('.spec_select select, select.spec_select').val();
      $('.prof_select select, select.prof_select').find('option').each(function(){
        if($(this).val().indexOf(choice_spec) >= 0){
          $(this).removeAttr('disabled');
        }else{
          $(this).attr('disabled', 'disabled');
        }
        if($(this).val() == ''){
          $(this).removeAttr('disabled');
        }
      });
    }
  }
  allstars_spec_sort();
  $('.spec_select select, select.spec_select').on('change', function(){
    allstars_spec_sort();
    if($('.prof_select select, select.prof_select').find('option[value=""]').length > 0){
      $('.prof_select select, select.prof_select').find('option[value=""]').attr('selected', 'selected');
      $('.prof_select select, select.prof_select').trigger('change');
    }else{
      $('.prof_select select, select.prof_select').val([]);
    }
    $('.prof_select select, select.prof_select').trigger('change');
  });
  $('input.phone, .phone input').mask('8 000 000-00-00', {placeholder: "8 ___ ___-__-__"});

  $('#loginform').find('input:not([type="submit"])').each(function(){
    $(this).attr('required', 'required');
  });
  if (window.innerWidth < 1200) {
    document.querySelector('.menu_katalog').onclick = function () {
      document.querySelector('.drop_down_menu').classList.toggle('open');
    }
  }
});

 //слайдер  slick на -все звезды- под фотками
 
 jQuery('#mini-slider-adaptiv').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: false,
  adaptiveHeight: true,
  infinite: false,
  useTransform: true,
  speed: 400,
  //autoplay:true,
  dots:true,
  cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
 });


// Отображение изображения перед загрузкой 
/*--------- Главное изображение  --------*/

jQuery("#acf-field_5f0da43e008a1-field_5f0da47a008a2").bind("change", function(){
		 	readUrlmain(this);
		 });
readUrlmain = function(input) {
		if(input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
			 let imgmain = jQuery(".acf-field-5f0da47a008a2 img").attr("src", e.target.result).attr("id", "imgmain");
			 jQuery(".acf-field-5f0da47a008a2 label.acf-basic-uploader").append(imgmain);			  
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

/*--------- 1 изображение  -----------*/

jQuery("#acf-field_5f0da43e008a1-field_5f0da5e0008a4").bind("change", function(){
		 	readUrl1(this);
		 });
readUrl1 = function(input) {
		if(input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
			 let img1 = jQuery(".acf-field-5f0da5e0008a4 img").attr("src", e.target.result);
			 jQuery(".acf-field-5f0da5e0008a4 label.acf-basic-uploader").append(img1);
			  
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
/*--------- 2 изображение  -----------*/

jQuery("#acf-field_5f0da43e008a1-field_5f0da5f4008a5").bind("change", function(){
		 	readUrl2(this);
		 });
readUrl2 = function(input) {
		if(input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
			 let img2 = jQuery(".acf-field-5f0da5f4008a5 img").attr("src", e.target.result);
			 jQuery(".acf-field-5f0da5f4008a5 label.acf-basic-uploader").append(img2);
			  
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
/*--------- 3 изображение  -----------*/
jQuery("#acf-field_5f0da43e008a1-field_5f0da612008a6").bind("change", function(){
		 	readUrl3(this);
		 });
readUrl3 = function(input) {
		if(input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
			 let img3 = jQuery(".acf-field-5f0da612008a6 img").attr("src", e.target.result);
			 jQuery(".acf-field-5f0da612008a6 label.acf-basic-uploader").append(img3);
			  
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

//Добавляем пункт меню в футере 
 let ullifix = jQuery("#menu-item-fix");
 jQuery("#footer-menu").append(ullifix);
			 

// Добавление рекомендации загрузки изображения 520 на 400 
	jQuery(document).ready(function($) {
		jQuery(".acf-field .main_img .acf-basic-uploader::after").css("content","Рекомендуем загружать фото: 520 на 400 px, иначе фото будет обрезано автоматически");

	});
	
// Добавление id в выбор городов в личном кабинете  
	jQuery(document).ready(function($) {
		jQuery("#fix47 .select2-search").css("marginLeft","10px");

	});

if(document.querySelector('#cities')){	
  const select = document.querySelector('#cities').getElementsByTagName('option');
      for (let i = 0; i < select.length; i++) {
      if (select[i].label === document.getElementById("geo_promo_cityname").innerText) 
        {
          select[i].selected = true;
          //location.reload();							
        }
    }
  }
  
 if(document.querySelector('#postercity')){	
    const select = document.querySelector('#postercity').getElementsByTagName('option');    
        for (let i = 0; i < select.length; i++) {       
         if (select[i].label === document.getElementById("geo_promo_cityname").innerText) 
          {
            select[i].selected = true;            						
          }
      }
    }    

jQuery(document).ready(function($) {		
		jQuery('#submitid').click(function() {
            trmp = $("#cities option:selected").text();			
			trmp2 = $("#geo_promo_cityname").text();			
			$("#geo_promo_cityname").html(trmp)
       });
});	

// Привязка события к кнопке "Показать еще" в разделе мероприятия артиста

jQuery(function($){   
  const afishahide = ( count ) => { 
    $(`.count-for-btn:nth-child(${count}`).hide();
  }  

  let countdiv = $('.single-afisha__input').attr('data-count'); 
   
    for(i=4;i<=countdiv;i++) {
      afishahide( i );
    }  

  $('#single-afisha__footer-btn').on('click',function(){ 
  
    $('.count-for-btn').each(function( index, value ){
     
      console.log('Индекс: ' + index + '; Значение: ' + $(value).attr('style'));
      if ($(value).attr('style') == "display: none;") {        
        $(value).show();
        elemCount = $('.count-for-btn').length-1;      
        if (index == elemCount) {
          $('.single-afisha__footer-btn').hide();
        }
        return false;
      }
     
    })  
  });

 // скрытие кнопки
   elemCount = $('.count-for-btn').length;       
           
   if (elemCount<=3) {
       $('.single-afisha__footer-btn').hide();
   }
});	

// Скрываем не активные стрелки

jQuery(document).ready(function($) {		
  jQuery('li.disabled').hide();
});	

// Скрываем кнопку биржа

jQuery(document).ready(function($) {		
  jQuery('.static-container__content').hide();
});	

// Фильтр выборки звезд (артистов )

jQuery(function($){   
  function viewer(request){     
   
    let filter = JSON.parse(request);    

    let count_all = filter['count_all'];
    let count_private = filter['count_frequent'];
    let count_agency = filter['count_agency'];
    $('#count_all_js').html(count_all);
    $('#count_private_js').html(count_private);
    $('#count_agency_js').html(count_agency);
  } 
  $( "#cities, #filter_specialization, #filter_profile_direction, input:radio[name=rating], input:radio[name=performers]" ).change(function() {        
      let stars_filter = document.querySelector('#filter');
      let getDateForm = new FormData(stars_filter);
      
      getDateForm.append("action", "allstars_filter_global"); 
      $.ajax({
          url:'/wp-admin/admin-ajax.php', 
          data:getDateForm,
          processData : false,
          contentType : false,              
          type:'POST',  
          success:function(request){                               
            $('#stars').html(request);           
            let stars_filter = document.querySelector('#filter');         

            let city_quantity = $('#headercity').attr("data-city");          
            let filter_city_quantity = $('#select2-cities-container').attr("title");  
            let getFormCount = new FormData(stars_filter);

            getFormCount.append("action", "allstars_filter_global_quantity");                            
            getFormCount.append("header_city_quantity", city_quantity); 
            getFormCount.append("filter_city_quantity", filter_city_quantity); 

            $.ajax({
              url:'/wp-admin/admin-ajax.php', 
              data:getFormCount,
              processData : false,
              contentType : false,              
              type:'POST',  
               success:function(request){                                            
                   viewer(request);                              
                }  
              }); 
                             
          }    

      });
      
  });   
});

// Фиксация фильтра при скроле 

jQuery(document).ready(function($) {
 
  	if(null!==document.querySelector("#filter-wrapper"))	{
		let height_top = $("#filter-wrapper").offset().top;       

		let content_sroll_height = $("#content_sroll").height(); 
		let height_filter = $("#filter-wrapper").height();  
		const bott = 75; // border-bottom
    			
		let stopScroll = ((height_top+content_sroll_height)- height_filter)-bott;   

		let stopDown = (stopScroll-height_top)-bott; 
        
		$(window).scroll(function() {  
			let footer_top = $(".polotno").offset().top;        

			let sTop = $(window).scrollTop();    
         
			if(sTop > height_top &&(sTop < stopScroll)) {	      	
			  jQuery("#filter-wrapper").css("position","sticky").css("top","42px" ).css("marginBottom","44px");        
			} 
      if(sTop > stopScroll) {
          jQuery("#filter-wrapper").offset({top:stopScroll});        
      }
      if((sTop < height_top)) {
        jQuery("#filter-wrapper").offset({top:height_top});      
    }
		});

  }

	});

  // Фильтрация звезд по городам после загрузки страницы

  jQuery(function($){ 
    
    function viewer(request){     
   
      let filter = JSON.parse(request);    

      let count_all = filter['count_all'];
      let count_private = filter['count_frequent'];
      let count_agency = filter['count_agency'];
      $('#count_all_js').html(count_all);
      $('#count_private_js').html(count_private);
      $('#count_agency_js').html(count_agency);
    }
        let city = $('#headercity').attr("data-city");          
        let filter_city = $('#select2-cities-container').attr("title");      

        let getDateForm = new FormData();       
        
        getDateForm.append("action", "allstars_filter_global"); 
        getDateForm.append("header_sity", city); 
        getDateForm.append("filter_city", filter_city); 
        $.ajax({
            url:'/wp-admin/admin-ajax.php', 
            data:getDateForm,
            processData : false,
            contentType : false,              
            type:'POST',  
            success:function(request){                               
              $('#stars').html(request);              

              let city_quantity = $('#headercity').attr("data-city");          
              let filter_city_quantity = $('#select2-cities-container').attr("title");  
              let getFormCount = new FormData();

              getFormCount.append("action", "allstars_filter_global_quantity");                            
              getFormCount.append("header_city_quantity", city_quantity); 
              getFormCount.append("filter_city_quantity", filter_city_quantity); 

              $.ajax({
                url:'/wp-admin/admin-ajax.php', 
                data:getFormCount,
                processData : false,
                contentType : false,              
                type:'POST',  
                 success:function(request){                                            
                     viewer(request);                              
                  }  
                });                                   
                               
            }   
        });   
  
  });
  jQuery(function($){ 

  $.datepicker.regional['ru'] = {
    closeText: 'Закрыть',
    prevText: 'Предыдущий',
    nextText: 'Следующий',
    currentText: 'Сегодня',
    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
    weekHeader: 'Не',
    dateFormat: 'dd.mm.yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
  $.datepicker.setDefaults($.datepicker.regional['ru']); 

  });

  jQuery(function(){
    jQuery(".posterdate").datepicker();
  });