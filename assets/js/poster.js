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

// Событие после выбора даты

jQuery(function($){    
    $( "#posterdate" ).change(function() {
        const posterdate = $('#posterdate').val();                    
        var data = {
            'action': 'afisha_date',            
            'posterdate': posterdate
        };
        $.ajax({
            url:'/wp-admin/admin-ajax.php', 
            data:data, 
            type:'POST', 
            success:function(request){                               
                $('#show_post2').html(request);
                $('#poster__btn').hide();                
                               
            }

        });
        
    });   
});

// Событие после выбора города

jQuery(function($){    
    $( "#postercity" ).change(function() {
        const postercity = $('#postercity').val();                 
        var data = {
            'action': 'afisha_city',            
            'postercity': postercity
        };
        $.ajax({
            url:'/wp-admin/admin-ajax.php', 
            data:data, 
            type:'POST', 
            success:function(request){                                       
               $('#show_post2').html(request);
               $('#poster__btn').hide();                
                               
            }

        });
        
    });   
});

// Событие после выбора формата мероприятия

jQuery(function($){    
    $( "#posteroffon" ).change(function() {
        const posteroffon = $('#posteroffon').val();                 
        var data = {
            'action': 'afisha_posteroffon',            
            'posteroffon': posteroffon
        };
        $.ajax({
            url:'/wp-admin/admin-ajax.php', 
            data:data, 
            type:'POST', 
            success:function(request){                                       
               $('#show_post2').html(request);
               $('#poster__btn').hide();                
                               
            }

        });
        
    });   
});

// Событие после выбора исполнителя

jQuery(function($){    
    $( "#posterperformer" ).change(function() {
        const posterperformerid = $('#posterperformer').val();                          
        var data = {
            'action': 'afisha_posterperformer',            
            'posterperformerid': posterperformerid
        };
        $.ajax({
            url:'/wp-admin/admin-ajax.php', 
            data:data, 
            type:'POST', 
            success:function(request){
                //$('#test3').html(request);                               
                $('#show_post2').html(request);
                $('#poster__btn').hide();          
                               
            }

        });
        
    });   
});


