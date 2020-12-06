jQuery(document).ready(function($){
  function isUrlValid(url) {
    return /^(http?|https?):\/\/(.*)$/i.test(url);
  }
  function getYoutubeId(url){
    var result = url.match(/(http?|https?):\/\/(.*)\?v=([^#\&\?]*).*/);
    return result[result.length - 1];
  }
  function generation_video_img(){
    var input_video = $('.acf-field.icon_bg.video input[type="text"]');
    if(input_video.val() !== ''){
      var link = input_video.val();
      var id = '';
      if(!isUrlValid(link)){
        id = link;
      }else{
        id = getYoutubeId(link);
      }
      var url = 'https://www.youtube.com/watch?v='.id;
      var img = '<img id="youtube-video" src="https://i.ytimg.com/vi/'+id+'/hqdefault.jpg" alt="" data-url="'+url+'"/>';   
      input_video.parent().prepend(img);
    }
  } 
  function init_lk(){
    generation_video_img();
  }
  init_lk();
  $('body').on('change', '.acf-field.icon_bg.video input[type="text"]', function(){
    $(this).parent().find('#youtube-video').remove();
    generation_video_img();
  });
  $('.acf-field.ib').each(function(){
    if($(this).find('.acf-label p.description').length > 0){
      var desc = $(this).find('.acf-label p.description');
      $(this).find('.acf-input').after(desc);
    }
  });
  $('.acf-field.main_img').on('change', 'input[type="file"]', function(){
    console.log('add new image')
    $(this).closest('form').submit();
  });
});

// Скрытие / Открытие полей: Стоимость и Официальный сайт

jQuery(function($){ 
	$("#form-group-radio").change(function() {
		if ($("#gridRadios1").prop("checked")) {
      $('.show-radio-reg').css("display", "block");
			$('.show-radio').css("display", "none");  
		} else {      
      $('.show-radio-reg').css("display", "none");
			$('.show-radio').css("display","block" );  
		}
	});
});

// Скрытие / Открытие полей: Online / Offline

jQuery(function($){ 
	$("#form-group-radio-place").change(function() {
		if ($("#gridplace1").prop("checked")) {
      $('.show-radio-reg-place').css("display", "block");
			$('.show-radio-place').css("display", "none");  
		} else {      
      $('.show-radio-reg-place').css("display", "none");
			$('.show-radio-place').css("display","block" );  
		}
	});
});

/* AJAX отправление данных с модального окна мероприятия для записи в базу данных */


jQuery(function($){  
  let files; 
    $('input[type=file]').on('change', function(){
       file = this.files;
       $('#modal_submit').on('click',{param1: file}, function(event){         
        let modal_date = document.querySelector('#modal_date');
        let getDateForm = new FormData(modal_date);
        getDateForm.append("action", "modal_afisha");        
        $.ajax({
          url:'/wp-admin/admin-ajax.php', 
          data:getDateForm,
          processData : false,
          contentType : false, 
          type:'POST', 
          success:function(request){                       			
            console.log( request );								
          },
          error: function( err ) {
            console.log( err );            	
          }
      });

      });
    });  
  }); 

// Управление кнопками + и - 

jQuery(function($){
  const ShowHide = ( id ) => {  
	  $(`#plus${id}`).on('click',function() {		
      $(`.servisTextareahide${id+1}`).show();
    }); 
    $(`#minus${id}`).on('click',function() {		
      $(`.servisTextareahide${id}`).hide();
    });
    $(`#minus10`).on('click',function() {		
      $(`.servisTextareahide10`).hide();
    });
}   		
  for(i=1;i<=9;i++){
    ShowHide(i);		
  }
});

// Прием данных с формы услуги 
// и передача их на сервер


jQuery(function($){  
  $('#modal_servises').on('click', function(event){         
    let modal_date = document.querySelector('#modal_form_servises');
    let getServisesForm = new FormData(modal_date);
    getServisesForm.append("action", "modal_form_servises");        
        $.ajax({
          url:'/wp-admin/admin-ajax.php', 
          data:getServisesForm,
          processData : false,
          contentType : false, 
          type:'POST', 
          success:function(request){                      			
            console.log( request );            								
          },
          error: function( err ) {
            console.log( err );            	
          }      
      });
    });  
  }); 