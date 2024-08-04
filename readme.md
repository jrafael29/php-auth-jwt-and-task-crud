# Estudo/Pratica

Aplicação feita para estudo. Autenticação com JWT e CRUD de Tasks, utilizando uma mistura de conceitos na arquitetura / estrutura do codigo.

> No arquivo schema.db em ./db/, há as instruções para criações das tabelas. Conecte-se a um banco de dados e execute-as.

## Para rodar a aplicação localmente:
- Clone o projeto
- Instale as dependencias
`composer install --ignore-platform-reqs`

- Inicie o servidor local
`php -S localhost:8888`

## Exemplo de requisições HTTP para teste:

### Criar um usuario
`curl -X POST -d '{"name":"User Test","email":"test@mail.com","password":"123456"}' http://localhost:8888/register.php`

### Autenticar um usuario
`curl -X POST -d '{,"email":"test@mail.com","password":"123456"}' http://localhost:8888/login.php`

Ao Possuir o Bearer Token, altere o do exemplo, pelo o seu.

### Criar uma task
`curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer x.y.z" -d '{"description":"Task Title"}' http://localhost:8888/create_task.php`

### Buscar tasks
`curl -X GET -H "Content-Type: application/json" -H "Authorization: Bearer x.y.z" http://localhost:8888/get_tasks.php`


_José Rafael_