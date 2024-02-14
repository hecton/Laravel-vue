Requisitos
Php 8.1^, Node 20.1^, Mysql, Compose, Algumas extensions do php talvez sejam nescessarias

- Para iniciar o projeto deve criar uma Base de Dados
- Rodar os camandos "composer install"
- copiar o .env.example para .env
    -configurar os campos DB_DATABASE, DB_USERNAME, DB_PASSWORD na .env
- rodar o camando "php artisan key:generate"
- rodar o camando "php artisan migrate --seed"
- rodar o camando "npm install"
- rodar o camando "npm run build"
- rodar o camando "php artisan serve"


- Para rodar os testes
"php artisan test"
