## Instalação

```bash
$ git clone https://github.com/adevecchi/crud-cadastro-incidentes.git
$ cd crud-cadastro-incidentes
$ composer install
$ php -S localhost:8080 -t public
```

**Configurando usuário de acesso do MySQL**

Acessar o arquivo ***src/settings.php***

Seu conteúdo é mostrado abaixo:

```php
    // Database connection settings
    'db' => [
      'host' => 'localhost',
      'dbname' => 'dvq_red',
      'user' => '<seu_nome_de_usuario_aqui>',
      'pass' => '<sua_senha_de_usuario_aqui>'
    ]
```

Alterar conforme seus valores de acesso para o MySQL. O script para criar o Bando de Dados MySQL segue abaixo:

```sql
CREATE DATABASE `dvq_red`
	CHARACTER SET utf8
        COLLATE utf8_general_ci;

USE `dvq_red`;
    
CREATE TABLE `incidentes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  `criticidade` enum ('Alta', 'Média', 'Baixa') NOT NULL,
  `tipo` ENUM ('Ataque Brute Force', 'Credenciais Vazadas', 'Ataque de DDoS', 'Atividades anormais de usuário') NOT NULL,
  `status` ENUM ('Aberto', 'Fechado') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

que se encontra no arquivo ***script.sql***

# Cadastro de Incidentes.

CRUD para realizar cadastro de incidentes. Cada incidente possui:

- ID único
- Um título (obrigatório)
- Uma descrição (obrigatório)
- Criticidade (Alta, média ou baixa)
- Um tipo (obrigatório)
- Um status (aberto ou fechado). Todo incidente deverá ser cadastrado com status aberto

**Os tipos possíveis para incidentes são**
- Ataque Brute Force
- Credenciais vazadas
- Ataque de DDoS
- Atividades anormais de usuários

Captura de tela
---------------

![Tela principal](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/public/images/screenshot/index1.png)

![Tela principal](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/public/images/screenshot/index2.png)

![Tela adicionar](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/public/images/screenshot/add.png)

![Tela editar](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/public/images/screenshot/edit.png)

![Tela excluir](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/public/images/screenshot/delete.png)

Endpoints
---------

- Incidentes por página: `GET /api/incidentes/pagina/{pagina}`

![Endpoint](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/public/images/endpoits/get_incidentes_por_pagina.png)

- Incidentes por ID: `GET /api/incidentes/{id}`

![Endpoint](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/public/images/endpoits/get_incidentes_por_id.png)

- Adiciona incidente: `POST /api/incidentes`

![Endpoint](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/public/images/endpoits/post_incidentes.png)

- Atualiza incidente: `PUT /api/incidentes/{id}`

![Endpoint](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/public/images/endpoits/put_incidentes.png)

- Exclui incidente: `DELETE /api/incidentes/{id}`

![Endpoint](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/public/images/endpoits/delete_incidentes.png)



