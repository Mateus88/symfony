# symfony
1. Install docker
1.1 Configure .env associated with docker-compose.yml  ( Ports , Ip's, volumes etc)
1.1.1 Default use 8001 (symfony) and 3308 (MySQL)
1.1.2 Already configured in .env (docker) and .env.example (symfony)
1.2 In root folder the project :
1.2.1 Commands for create and up containers:
```
docker-compose build && docker-compose up
```
or 
```
docker-compose up 
```

1.2.2. First get container name:
```
docker ps
docker exec -it <name_container or id> bash
```

2. You want use another system:
   2.1 PHP 8.1
   2.2 MySQL
   2.3 Apache/nginx

3. Run composer
```
composer install
```

4. Copy environment file
```
cp .env.example .env
```

5. Run migrations
```
doctrine:migrations:migrate 
```

6. Acess to app
```
http://localhost:8001/ticket
```

