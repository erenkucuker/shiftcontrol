
# Shift Contoller
Demo App

## Api
Laravel Echo used for broadcasting events for frontend side.
### Installation
Install dependencies with composer

```bash
composer install
```
Migrate Db Tables
```bash
php artisan migrate
```
Seed Database & Create Roles & Create Dummy User Data

```bash
php artisan db:seeds
```

Create Admin with Artisan Command
```bash
php artisan register:admin
``` 

Create Api documentation for endpoints
```bash
php artisan scribe:generate
``` 
That's All for backend side.

## FrontEnd
Next.js React Tailwind 
### Installation
Install dependencies with npm
```bash
npm install
```

Run
```bash
npm run dev
```

### Login
You can login as Employee with default created user with

```bash
username:example@gmail.com
password:password123
```

or Login with credentials that you created.




## Documentation
Scribe Used for Automated Documentation Creation


http://localhost:8000/docs


[Documentation](localhost:8000/docs)

  