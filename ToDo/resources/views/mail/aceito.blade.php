@component('mail::message')
Olá,  {{-- use double space for line break --}}
O seu cadastro foi aceito

Clique no botão abaixo para acessar o nosso site
@component('mail::button', ['url' => 'http://127.0.0.1:8000/'])
Ir para o Site
@endcomponent
Agradecemos pelo seu cadastro, Repositorio de Ideias ToDo.
@endcomponent