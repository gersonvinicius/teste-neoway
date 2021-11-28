# Utilização - back-end
Para o projeto back-end funcionar são necessárias que as extensões do php estejam instaladas, postgresql instalado, composer instalado.
Que haja um banco de dados criado no Postgresql, o arquivo .env será enviado juntamente para que já esteja configurado, bastando apenas rodar o projeto

## Estrutura
O projeto está dividido em duas pastas, back-end e front-end.
No back-end foi utilizado o pacote Laravel Uptime Monitor para verificar as informações do servidor - https://laravel-news.com/uptime-monitor
Para validar os documentos foi utilizado o pacote Validator Docs também no back-end - https://github.com/geekcom/validator-docs

## Comandos iniciais back-end - DENTRO DA PASTA DO BACK-END
Primeiramente dentro da pasta back-end, utilizamos o comando composer install para instalar-mos as dependências
Após isso utilizamos o comando php artisan migrate ou php artisan migrate:fresh para a criação das tabelas no banco de dados já configurado no postgresql.
Agora para rodar o projeto criamos um servidor virtual com o comando php artisan serve

## Comandos para infos do servidor
Devemos também dizer qual site queremos que ele faça o uptime com os comandos
php artisan schedule:run >> /dev/null 2>&1          == comando para tarefas em tempo real
php artisan monitor:create http://127.0.0.1:8000    == qual servidor ele ficará verificando (podem ser vários)
php artisan monitor:check-uptime                    == para forçar a verificação
php artisan monitor:check-certificate               == caso o site tenha certificado
php artisan monitor:enable http://127.0.0.1:8000    == para habilitar a verificação
php artisan monitor:list                            == irá mostrar a lista com as informações dos servidores

## ROTAS DA API - TESTADOS NO POSTMAN
ROTA PARA RECUPERAR DOCS CADASTRADOS    == http://127.0.0.1:8000/api/doc                        == obs:. do tipo GET
ROTA PARA CADASTRAR DOC                 == http://127.0.0.1:8000/api/doc?number=15856953002     == obs:. do tipo POST
ROTA PARA RECUPERAR PELO DOCUMENTO      == http://127.0.0.1:8000/api/doc/15856953002            == obs:. do tipo GET
ROTA PARA DELETAR                       == http://127.0.0.1:8000/api/doc/1 sendo 1 o id do doc  == obs:. do tipo DELETE
ROTA PARA STATUS DO SERVIDOR            == http://127.0.0.1:8000/api/status                     == obs:. do tipo GET
