@component('mail::message')
Olá,  {{-- use double space for line break --}}
O seu cadastro foi aceito

Clique no botão abaixo para acessar o nosso site
@component('mail::button', ['url' => 'http://localhost/ToDo/'])
Ir para o Site
@endcomponent
Bem vindo ao site, ToDo Ideias.
@endcomponent