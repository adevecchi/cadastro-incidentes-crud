## Instalação:

### Requisitos:

- Composer.
- PHP.
- MySQL.
- Servidor Apache.

### Criação de diretório virtual (Linux):

Abaixo segue os comandos para criação do diretório virtual:

**Comandos:**

```bash
# cria diretório virtual
$ sudo mkdir -p /var/www/html/devaslab.com

# Concede permissões
$ sudo chown -R $USER:$USER /var/www/html/devaslab.com

$ sudo chmod -R 755 /var/www/html/devaslab.com

# Cria novo arquivo Virtual Hosts
$ sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/devaslab.com.conf

# Abrir arquivo devaslab.com.conf para edição
$ sudo nano /etc/apache2/sites-available/devaslab.com.conf
```

Com o arquivo ***devaslab.com.conf*** aberto, apagar seu conteúdo e entrar com o que segue abaixo:

```text
<VirtualHost *:80>
	ServerAdmin admin@devaslab.com
	ServerName devaslab.com
	ServerAlias www.devaslab.com
	DocumentRoot /var/www/html/devaslab.com
	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined
	<Directory /var/www/html/devaslab.com/>
		Options Indexes FollowSymLinks
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>
```
```bash
# Ativar o Virtual Host
$ sudo a2ensite devaslab.com.conf

# Reiniciar o Servidor Apache
$ sudo systemctl restart apache2

# Configurar arquivo de host local
$ sudo namo /etc/hosts
```
Com o arquivo ***hosts*** aberto, adicionar ao final do arquivo o que segue abaixo:

```text
127.0.0.1   devaslab.com
```

## Instalação dos arquivos:

Deve-se baixar o arquivo .zip ou realizar a clonagem do repositório.

Tendo os arquivos em sua maquina, deve-se copiar ou mover os arquivos para o diretório ***/var/www/html/devaslab.com***

A estrutua do diretório deve ficar como mostrado abaixo:

```text
devaslab.com/
|---api/
|---app/
|---extras/
|---templates/
|---.gitignore
|---index.html
|---LICENSE
|---README.md
```

**Instalando as dependencias com composer:**

Acessar o diretório ***devaslab.com/api*** e usar o seguinte comando:

```bash
$ composer install
```

**Configurando usuário de acesso do Banco de Dados MySQL**

Acessar o diretório ***devaslab.com/api/src*** e abrir o arquivo ***settings.php***

Seu conteúdo é mostrado abaixo:

```text
    // Database connection settings
    'db' => [
      'host' => 'localhost',
      'dbname' => 'teste_red',
      'user' => '<seu_nome_de_usuario_aqui>',
      'pass' => '<sua_senha_de_usuario_aqui>'
    ]
```

Alterar conforme seus valores de acesso para o MySQL. O código SQL para o MySQL segue abaixo:

```text
CREATE DATABASE `teste_red`
	CHARACTER SET utf8
  COLLATE utf8_general_ci;

USE `teste_red`;
    
CREATE TABLE `incidentes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titilo` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  `criticidade` enum ('Alta', 'Média', 'Baixa') NOT NULL,
  `tipo` ENUM ('Ataque Brute Force', 'Credenciais Vazadas', 'Ataque de DDoS', 'Atividades anormais de usuário') NOT NULL,
  `status` ENUM ('Aberto', 'Fechado') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

e o arquivo .sql encontra-se no diretório ***devaslab.com/extras/mysql/script.sql***


PROBLEMA
========
**Cadastro de Incidentes.**

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

Implementado apenas as telas para o CRUD, sem a necessidade de um Login, por exemplo.

Captura de tela da solução
--------------------------
![Tela principal](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/extras/screenshot/index1.png)

![Tela principal](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/extras/screenshot/index2.png)

![Tela adicionar](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/extras/screenshot/add.png)

![Tela editar](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/extras/screenshot/edit.png)

![Tela excluir](https://github.com/adevecchi/rest-api-slim-php-angularjs/blob/master/extras/screenshot/delete.png)

