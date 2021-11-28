# Utilização - front-end
Para o projeto front-end funcionar é necessário ter o nodejs, nuxt, npm instalados.  
No front-end foi utilizado o pacote CPF-CNPJ-VALIDATOR para as validações - https://www.npmjs.com/package/cpf-cnpj-validator

## Comandos iniciais back-end - DENTRO DA PASTA DO FRONT-END
npm install == para instalar dependências  
npm run dev == para rodar e buildar o projeto

## Criando Registros
O comando npm run dev irá gerar um link, bastando utilizar esse link para acessar o projeto. == http://localhost:8880  
Ao iniciar o projeto cairá na tela SPA, bastando adicionar, editar ou remover algum item.  
O campo Number é validado por CPF ou CNPJ, se vazio ou fora de formato não irá dar submit.  
É possível fazer pesquisa, ocultar menu lateral, escolher total de itens por página, filtrar clicando em documento.

