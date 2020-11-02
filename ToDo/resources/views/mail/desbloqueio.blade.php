@component('mail::message')
Olá,  {{-- use double space for line break --}}
O seu email foi desbloqueado devido à decisão do administrador e 
o uso para cadastro em nosso site foi liberado.

Clique no botão abaixo para acessar o nosso site.
@component('mail::button', ['url' => 'http://localhost/ToDo/'])
Ir para o Site
@endcomponent
Agradecemos pela sua compreensão, ToDo Ideias.
@endcomponent