# cours-api-symfony
Code du cours sur les API avec Symfony

# Installation

1. Clonez le dépot où vous voulez
2. Installez les dépendances : `composer install`
3. Jouez les migrations : `php bin/console d:m:m`
4. Jouez les fixtures : `php bin/console d:f:l --no-interaction`
5. Lancez le server : `symfony serve` ou `php -S localhost:3000 -t public`
# api-with-symfony
Api with postman
-----------------
## Get

```json
get http://localhost:8000/api/post

```

## Post

```json
Post http://localhost:8000/api/post

{
    "title": "title test",
    "content": "Mon content ffaeff eaflk ea",
    "comments": [
        { 
                "username": "papao",
                "content": "Accusantium commodi quo maxime facere culpa. Est dignissimos aspernatur ut necessitatibus ullam aperiam. Qui animi velit quo non inventore ab quis."
            }
    ]
}

```

