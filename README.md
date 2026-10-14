# 🏪 AgilizaSaaS — Sistema de PDV, Frente de Caixa & Gestão de Estoque Multi-tenant

> **SaaS escalável para automação comercial e gestão de estabelecimentos.**  
> Desenvolvido com **Laravel 12**, **PHP 8.3**, **Tailwind CSS** e **Vite**.

---

## 🎯 Sobre o Projeto

O **AgilizaSaaS** é uma solução completa para controle de vendas e estoque de múltiplos estabelecimentos comerciais. O sistema foi desenvolvido com foco em alta performance na frente de caixa, confiabilidade nas operações financeiras e arquitetura multi-tenant com separação e controle rígido por estabelecimento.

### 🌟 Funcionalidades Principais

- ⚡ **Ponto de Venda (PDV) Rápido:** Registro ágil de vendas, carrinho interativo, cálculo de troco e atalhos de teclado.
- 🧾 **Emissão e Impressão de Cupons:** Rota dedicada e layout otimizado para impressão de cupom não fiscal/recibos de venda.
- 💵 **Gestão Completa de Caixas:**
  - Abertura de caixa com valor inicial.
  - Fechamento com prestação de contas.
  - Registro de sangrias e suprimentos com justificativa.
- 📦 **Controle de Estoque Inteligente:**
  - Movimentações de entrada e saída auditadas.
  - Alerta de estoque baixo no dashboard.
  - Variações e vínculos por sabores/categorias.
- 👥 **Controle de Acesso RBAC:**
  - `admin_master`: Acesso irrestrito a configurações globais e multi-lojas.
  - `dono`: Gestão total do estabelecimento vinculado.
  - `caixa`: Interface limpa e restrita às operações de frente de caixa e PDV.
- 🗑️ **Lixeira com Soft Deletes:** Recuperação ou exclusão definitiva de registros removidos acidentalmente.

---

## 🏗️ Stack Tecnológica

- **Backend:** PHP 8.3 + Laravel 12 (Single Action Controllers, DTOs/Actions, Transactions).
- **Frontend:** Blade Templates + Tailwind CSS + Alpine.js / Vite.
- **Banco de Dados:** SQLite (Desenvolvimento) / MySQL / PostgreSQL (Produção).
- **Testes:** Pest PHP + PHPUnit.

---

## 🚀 Como Executar Localmente

### 1. Pré-requisitos
- PHP >= 8.3 com extensões `pdo_sqlite`, `mbstring`, `openssl`.
- Composer 2.x
- Node.js >= 18 e NPM

### 2. Instalação

```bash
# Clone o repositório
git clone https://github.com/OtavioFFarina/AgilizaSaaS.git
cd AgilizaSaaS

# Instale as dependências do PHP
composer install

# Configure o ambiente
cp .env.example .env
php artisan key:generate

# Execute as migrações e seed inicial
php artisan migrate --seed

# Instale e compile o frontend
npm install
npm run build
```

### 3. Executando o Servidor

Você pode executar o servidor com o comando padrão:
```bash
php artisan serve
```

Ou subir o ecossistema completo de desenvolvimento (servidor + Vite hot-reload + filas + logs):
```bash
composer run dev
```

Acesse em: **[http://localhost:8000](http://localhost:8000)**

---

## 🔑 Credenciais de Teste Padrão

Após executar `php artisan db:seed`, os seguintes acessos estão prontos:

| Perfil | E-mail | Senha | Redirecionamento Inicial |
| :--- | :--- | :--- | :--- |
| **Administrador Master** | `admin@agiliza.com` | `admin098` | Painel Administrativo (`/dashboard`) |
| **Operador de Caixa** | `caixa@agiliza.com` | `caixa123` | Ponto de Venda (`/vendas`) |

---

## 📄 Licença

Este projeto é desenvolvido e mantido por [Otávio Farina](https://github.com/OtavioFFarina).
