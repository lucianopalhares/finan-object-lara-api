<p align="center"><img src="public/assets/img/cover.jpg" width="500" alt="Cover"></p>

## Finan Object Lara API

Microserviço para transações financeiras. Funcionalidades:

- Criar uma conta bancária
- Visualizar uma conta bancária
- Criar uma transação financeira com os metodos de pagamento Pix, Débito ou Crédito. Com o valor e a conta bancária.

### Tecnologias usadas:

* Framework Laravel 11 (php 8.4)
* API de Microserviço com as melhores práticas de design patterns
* Banco de dados Mysql
* Autenticação JWT
* Arquitetura DDD
* Teste unitário com PHPunit

### Instalação

#### instale a aplicação

```
docker-compose up -d
```

#### entre na aplicação laravel

```
docker exec -it finan_object_lara_app bash
```

#### instale as dependencias necessarias

```
composer install
```

#### crie o arquivo de configuração

```
cp .env.example .env
```

#### crie a chave da aplicação

```
php artisan key:generate
```

#### crie as tabelas do banco de dados

```
php artisan migrate
```

#### popule o banco de dados

```
php artisan db:seed
```

#### adicione permissão

```
chmod 777 -R storage bootstrap
```

### observabilidade com Sentry (acompanhamento de erros)

    -   acesse a seguinte url para acompanhar os erros da aplicação =

usuário e senha =

```
xebok35047@fundapk.com
```

```
dK54865*hh
```

https://test-dby.sentry.io/organizations/test-dby/issues/?project=4508786073862144&statsPeriod=14d

### Exemplo de uso [criar ou realizar login com usuário]:

#### crie um usuário pela api

metodo: POST
url:
```
http://localhost:8000/api/register
```
body:
```
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

a conta do usuário sera criada
e um token de acesso sera gerado

#### se usuário ja foi criado, faça login

metodo: POST
url:
```
http://localhost:8000/api/login
```
body:
```
{
    "email": "john@example.com",
    "password": "password"
}
```

um token de acesso sera gerado

#### se usuário ja esta logado e deseja apenas pegar os dados

metodo: GET
url:
```
http://localhost:8000/api/profile
```

#### sair da sessão do usuário

metodo: POST
url:
```
http://localhost:8000/api/logout
```

#### utilize o token para as proximas etapas

### Exemplo de uso [gerenciar transações]:


#### crie uma conta bancária

    -   numero_conta: digitos numerais
    -   saldo: valor em reais

metodo: POST
authorization: BearerToken (use o token gerado)
url:
```
http://localhost:8000/api/conta
```
body:
```
{
    "numero_conta":"3334",
    "saldo":489.58
}
```

#### visualizar uma conta bancária

metodo: GET
authorization: BearerToken (use o token gerado)
url:
```
http://localhost:8000/api/conta?numero_conta=5855
```

#### realizar uma transação financeira

    -   forma_pagamento: D para débito, C para crédito e P para pix
    -   numero_conta: digitos numerais
    -   valor: valor em reais

metodo: POST
authorization: BearerToken (use o token gerado)
url:
```
http://localhost:8000/api/transacao
```
body:
```
{
    "forma_pagamento":"D",
    "numero_conta":5855,
    "valor":10.58
}
```

#### execute os testes, serão rodados os seguintes testes:

    -   criar transação
    -   criar conta
    -   exibir uma conta

```
php artisan test --testsuite=Feature
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
