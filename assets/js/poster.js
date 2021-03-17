/* Мероприятия. Добавление карточек по нажаитю на конопку Показать еще */
jQuery(function($){  
    let elemCount; 
    let offset = 15;  
    let addcount = 3;
    let counter;
    $('#poster__btn').on('click',function(){ 
                         
        var data = {
            'action': 'adding_afisha',
            'offset' : elemCount?elemCount:offset ,
            'addcount': addcount
        };
        $.ajax({
            url:'/wp-admin/admin-ajax.php', 
            data:data, 
            type:'POST', 
            success:function(data){                               
                $('#show_post2').append(data);
                counter = $('#poster__btn').attr('data-counter'); 
                elemCount  = document.getElementsByClassName("poster_counter")[0].childElementCount;                
                if(counter==elemCount){
                    $('#poster__btn').hide();
                }                
            }
        });
    });
});

// Событие после выбора даты, города,
// формата мероприятия, исполнителя

jQuery(function($){    
    $( "#posterdate, #postercity, #posteroffon, #posterperformer" ).change(function() {       
              
        let super_filter = document.querySelector('#super_filter');
        let getDateForm = new FormData(super_filter);
        getDateForm.append("action", "afisha_super_filter"); 
        $.ajax({
            url:'/wp-admin/admin-ajax.php', 
            data:getDateForm,
            processData : false,
            contentType : false,              
            type:'POST',  
            success:function(request){                                           
                $('#show_post2').html(request);
                $('#poster__btn').hide();                
                               
            }

        });
        
    });   
});


// Фильтрация афишы по городам после загрузки страницы

jQuery(document).ready(function($) {         
    let city_header = $('#headercity').attr("data-city");           
    let getDateFormAfisha = new FormData();          
    getDateFormAfisha.append("action", "afisha_super_filter"); 
    getDateFormAfisha.append("header_sity", city_header); 
    $.ajax({
        url:'/wp-admin/admin-ajax.php', 
        data:getDateFormAfisha,
        processData : false,
        contentType : false,              
        type:'POST',  
        success:function(request){                               
            $('#show_post2').html(request);                         
                           
        } 
    });   

});

// Фильтрация в афише при изменении города в хидере



jQuery(function($){   
    $("#geo_promo_cityname").bind("DOMSubtreeModified", function(){      
       
        if(document.querySelector('#postercity')){	
            const select = document.querySelector('#postercity').getElementsByTagName('option');    
                for (let i = 0; i < select.length; i++) {       
                 if (select[i].label === $(' [data-filter="action"] ').html()) 
                  {
                    select[i].selected = true;            						
                  }
              }
            } //if
           
    let city_header_new = $(' [data-filter="action"] ').html();            
    let getAfishaCity = new FormData();          
    getAfishaCity.append("action", "afisha_super_filter"); 
    getAfishaCity.append("city_header_new", city_header_new); 
    $.ajax({
        url:'/wp-admin/admin-ajax.php', 
        data:getAfishaCity,
        processData : false,
        contentType : false,              
        type:'POST',  
        success:function(request){                               
            $('#show_post2').html(request);                         
                           
        } 
    });

    });     
});



