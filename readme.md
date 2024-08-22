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

#### Criar um usuario
`curl -X POST -d '{"name":"User Test","email":"rafaelsilva9240@hotmail.com","password":"123456"}' http://localhost:8888/register.php`

#### Autenticar um usuario
`curl -X POST -d '{"email":"rafaelsilva9240@hotmail.com","password":"123456"}' http://localhost:8888/login.php`

#### Confirmar código de autenticação
`curl -X POST -d '{"email":"rafaelsilva9240@hotmail.com","code":"123456"}' http://localhost:8888/confirmate_code.php`

## Ao Possuir o Bearer Token, altere o do exemplo, pelo o seu.

#### Criar uma task
`curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer x.y.z" -d '{"description":"Task Title"}' http://localhost:8888/create_task.php`

#### Buscar tasks
`curl -X GET -H "Content-Type: application/json" -H "Authorization: Bearer x.y.z" http://localhost:8888/get_tasks.php`

#### Remover uma task
`curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer x.y.z" -d '{"id":"1"}' http://localhost:8888/delete_task.php`

#### Atualizar uma task
`curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer x.y.z" -d '{"id":"1","description":"alterando","done":"0"}' http://localhost:8888/update_task.php`

_José Rafael_