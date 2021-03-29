# Auth-Token-Tymon + API - (CRUD)

## Descrição do Projeto

<p align="center">
Esse Projeto Trata-se de uma API para que seja possível, que os professores
gerenciem suas disciplinas, turmas e respectivos alunos.<p align="center">


### 🛠 Tecnologias

As seguintes ferramentas foram usadas na construção do projeto:

- [Laravel v7.30.4](https://laravel.com/docs/7.x)
- [PHP 7.4.3](https://www.php.net/downloads.php#v7.4.3)
- [jwt-auth](https://jwt-auth.readthedocs.io/en/develop/)

Funciona com servidor próprio do laravel(php artisan serve).
Modelo Feito e Testado em Linux Ubunto 20.4

## Começando

Clone o repositório do projeto:

Caso você use HTTPS:

git clone https://github.com/dompossebon/auth-token-tymon.git

---------------------------------------------------------

Após a clonagem, entre no diretório da aplicação:

cd auth-token-tymon

em seguida execute o comandos abaixo:

composer install

Na raiz do projeto localize e Duplique o arquivo .env.example e em seguida renomeie-o para .env usando o comando:

cp .env.example .env

Atenção, o usuário deverá configurar o atributos do banco de Dados em .env

- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=root
- DB_PASSWORD=suasenha

entao, após realizar tal tarefa, o usuário deverá rodar os comandos:

---------------------------------------------------------

Então rode o comando:

- php artisan key:generate

- php artisan jwt:secret

dentro do seu .env localize o JWT_SECRET e substitua pela chave abaixo
ps: esta chave nao deverá ser pública

- JWT_SECRET=wk44tDGdGkTEQ9CKGma4YQSOjwjUG7YjFY7QlTUCPxu0TAfc3OMTB4BpRArKhUzk

então siga digitando os comandos...

- php artisan cache:clear

- php artisan config:clear

- php artisan migrate

---------------------------------------------------------

## COLOCANDO O SERVIDOR LARAVEL EM AÇÃO

UTILIZE O COMANDO:

- php artisan serve

Agora basta DIGITAR em seu Brownser e acessar:

-  http://127.0.0.1:8000/

Para Testar a API em ação.
Clique em Register na paginal inicial para criar um Professor(crie qualquer nome de usuário),
utilizando este usuario "professor", vc deverá acessar a API.
Sugestão é acessar utilizado POSTMAN ou similiar como Insomnia

---------------------------------------------------------

## Para Utilizar com POSTMAN

 - Na raiz do Projeto temos uma Pasta Nomeada como postman_collection, acesse esta pasta e importe o arquivo:


- GsaAuthToken.postman_collection.json

Para maiores detalhes consulte o arquivo supracitado

---------------------------------------------------------
## Manual Básico

Primeiro ponto é Obter o Token, sem ele nada vai funcionar:
http://127.0.0.1:8000/api/auth/login (em body/form-data entre com seu usuário e senha)

copie o token recebido, ele será utilizado em todos os acessos.
Utilize o Token clicando em "Authorization" e em TYPE escolha "Bearer Token".
na Caixa TOKEN cole o seu token.

## Cadastros independes são: DISCIPLINA e ESTUDANTE

# Disciplinas
http://127.0.0.1:8000/api/new/discipline, e;
regras: name e code são ÚNICOS e nao podem ser NULOS

"{
"code": "BioF3",
"name": "Biologia Fundamento3",
"description": "mundo 3"
}"

# Estudante
http://127.0.0.1:8000/api/new/student
regras: name e code são ÚNICOS

{
"name": "MARCOS da Silva Albino de Mello",
"email": "meuemaaaail2@gmail.com",
"birth_date": "1981/02/09"
}

# Turma
http://127.0.0.1:8000/api/new/classe, Neste cadastro deve utiliza o id da disciplina cadastrada
regras: name é ÚNICO e nao podem ser NULO ...

{
"discipline_id": 1,
"name": "Turma 022"
}

# Turmas Montadas
e somente então, poderá "Matricular/Linkar" o Aluno com a Turma utilizando:
http://127.0.0.1:8000/api/new/assembledclass, Neste caso o usuário deverá
utilizar o id do Aluno e o id da Turma
regras: Não poderá repetir o mesmo aluno em uma mesma turma, ou seja,
em cada turma, somente poderá haver um único "student_id"

{
"student_id": 1,
"class_id": 2
}

# PARA PREENCHER O REQUISITO:
A API também deverá conter um endpoint de relatório, endpoint que irá
constar todos os alunos de uma determinada turma.
o usuário deverá acessar o seguinte endpoint:
http://127.0.0.1:8000/api/classreport1/(ID da Turma que deseja visualizar)

# Outros endpoints de interesse:
-------------------
## CONSULTAR
----------
# Professores
http://127.0.0.1:8000/api/teachers
ou
http://127.0.0.1:8000/api/teachers/1 (ID do Professor)

# Disciplinas
http://127.0.0.1:8000/api/discipline
ou
http://127.0.0.1:8000/api/discipline/BioF1 (código da disciplina)

# Estudante
http://127.0.0.1:8000/api/student
ou
http://127.0.0.1:8000/api/student/1 (ID do Estudante)

# Turma
http://127.0.0.1:8000/api/classe
http://127.0.0.1:8000/api/classe/1 (ID da Turma)

# Turmas Montadas com alunos (todas as turmas e seus alunos)
http://127.0.0.1:8000/api/assembledclass

# UMA UNICA Turma Montada com seus respectivos alunos
http://127.0.0.1:8000/api/classreport/1 (ID do Turma em Questão)

## EDITAR
----------
# Disciplinas
http://127.0.0.1:8000/api/edit/discipline/BioF1 (código da disciplina)

# Estudante
http://127.0.0.1:8000/api/edit/student/1 (ID do Estudante)

# Turma
http://127.0.0.1:8000/api/edit/classe/1 (id da turma)

# Turmas Montadas
http://127.0.0.1:8000/api/edit/assembledclass/4 (ID desejado)

##DELETAR
----------
# Disciplinas
http://127.0.0.1:8000/api/delete/discipline/BioF1 (código da disciplina)
ATENÇÂO: disciplina(Disciplines) é utilizada para criar turma, logo, O sistema nao permitirá ser apagada,
se estiver sendo usada na tabela Turma(classes) 

# Estudante
http://127.0.0.1:8000/api/delete/student/1 (ID do Estudante)
ATENÇÂO: Estudante(Students) é utilizado para Montar/Linkar turmas montadas, logo, O sistema nao permitirá ser apagado,
se estiver sendo usada na tabela Turmas Montadas(assembled_classes)

# Turma
http://127.0.0.1:8000/api/delete/classe/5 (id da turma)
ATENÇÂO: Turma(classes) é utilizado para Montar/Linkar turmas montadas, logo, O sistema nao permitirá ser apagado,
se estiver sendo usada na tabela Turmas Montadas(assembled_classes)

# Turmas Montadas
http://127.0.0.1:8000/api/delete/assembledclass/1 (ID desejado)

---------------------------------------------------------

## Construído com
Laravel - O framework PHP para artesãos da Web

## by Possebon
## Contato dompossebon@gmail.com

:+1: ## By Possebon

