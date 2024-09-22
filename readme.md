# Estudo/Pratica

Aplicação feita para estudo. Autenticação com JWT e CRUD de Tasks, utilizando uma mistura de conceitos na arquitetura / estrutura do codigo.

> No arquivo schema.db em ./db/, há as instruções para criações das tabelas. Conecte-se a um banco de dados e execute-as.

Para criar uma nova rota, basta adiciona-la ao arquivo `routes.php`, e apontar a Classe::Função que será executada para lidar com a requisição.

## Dependencias
##### PHP, Mysql, Redis

## Para rodar a aplicação localmente:
- Clone o projeto
- Instale as dependencias
`composer install --ignore-platform-reqs`

- Inicie o servidor local
`php -S localhost:8888`

### Para testar requisições:
Veja o arquivo `test.http`

<hr>
_José Rafael_

