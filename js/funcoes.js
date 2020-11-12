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


function like_post(data){
    var post_id = $(data).data('id');
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
        url: "like_post",
        data: {
            'action': action,
            'post_id': post_id 
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

            $btn_clicado.siblings('span.like_count').text(res.likes);
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
    }
}

function limite_textarea(valor) {
    quant = 20000;
    total = valor.length;
    if(total <= quant) {
        resto = quant - total;
        document.getElementById('cont').innerHTML = resto;
    } else {
        document.getElementById('texto').value = valor.substr(0,quant);
    }
}

// function mostrarTexto(div) {
//     var display = document.getElementById(div).style.display;
//     document.getElementById(div).style.display = 'inline-block';
// }

// function ocultar(div) {
//     document.getElementById(div).style.display = 'none';
// }

function buscar_cidades(){
    var select = document.getElementById('id_regiao_estado');
	var value = select.options[select.selectedIndex].value;


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax ({
        type: 'post',
        url: "buscar_cidades",
        data: {
            'id_estado': value 
        },
        success: function(data){
            res = JSON.parse(data);
            cidades = res;
            var listCidades = document.getElementById("id_regiao_cidade");

            while (listCidades.length) {
                listCidades.remove(0);
            }

            for(i = 0; i < cidades[0].length; i = i + 1) {
                var opt0 = document.createElement("option");
                opt0.value = cidades[0][i]['id_regiao_cidade'];
                opt0.text = cidades[0][i]['nome_cidade'];
                listCidades.add(opt0, listCidades.options[0]);
                
            }
        }
    })
};

function modal(id) {
    $('post'+id).modal({
        show: true
    })
    $('.modal')
        .on({
            'show.bs.modal': function() {
                var idx = $('.modal:visible').length;
                $(this).css('z-index', 1040 + (10 * idx));
            },
            'shown.bs.modal': function() {
                var idx = ($('.modal:visible').length) - 1; // raise backdrop after animation.
                $('.modal-backdrop').not('.stacked')
                .css('z-index', 1039 + (10 * idx))
                .addClass('stacked');
            },
            'hidden.bs.modal': function() {
                if ($('.modal:visible').length > 0) {
                    // restore the modal-open class to the body element, so that scrolling works
                    // properly after de-stacking a modal.
                    setTimeout(function() {
                        $(document.body).addClass('modal-open');
                    }, 0);
                }
            }
        });
};

function show_modal(ele) {
    var id_modal = document.getElementById('img_modal');
    let imgs = document.querySelector('#'+ele);
    let modalImg = document.querySelector('#img_post1');
    let btClose = document.querySelector('.btnClose');
    let srcVal = "";

    
    srcVal = imgs.getAttribute('src');
    modalImg.setAttribute('src', srcVal);
    id_modal.classList.toggle('modal_active');
}

function hide_modal() {
    var id_modal = document.getElementById('img_modal');
    id_modal.classList.toggle('modal_active');
}


$(document).ready(function(){

	var $modal = $('#modal_cropp_perfil');

	var image = document.getElementById('sample_image');

	var cropper;

	$('#img_usuarios').change(function(event){
		var files = event.target.files;

		var done = function(url){
			image.src = url;
			$modal.modal('show');
		};

		if(files && files.length > 0)
		{
			reader = new FileReader();
			reader.onload = function(event)
			{
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
		}
	});

	$modal.on('shown.bs.modal', function() {
		cropper = new Cropper(image, {
			aspectRatio: 1,
			viewMode: 2,
			preview:'.preview'
		});
	}).on('hidden.bs.modal', function(){
		cropper.destroy();
   		cropper = null;
    });

	$('#crop').click(function(){
		canvas = cropper.getCroppedCanvas({
			width:400,
			height:400
        });

		canvas.toBlob(function(blob){
			url = URL.createObjectURL(blob);
			var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function(){
                var base64data = reader.result;
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

				$.ajax({
					url:'cropp_image',
					type:'POST',
					data:{
                        image : base64data
                    },
					success:function()
					{
						$modal.modal('hide');
						window.location.reload()
					}
				});
			};
		});
	});
	
});


$(document).ready(function(){

	var $modal = $('#modal_cropp_capa');

	var image = document.getElementById('sample_image_capa');

	var cropper;

	$('#imgs_capa').change(function(event){
		var files = event.target.files;

		var done = function(url){
			image.src = url;
			$modal.modal('show');
		};

		if(files && files.length > 0)
		{
			reader = new FileReader();
			reader.onload = function(event)
			{
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
		}
	});

	$modal.on('shown.bs.modal', function() {
		cropper = new Cropper(image, {
			aspectRatio: 4,
			viewMode: 2,
            preview:'.preview_capa',
		});
	}).on('hidden.bs.modal', function(){
		cropper.destroy();
   		cropper = null;
    });

	$('#crop_capa').click(function(){
		canvas = cropper.getCroppedCanvas({
			width:1150,
			height:270
        });

		canvas.toBlob(function(blob){
			url = URL.createObjectURL(blob);
			var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function(){
                var base64data = reader.result;
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

				$.ajax({
					url:'cropp_image_capa',
					type:'POST',
					data:{
                        image : base64data
                    },
					success:function()
					{
						$modal.modal('hide');
						window.location.reload()
					}
				});
			};
		});
	});
	
});





