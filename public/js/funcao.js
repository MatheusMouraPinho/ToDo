$(function(){
    $(".mostrar").click(function(){
        $(this).siblings("#comentarios").toggle("slow");
        
    });

    $(".exibir").click(function(){
        $("#respostas").toggle("slow");
        
    });

    
});