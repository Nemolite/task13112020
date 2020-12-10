/* Мероприятия. Добавление карточек по нажаитю на конопку Показать еще */
jQuery(function($){  
    let elemCount; 
    let offset = 18;  
    let addcount = 3;
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
                elemCount  = document.getElementsByClassName("poster_counter")[0].childElementCount;
                console.log(elemCount);                
            }
        });
    });
});

// Событие после выбора даты, города,
// формата мероприятия, исполнителя

jQuery(function($){    
    $( "#posterdate, #postercity, #posteroffon, #posterperformer" ).change(function() {
        console.log(111);
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



