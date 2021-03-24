```
Stack:
Lumen
PostgreSQL
```

#### 1 Deploy project
```
composer install
```

#### 2 Copy .env
```
cp .env.example .env
```
#### 3 Create new tables in db

```
php artisan migrate
```

#### 4 May use the PHP development server
```
php -S localhost:8001 -t public
```

#### 5 Create new user and company

```
php artisan db:seed --class=UserSeeder
```
#### 6 You can test registration and login user

```
vendor/bin/phpunit --filter=testUserRegistration
vendor/bin/phpunit --filter=testUserLogin
```

## Swagger documentation
[http://localhost:8001/api/documentation](http://localhost:8001/api/documentation)

## Route list:
```
Register new user

/api/register
method POST 
fields: first_name, last_name, email, password, phone
``` 
```
Sign In

/api/sign-in
method POST 
fields: email, password
```
```
Add the companies

/api/user/{id}/companies
method POST
fields: title, phone, description, api_token
``` 
```
Show the companies

/api/user/{id}/companies
method GET
fields: api_token
``` 
```
Reset Password

/api/recover-password
method POST 
fields: email
``` 
```
/api/recover-password
method PATCH 
fields: token, email, password, password_confirmation
```
