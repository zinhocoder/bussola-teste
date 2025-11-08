# Sistema de Gerenciamento Escolar

API RESTful para gerenciamento de cursos, disciplinas, alunos e matrículas de uma escola.

## 🏗️ Arquitetura

Este projeto foi desenvolvido seguindo os princípios de **Clean Architecture** e **SOLID**, utilizando:

- **Laravel 10** como framework base
- **Repository Pattern** para abstração de acesso a dados
- **Service Layer** para regras de negócio
- **Event-Driven Architecture** para comunicação assíncrona (e-mails)
- **DTO (Data Transfer Objects)** para transferência de dados

### Estrutura de Camadas

```
app/
├── Http/
│   ├── Controllers/     # Camada de apresentação (API)
│   └── Requests/        # Validação de requisições
├── Services/            # Camada de serviços (regras de negócio)
├── Repositories/        # Camada de acesso a dados
├── Models/              # Entidades do domínio
├── Events/              # Eventos do sistema
├── Listeners/           # Ouvintes de eventos
└── DTOs/                # Objetos de transferência de dados
```

## 🚀 Tecnologias

- **PHP 8.2**
- **Laravel 10**
- **MySQL 8.0**
- **Docker & Docker Compose**
- **PHPUnit** para testes
- **Swagger/OpenAPI** para documentação
- **Mailpit** para envio de e-mails em desenvolvimento

## 📋 Pré-requisitos

- Docker e Docker Compose instalados
- Git

## 🛠️ Instalação

1. Clone o repositório:
```bash
git clone <repository-url>
cd bussola-teste
```

2. Copie o arquivo de ambiente:
```bash
cp .env.example .env
```

3. Inicie os containers:
```bash
docker-compose up -d
```

4. Instale as dependências:
```bash
docker-compose exec app composer install
```

5. Gere a chave da aplicação:
```bash
docker-compose exec app php artisan key:generate
```

6. Execute as migrations:
```bash
docker-compose exec app php artisan migrate
```

7. Popule o banco com dados iniciais:
```bash
docker-compose exec app php artisan db:seed
```

## 📚 Documentação da API

Após iniciar a aplicação, acesse a documentação Swagger em:
- **Swagger UI**: http://localhost:8000/api/documentation

## 📧 E-mail (Mailpit)

O Mailpit está configurado para capturar todos os e-mails enviados. Acesse a interface web em:
- **Mailpit UI**: http://localhost:8025

## 🧪 Testes

Execute os testes automatizados:

```bash
docker-compose exec app php artisan test
```

Ou com cobertura:

```bash
docker-compose exec app php artisan test --coverage
```

## 📝 Endpoints da API

### Cursos
- `GET /api/cursos` - Listar cursos
- `POST /api/cursos` - Cadastrar curso
- `PUT /api/cursos/{id}` - Editar curso
- `DELETE /api/cursos/{id}` - Excluir curso

### Disciplinas
- `GET /api/disciplinas` - Listar todas as disciplinas
- `GET /api/disciplinas/curso/{cursoId}` - Listar disciplinas por curso
- `POST /api/disciplinas` - Cadastrar disciplina
- `PUT /api/disciplinas/{id}` - Editar disciplina
- `DELETE /api/disciplinas/{id}` - Excluir disciplina

### Alunos
- `GET /api/alunos` - Listar alunos
- `GET /api/alunos/curso/{cursoId}` - Listar alunos por curso
- `GET /api/alunos/cpf/{cpf}` - Buscar aluno por CPF
- `POST /api/alunos` - Cadastrar aluno
- `PUT /api/alunos/{id}` - Editar aluno
- `DELETE /api/alunos/{id}` - Excluir aluno
- `POST /api/alunos/{id}/cursos` - Vincular aluno a curso(s)

### Matrículas
- `GET /api/matriculas` - Listar matrículas
- `POST /api/matriculas` - Realizar matrícula
- `PUT /api/matriculas/{id}/trancar` - Trancar matrícula

## 🎯 Design Patterns Utilizados

1. **Repository Pattern**: Abstração de acesso a dados
2. **Service Layer**: Encapsulamento de regras de negócio
3. **DTO Pattern**: Transferência de dados entre camadas
4. **Observer Pattern**: Eventos e listeners para e-mails
5. **Factory Pattern**: Criação de objetos complexos
6. **Strategy Pattern**: Diferentes estratégias de validação

## 🔒 Princípios SOLID

- **S**ingle Responsibility: Cada classe tem uma única responsabilidade
- **O**pen/Closed: Aberto para extensão, fechado para modificação
- **L**iskov Substitution: Interfaces bem definidas
- **I**nterface Segregation: Interfaces específicas e coesas
- **D**ependency Inversion: Dependências injetadas via construtor

## 📦 Extensibilidade

Para adicionar novas entidades (como Professores, Turmas, etc.):

1. Crie a Migration
2. Crie o Model
3. Crie o Repository
4. Crie o Service
5. Crie o Controller
6. Registre as rotas
7. Crie os testes


Desenvolvido como desafio técnico para vaga de full-stack na Bussola.

