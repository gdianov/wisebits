# Wisebits test

## Installation

```sh
1. Склонировать текущий репозиторий и перейти в ветку master
2. Выполнить команды:
make up
make composer-install
make migrate
make tests-schema
make load-fixtures
make run-tests
```

## API Методы

| Name        | URI                               | Method |
|-------------|-----------------------------------|--------|
| Get User    | http://127.0.0.1:8080/api/users/1 | GET    |
| Ceate User  | http://127.0.0.1:8080/api/users   | POST   |
| Update User | http://127.0.0.1:8080/api/users   | PUT    |

## Controller
```
App\Controller\UserController
```

## Validators
```
App\Validator\DirtyWordsValidator
App\Validator\InvalidEmailDomainValidator
```
## Journaling Update User

```
App\EventListener\UserChangedLogListener
```

## Tests

```
App\Tests\Controller\UserControllerTest
```


