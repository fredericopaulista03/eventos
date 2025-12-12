# Event Marketplace System

Um sistema completo de venda de ingressos e gestão de eventos (Estilo TicketSports), desenvolvido com Laravel 12 e Tailwind CSS.

## 🚀 Requisitos de Sistema

- PHP 8.2 ou superior
- MySQL 8.0 ou MariaDB
- Composer
- Node.js & NPM (para desenvolvimento local)

## 🛠 Instalação Local

1. **Dependências do PHP**
   ```bash
   composer install
   ```

2. **Configuração do Ambiente**
   Copie o arquivo de exemplo e gere a chave da aplicação:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Edite o arquivo `.env` com suas credenciais de banco de dados.*

3. **Banco de Dados**
   Execute as migrações para criar as tabelas:
   ```bash
   php artisan migrate
   ```
   *(Opcional) Popule com dados de exemplo:*
   ```bash
   php artisan db:seed
   ```

4. **Frontend (Assets)**
   ```bash
   npm install
   npm run dev
   ```

5. **Iniciar Servidor**
   ```bash
   php artisan serve
   ```
   Acesse: `http://localhost:8000`

---

## ☁️ Como Fazer Deploy no cPanel

### 1. Preparação dos Arquivos
Antes de subir, no seu ambiente local:
1. Execute `npm run build` para gerar os assets de produção.
2. Comprima todos os arquivos do projeto em um **ZIP**, exceto a pasta `node_modules` e `.git`.

### 2. Upload e Estrutura
No Gerenciador de Arquivos do cPanel:
1. Crie uma pasta na raiz (fora de `public_html`) chamada `sistema_eventos`.
2. Faça o upload do ZIP dentro dessa pasta e extraia.
3. Mova o conteúdo da pasta `public` do projeto para dentro da sua pasta `public_html` (ou subdomínio).

### 3. Ajuste de Caminhos
Edite o arquivo `public_html/index.php`:
```php
// Procure por estas linhas e ajuste os caminhos:
if (file_exists(__DIR__.'/../sistema_eventos/storage/framework/maintenance.php')) { ... }
require __DIR__.'/../sistema_eventos/vendor/autoload.php';
$app = require_once __DIR__.'/../sistema_eventos/bootstrap/app.php';
```

### 4. Banco de Dados
1. No cPanel, vá em "Assistente de Banco de Dados MySQL".
2. Crie um banco e um usuário.
3. Edite o arquivo `.env` na pasta `sistema_eventos` com os dados do banco criado.

### 5. Migrações
Se tiver acesso SSH:
```bash
cd sistema_eventos
php artisan migrate
```
Sem SSH: Importe o arquivo SQL (gerado localmente via mysqldump) pelo phpMyAdmin.

## 📚 Funcionalidades
- **Home**: Busca de eventos, destaques.
- **Área do Organizador**: Dashboard com gráficos, gestão de eventos.
- **Compra**: Fluxo de checkout (Simulação).
- **API**: Endpoints documentados em `routes/api.php`.
