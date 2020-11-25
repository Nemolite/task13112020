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





