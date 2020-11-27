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
});

// Скрытие / Открытие полей: Стоимость и Официальный сайт

jQuery(function($){ 
	$("#form-group-radio").change(function() {
		if ($("#gridRadios1").prop("checked")) {
			$('.show-radio').css("display", "none");  
		} else {
			$('.show-radio').css("display","block" );  
		}
	});
});

/* AJAX отправление данных с модального окна мероприятия для записи в базу данных */

jQuery(function($){      
    $('#modal_submit').on('click',function(){              
		const nameposter =  document.forms.modal_date.recipient_name.value;		
		const nameplace =  document.forms.modal_date.place_name.value;		
		const namecity =  document.forms.modal_date.exampleSelect1.value;		
		const namedate =  document.forms.modal_date.example_date_input.value;		
		const nametime =  document.forms.modal_date.example_time_input.value;		
		const namefile =  document.forms.modal_date.exampleInputFile.files;		
		const nameannouncement =  document.forms.modal_date.exampleTextarea.value;		
		const namepied =  document.forms.modal_date.example_number_input.value;		
		const nameradiopied =  document.forms.modal_date.gridRadios.value;		
		const nameurl =  document.forms.modal_date.example_url_input.value;	
		const nameuserid =  document.forms.modal_date.nameuserid.value;		
				
        var data = {
            'action': 'modal_afisha',            
            'nameposter': nameposter,
			'nameplace': nameplace,
			'namecity': namecity,
			'namedate': namedate,
			'nametime': nametime,
			'nameannouncement':nameannouncement,
			'namefile': namefile,
			'namepied': namepied,
			'nameradiopied': nameradiopied,
			'nameurl':nameurl,
			'nameuserid': nameuserid					
        };
        $.ajax({
            url:'/wp-admin/admin-ajax.php', 
            data:data, 
            type:'POST', 
            success:function(request){
				console.log('send');
                $( "#result-afisha" ).html( request );
				console.log(request);				
            },
			 error: function( err ) {
				console.log( err );
            }
        });
    });
});

