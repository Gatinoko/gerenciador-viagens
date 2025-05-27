<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Gerenciador Viagens

## Sobre Mim

Olá! Meu nome é Gabriel e sou um programador full-stack. A maior parte da minha experiência gira em torno de tecnologias como JavaScript, Typescript, React e Node. Por ser um entusiasta sobre programação, já mexi com diversas frameworks e linguagens diferentes.

## Instruções Para Execução do Projeto

1. Ter instalado PHP >= 8.1, Composer, Node.js, Npm e MySQL
2. Executar `composer install` e `npm install`
3. Criar um arquivo `.env` com as mesmas informações do arquivo `.env.example`
4. Gerar chave do back-end em Laravel executando `php artisan key:generate`
5. Gerar chave JWT executando `php artisan jwt:secret`
6. Executar as migrações da database executando `php artisan migrate`
7. Iniciar o front-end em Vue executando `npm run dev`
8. Iniciar o back-end em Laravel executando `php artisan serve`

## Checklist de Requisitos

### Requisitos Gerais

-   [ ] Criação de testes automatizados
-   [ ] Configuração do Docker

### Requisitos Front-end

-   [x] Dashboard com filtragem por destino e status
-   [x] Formulário para criação de pedidos
-   [x] Atualização de status diretamente da tabela
-   [x] Autenticação de usuário usando JWT
-   [x] Mensagens de feedback para operações feitas pelo usuário

### Requisitos Back-end

-   [x] Endpoint para criação de pedidos
-   [x] Endpoint para atualizar o status de pedidos
    -   [ ] Não permitir o usuário que fez o pedido alterar o status do mesmo
-   [x] Endpoint para consultar um pedido de viagem com base em um ID fornecido
-   [ ] Listar todos os pedidos de viagem
-   [ ] Lógica de negócios para cancelar pedidos já aprovados
-   [ ] Filtragem por período e destino
-   [ ] Notificações de aprovação ou cancelamento de pedidos

## Considerações Finais

Por mais que já tivesse um pouco de experiência com as tecnologias requeridas para a execução do projeto, isso foi minha primeira vez criando um pequeno projeto utilizando Laravel, Vue e PHP. Definitivamente não consegui completar todos os requerimentos do projeto, contudo tentei fazer o máximo que pude dentro do tempo estipulado para o desafio técnico. Acredito que se eu tivesse um pouco mais de tempo, conseguiria entregar tudo sem problemas.

Obrigado pela oportunidade!
