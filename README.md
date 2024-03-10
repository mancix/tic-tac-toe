# Tic Tac Toe API

This project provides an API for a Tic Tac Toe game. 
It is built using PHP, Symfony, and Postgres

## Installation
To run this project, you need to have Docker installed.

Add the following line to your `/etc/hosts` file:

```127.0.0.1 tic-tac-toe.local```

Copy the `.env.example` file to `.env` and set the environment variables.

Run the following command to start the project:

- ```docker compose up -d``` This may take a while the first time, as it will download the necessary images, and it will build them.
- ```docker compose exec app composer install``` This will install the project dependencies.
- ```docker compose exec app php bin/console doctrine:database:create --if-not-exists``` This will create the database schema.
- ```docker compose exec app php bin/console doctrine:migrations:migrate``` This will create the database schema.
- ```docker compose exec app composer test``` This will run the tests.

## Swagger
Once the project is running, you can access the Swagger documentation at project home `http://tic-tac-toe.local/`

## Endpoints

- `POST /new_game`: Creates a new game session.
- `POST /move`: Makes a move in the current game session board.
- `GET /ping`: Check API status.

## Tools
- PHP-cs-fixer: This project uses PHP-cs-fixer to format the code. You can run it with the following command:
```docker compose exec app composer cs-fixer```
- PHPStan: This project uses PHPStan to check the code. You can run it with the following command:
```docker compose exec app composer phpstan```
