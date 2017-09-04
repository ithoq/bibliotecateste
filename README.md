# ZendSkeletonApplication

## Introdução

Teste de emprego para a empresa Madeira Madeira


## Utilizando docker-compose

Utilize o `docker-compose.yml` para utilizar o
[docker-compose](https://docs.docker.com/compose/); Este arquivo utiliza `Dockerfile` para criar o servidor. 
Como Buildar e iniciar a imagem:

```bash
$ docker-compose up -d --build
```

Acesse http://localhost:8080 para ver o site.

O nome da imagem será
"zf", então para executar comandos no servidor execute `docker-compose run`:

```bash
$ docker-compose run zf composer install
```

## Mysql

Para executar o mysql, acesso pela porta 3319 e após conectar, abra o arquivo `DOCS\mysql-structure.sql` e execute no schema `biblioteca`

Após isso, acessa o sistema com o usuário `rm.moriya@gmail.com` com a senha `123123`
