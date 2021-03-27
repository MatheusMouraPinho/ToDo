# Repositorio de Ideias (ToDo)

Baixar o projeto:

No local xampp/htdocs usar no git bash o comando "git clone git@github.com:MatheusMouraPinho/ToDo.git".

Descompactar Vendor.zip e importar o SQL no phpMyAdmin

Utilizar o site https://mailtrap.io como caixa de email e pegar o username e password pra editar o arquivo ENV.

----------------------------------------------------------------------------------------------------------------------------------------

Caso ocorra o erro "MSQL SERVER AS GONE AWAY"

alterar my.ini(xampp Control->mysql config->my.ini): max_allowed_packet=500M (Definitiva)

ou

Via SQL: SET GLOBAL max_allowed_packet=1073741824 (Temporario ate o reinício do server)

----------------------------------------------------------------------------------------------------------------------------------------

Dependencias Utilizadas:

composer require laravel/ui

php artisan ui bootstrap --auth

npm install && npm run dev

composer require appzcoder/crud-generator --dev

----------------------------------------------------------------------------------------------------------------------------------------

Utilizar Xampp na Versão 7.4.16 pois a 8.0.3 não funciona
