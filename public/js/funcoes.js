// function add_like(id_comentario){
    
//     $.post('../Helpers/Helper.php', {comentario_id: id_comentario}, function(dados){
//         alert('funcionou mesmo?');
//         if(dados == 'sucesso') {

//             get_like(id_comentario);
//         }else{
//             alert('Não foi possivel votar');
//         }
//     })
// }

// function get_like(id_comentario) {
//     $.post('Helpers/get_like.php', {comentario_id: id_comentario}, function(valor) {
//         $('#id_comentario_'+id_comentario).text(valor);
//     })
// }

// function un_like(id_comentario){
//     $.post('Helpers/un_like.php', { id_comentario: id_comentario }, function(valor){
//         if(valor == 'sucesso'){
//             location.href="../views/conta.blade.php";
//         }else{
//             alert("Desculpe, ocorreu algum erro");
//             location.href="/views/conta.blade.php";
//         }
//     })
// }

$(document).ready(function() {
    $(".curtir").click(function() {
        var id = this.id;
        $.ajax({
            url: 'Helpers/add_like.php',
            type:'POST',
            data:{id:id},
            dataType:'json',

            success:function(data){
                var likes = data ['likes'];
                var text = data['text'];

                $("#likes_"+id).text(likes);
                $("#"+id).text(text);
            }
        });
    });
});

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