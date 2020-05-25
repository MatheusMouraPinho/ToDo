$(function(){
    $(".mostrar").click(function(){
        $(this).siblings("#comentarios").toggle("slow");   
        
    }); 
});

function onlynumber(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    //var regex = /^[0-9.,]+$/;
    var regex = /^[0-9.]+$/;
    if( !regex.test(key) ) {
       theEvent.returnValue = false;
       if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

$(document).ready(function(){
    
    // Quando o usuário clicar no curtir
    $('.curtir').on('click', function(){
        
        var coment_id = $(this).data('id');
        $btn_clicado = $(this);
    
    
        if($btn_clicado.hasClass("fa-thumbs-o-up")){
            action = 'like';
        } else if ($btn_clicado.hasClass("fa-thumbs-up")) {
            action = 'unlike';
        }
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax ({
            type: 'post',
            url: "/like",
            data: {
                'action': action,
                'coment_id': coment_id 
            },
            success: function(data){
                res = JSON.parse(data);
    
                if(action == 'like') {
                    $btn_clicado.removeClass('fa-thumbs-o-up');
                    $btn_clicado.addClass('fa-thumbs-up');
                } else if(action = 'unlike') {
                    $btn_clicado.removeClass('fa-thumbs-up');
                    $btn_clicado.addClass('fa-thumbs-o-up');
                }
    
                $btn_clicado.siblings('span.likes').text(res.likes);
            }
        })
    });
    
    $('.subcurtir').on('click', function(){
        var btn_like = $('#btn_like');
        var subcoment_id = $(this).data('id');
        $btn_clicado = $(this);
        $btn_clicado.prop('disabled', true);
        btn_like.prop('disabled', true);
    
    
        if($btn_clicado.hasClass("fa-thumbs-o-up")){
            action = 'like';
        } else if ($btn_clicado.hasClass("fa-thumbs-up")) {
            action = 'unlike';
        }
    
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
    
        $.ajax ({
            type: 'post',
            url: "/like",
            data: {
                'action': action,
                'subcoment_id': subcoment_id 
            },
            success: function(data){
                res = JSON.parse(data);
    
                if(action == 'like') {
                    $btn_clicado.removeClass('fa-thumbs-o-up');
                    $btn_clicado.addClass('fa-thumbs-up');
                } else if(action = 'unlike') {
                    $btn_clicado.removeClass('fa-thumbs-up');
                    $btn_clicado.addClass('fa-thumbs-o-up');
                }
    
                $btn_clicado.siblings('span.likes').text(res.likes);
                btn_like.prop('disabled', false);
            }
        })
    });

});





