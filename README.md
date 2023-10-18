# API - Usuarios com autentificação

---

- **Para rodar a API em sua máquina siga os seguintes passos:**

  - Clone o diretório (`git clone https://github.com/sharpSolucoes/pj24-00-api-rest-v2.git`) em seu `htdocs` ou em uma pasta que você consiga rodar;
  - Importar o arquivo `database_demo.sql` para o seu banco de dados;

- **Informações sobre a API**

  > Esta API foi criada com intuito de ser um treinamento de backend proposto pela [Sharp](https://www.instagram.com/sharpsolucoes/) para um programador iniciante. O projeto é simples, ele consiste em um CRUD de usuários com autenticação que exibe os resultados em JSON.

- **Como utilizar a API em sua maquina**

  - **Pré-requisitos:**

    - **Ter o xampp.**
    - **Ter o insomnia.**

  - **Utilização da API:**

    - Login usuários

      - Login / Validação de usuarios:

        - Rota: /me/login
        - Metodo: POST
        - Headers**:** SECRET_KEY

        ```json
        {
          "email": "varchar(255)",
          "password": "varchar(255)"
        }
        ```

        - Respostas da requisição:

        ```json
        //Sucesso - Status: 200 OK

        {
        "user": {
        		"id": int,
        		"name": "varchar(255)",
        		"position": "varchar(255)",
        		"avatar": "varchar(255)",
        		"permissions": []
        	},
        "token" : "varchar(255)"
        }

        //Erro - Status 401 Unauthorized

        {
        	[]
        }
        ```

        - Logout

          - Rota: /me/logout
          - Metodo: GET
          - Headers**:** token de acesso da API (Será usado para fazer o logout)
          - Respostas da requisição:

            ```json
            // Sucesso - Status 200 OK

            {
            	"message": "Logout successfully"
            }

            // Erro - Status 401 Unauthorized

            {
            	[]
            }
            ```

    ***

    - CRUD de usuarios

      - Adicionar novo usuário

        - Rota: /users/create
        - Metodo: POST
        - Headers**:** token de acesso da API

        ```json
        {
          "name": "varchar(255)",
          "email": "varchar(255)",
          "password": "varchar(255)",
          "position": "varchar(255)"
        }

        //Não é possivel criar um usuário com o mesmo email que outro usuário
        ```

        - Respostas da requisição:

        ```json
        //Sucesso - Status 201 Created

        [
        	"User created"
        ]

        //Erro - Status 400 Bad Request

        []
        ```

      - Ver usuários

        - Rota: /users (para ver TODOS os usuários)
        - Rota /users/0-slug-usuario (para ver UM usuário em especifico)
        - Metodo: GET
        - Headers**:** token de acesso da API
        - Respostas da requisição:

        ```json
        //Sucesso - Status - 200 OK

        [
        	{
        		"id" : int,
        		"name" : "varchar(255)",
        		"email" : "varchar(255)",
        		"position" : "varchar(255)",
        		"slug" : "varchar(255)"
        	}
        ]

        //Erro - Status - 400 Bad Request

        []
        ```

      - Atualizar usuário

        - Rota: /users/update
        - Metodo: PUT
        - Headers**:** token de acesso da API

        ```json
        {
        	"id" : int,
        	"name" : "varchar(255)",
        	"email" : "varchar(255)",
        	"position" : "varchar(255)"
        }

        //Não é possivel atualizar para o mesmo email que outro usuário
        ```

        - Respostas da requisição:

        ```json
        //Sucesso - Status 200 OK

        [
        "User updated"
        ]

        //Erro - Status 400 Bad Request

        [
        "This id does not exist or invalid URL"
        ]
        ```

      - Deletar usuário

        - Rota: users/delete/0-slug-usuario (voçê escolhe o usuario que será apagado pela slug)
        - Metodo: DELETE
        - Headers**:** token de acesso da API
        - Respostas da requisição:

        ```json
        //Sucesso Status - 204 No Content

        []

        //Erro Status - 400 Bad Request

        []
        ```

---
