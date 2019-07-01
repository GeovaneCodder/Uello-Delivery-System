# Teste backend Uello
##### Instalação
Clone o repositório.
```bash
git clone https://github.com/GeovaneCodder/UelloTeste.git Uello
```
Logo depois levante os container do docker.
```bash
docker-compose up -d
```
Acesse o container da aplicação
```bash
docker exec -it uello-php /bin/bash
```
Crier o arquivo .env
```bash
cp .env.example .env
```
Adicione a chave de API do google na ultima linha do aquivo .env no parametro : GOOGLE_GEOENCODING_KEY

------------


Baixe as dependencias do Laravel
```bash
composer update
```
Após feito isso, rode as migrations para criação do banco de dados.
```bash
php artisan migrate:fresh
```
Agora no navegador vá até o endereço `http://localhost:8080`
##### Testes
Para executar os testes detro do container da aplicação digite o seguinte comando:
```bash
vendor/bin/phpunit
```