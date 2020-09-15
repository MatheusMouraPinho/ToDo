$(function(){
    $(".mostrar").click(function(){
        $(this).siblings("#comentarios").toggle("slow");   
        
    }); 
});

$(function(){
    $(".comentario").click(function(){
        $(this).siblings("#buttom_area").toggle("slow");   
        
    }); 
});

  function auto_grow(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight)+"px";
}


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



    
// Quando o usuário clicar no curtir
function like(data){
    var coment_id = $(data).data('id');
    $btn_clicado = $(data);
    

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
        url: "like",
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
};


function update() {
    var input = document.getElementById('file'); //define o id do input
    var infoArea = document.getElementById( 'file-name' );//define o id do resutado do script
    var fileName = input.files[0].name; //nome do arquivo que foi selecionado no input
    infoArea.textContent = 'File: ' + fileName; //define infoArea como texto que recebe fileName
}
function update2() {
    var input = document.getElementById('file2');
    var infoArea = document.getElementById( 'file-name2' );
    var fileName = input.files[0].name;
    infoArea.textContent = 'File: ' + fileName;
}
function update3() {
    var input = document.getElementById('file3');
    var infoArea = document.getElementById( 'file-name3' ); 
    var fileName = input.files[0].name;
    infoArea.textContent = 'File: ' + fileName;
}

function id(valor_campo) {
  return document.getElementById(valor_campo);
}

function getValor(valor_campo) {
  var valor = document.getElementById(valor_campo).value.replace(',', '.');
  return parseFloat(valor) * 100;    
}


function calcular (id_post) {
    if(isNaN(getValor('inovacao'+id_post)) || isNaN(getValor('complexidade'+id_post)) || isNaN(getValor('potencial'+id_post))) {
        id('media'+id_post).value = 'Valor inválido!';
    }else {
        var soma = getValor('inovacao'+id_post) + getValor('complexidade'+id_post) + getValor('potencial'+id_post);
        var media = soma / 3;
        media = media / 100;
        id('media'+id_post).value = media.toFixed(2);
        alert("oi");
    }
}





