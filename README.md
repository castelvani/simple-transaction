# API Transferências Simples

API RESTful para realizar transferências entre usuários

## Endpoints

### 1. Transferência

- **URL:** `/api/transfer`
- **Método:** POST
- **Descrição:** Realiza uma transferência entre carteiras de usuários. Usuários do tipo Merchant apenas recebem valores, usuários do tipo Common recebem e enviam.
  ```json
  {
    "value": 100.00,
    "payer": 123,
    "payee": 456
  }
  ```
- **Header:** Utilizar Authorization Bearer {token} para realizar a transferencia desejada

### 2. Cadastro de usuário

- **URL:** `/api/user/register`
- **Método:** POST
- **Descrição:** Realiza cadastro de usuário.
- **Regras:**  O campo `cnpj` é obrigatório quando o valor de type é Merchant; O campo `cpf` é obrigatório quando o valor de type é Common; Os campos `cpf`, `cnpj` e `email` são únicos. 
  ```json
  {
    "name": "Teste",
    "email": "teste@teste2.com",
    "password": "123456",
    "cpf": "12312312300",
    "cnpj": "",
    "type": "Common"
  }
  ```
- **Retorno:** Um Bearer token relacionado ao usuário é retornado.

### 3. Login de usuário

- **URL:** `/api/user/login`
- **Método:** POST
- **Descrição:** Realiza login.
- **Regras:**  E-mail e senha obrigatórios.
  ```json
  {
    "email": "teste@teste.com",
    "password": "123456"
  }
  ```
- **Retorno:** Um Bearer token relacionado ao usuário é retornado.