@component('mail::message')
Olá,  {{-- use double space for line break --}}
A sua solicitação foi recusada devido a decisão do administrador.

Clique no botão abaixo para acessar o nosso site
@component('mail::button', ['url' => 'http://localhost/ToDo/'])
Ir para o Site
@endcomponent
Agradecemos pela sua compreensão, ToDo Ideias.
@endcomponent