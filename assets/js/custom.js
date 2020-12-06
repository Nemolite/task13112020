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

jQuery(document).ready(function($) {		
		jQuery('#submitid').click(function() {
            trmp = $("#cities option:selected").text();			
			trmp2 = $("#geo_promo_cityname").text();			
			$("#geo_promo_cityname").html(trmp)
       });
});	

// Привязка события к кнопке "Показать еще" в разделе мероприятия артиста

jQuery(function($){  
  let elemCount; 
  let offset = 3;  
  let showcount = 1;
  $('#single-afisha__footer-btn').on('click',function(){                 
      var data = {
          'action': 'show_afisha_star',
          'offset' : elemCount?elemCount:offset ,
          'showcount': showcount
      };
      $.ajax({
          url:'/wp-admin/admin-ajax.php', 
          data:data, 
          type:'POST', 
          success:function(data){                               
              $('#show_afisha_star').append(data);
              elemCount  = document.getElementsByClassName("single-afisha")[0].childElementCount;
              console.log(elemCount);                
          }
      });
  });
});	
	