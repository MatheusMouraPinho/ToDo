@component('mail::message')
Olá,  {{-- use double space for line break --}}
O seu cadastro foi recusado devido a decisão do administrador  
tente fazer outro cadastro porem com dados corretos.

Clique no botão abaixo para acessar o nosso site
@component('mail::button', ['url' => 'http://localhost/ToDo/'])
Ir para o Site
@endcomponent
Agradecemos pela sua compreensão, ToDo Ideias.
@endcomponent