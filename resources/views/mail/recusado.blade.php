@component('mail::message')
Olá,  {{-- use double space for line break --}}
O seu cadastro foi recusado devido a decisão do administrador  
tente fazer outro cadastro porem com dados corretos.

Clique no botão abaixo para acessar o nosso site
@component('mail::button', ['url' => 'http://127.0.0.1:8000/'])
Ir para o Site
@endcomponent
Agradecemos pela sua compreensão, Repositorio de Ideias ToDo.
@endcomponent