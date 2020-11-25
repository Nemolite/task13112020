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

/* AJAX отправление данных с модального окна мероприятия для записи в базу данных */

jQuery(function($){      
    $('#modal_submit').on('click',function(){              
		const nameposter =  document.forms.modal_date.recipient_name.value;
		console.log(nameposter);
		const nameplace =  document.forms.modal_date.place_name.value;
		console.log(nameplace);
		const namecity =  document.forms.modal_date.exampleSelect1.value;
		console.log(namecity);
		const namedate =  document.forms.modal_date.example_date_input.value;
		console.log(namedate);
		const nametime =  document.forms.modal_date.example_time_input.value;
		console.log(nametime);		
		const namefile =  document.forms.modal_date.exampleInputFile.value;
		console.log(namefile);
		const namepied =  document.forms.modal_date.example_number_input.value;
		console.log(namepied);
		const nameradiopied =  document.forms.modal_date.gridRadios.value;
		console.log(nameradiopied);
		const nameurl =  document.forms.modal_date.example_url_input.value;
		console.log(nameurl);
		const nameuserid =  document.forms.modal_date.nameuserid.value;
		console.log(nameuserid);
				
        var data = {
            'action': 'modal_afisha',            
            'nameposter': nameposter,
			'nameplace': nameplace,
			'namecity': namecity,
			'namedate': namedate,
			'nametime': nametime,
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
                console.log(request);                
            },
			 error: function( err ) {
				console.log( err );
            }
        });
    });
});