# Repositorio de Ideias (ToDo)

baixar o projeto:

no local xampp/htdocs (ou a pasta que vc quiser) usar no git bash " git clone git@github.com:MatheusMouraPinho/ToDo.git " ira baixar os arquivos ja com o git do github.

----------------------------------------------------------------------------------------------------------------------------------------

Dependencias Utilizadas:

composer require laravel/ui

php artisan ui bootstrap --auth

npm install && npm run dev

composer require appzcoder/crud-generator --dev

----------------------------------------------------------------------------------------------------------------------------------------

Caso o site não mude ao alterar, substituir ou apagar algo:  

php artisan view:clear
php artisan cache:clear
php artisan config:clear

----------------------------------------------------------------------------------------------------------------------------------------

Utilizar o site https://mailtrap.io e pegar as credenciais pra editar o arquivo config/mail.php e substituir o codigo

Exemplo:

return [
  "driver" => "smtp",
  "host" => "smtp.mailtrap.io",
  "port" => 2525,
  "from" => array(
      "address" => "from@example.com",
      "name" => "Example"
  ),
  "username" => "o site gera isso",          <----
  "password" => "o site gera isso",          <----
  "sendmail" => "/usr/sbin/sendmail -bs"
];
----------------------------------------------------------------------------------------------------------------------------------------
Utilizar o comando para armazenar as imagens:

php artisan storage:link
