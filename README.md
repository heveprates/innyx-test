# Projeto

Este projeto contém a API em [Laravel](https://laravel.com/) e um SPA em [VueJs](https://vuejs.org/).

Foi utilizado como lib de UI o [Vuetify](https://vuetifyjs.com/), que fornece components em Vue 3 com o estilo baseado no Material Design.

## Front-end

Para começar com o projeto, siga estas etapas:

1. Clone o repositório
2. Navegue até a pasta `client`
3. Instale as dependências usando `npm install`
4. Inicie o servidor usando `npm run dev`
5. O Front-end vai estar disponivel no [APP](http://localhost:3000/)

## Back-end

Para começar com o projeto, siga estas etapas:

1. Clone o repositório
2. Navegue até a pasta `api`
3. Instale as dependencias com `composer install`
4. Copie o arquivo de env `cp .env.example .env`
5. Inicie os containers do PHP e do MySql com o comando `docker compose up`
6. O Back-end vai iniciar um servidor na porta 8000
7. Execute o comando `php artisan migrate:refresh --seed` dentro do container do PHP

## Acesso

O Projeto possui uma seed que inicia um usuario no banco de dados junto com algums dados de produtos e categorias.

Os dados de acesso são:

```
> email: innyx@user.test
> senha: 1234
```
