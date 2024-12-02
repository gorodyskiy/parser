# Test task: OLX price parser.

## Tech stack:
- PHP 8.3
- Laravel 11
- MariaDB
- Nginx
- Docker

## Installation:
1. `git clone https://github.com/gorodyskiy/parser.git`
2. `chmod 777 parser && chmod -R 777 parser/storage && chmod -R 777 parser/bootstrap/cache`
3. `cd parser`
4. `yes | cp .env.example .env`
5. `docker compose up --build -d`
6. `docker exec app /bin/bash -c 'composer install ; php artisan migrate ; php artisan db:seed'`


## API requests:
**1. Register:**\
Host: `http://localhost/api`\
Endpoint: `/register`\
Method: `POST`\
Params: `name`, `email`, `password`, `password_confirmation`

**2. Login:**\
Host: `http://localhost/api`\
Endpoint: `/login`\
Method: `POST`\
Params: `email`, `password`

**3. Logout:**\
Host: `http://localhost/api`\
Endpoint: `/logout`\
Method: `POST`\
Authorization: `Bearer {token}`

**4. Create subscription:**\
Host: `http://localhost/api`\
Endpoint: `/price/subscribe`\
Method: `POST`\
Params: `link`\
Authorization: `Bearer {token}`

**5. Remove subscription:**\
Host: `http://localhost/api`\
Endpoint: `/price/ubsubscibe`\
Method: `POST`\
Params: `link`\
Authorization: `Bearer {token}`

**6. Delete all user data:**\
Host: `http://localhost/api`\
Endpoint: `/user`\
Method: `DELETE`\
Authorization: `Bearer {token}`

## To do:
- Use [OLX API](https://developer.olx.ua/api/doc)