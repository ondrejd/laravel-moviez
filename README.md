# TODO

- ~~dokončit základní verzi API~~
- ~~přidat testy pro modely~~
- ~~přidat testy pro API~~
- __přidat Sanctum__:
  1. upravit `v1.yaml` pro __Swagger__ (sekce _Security_)
  2. vyzkoušet v [Postman](https://www.postman.com/downloads/) a znova vyexportovat kolekci
  3. upravit stávající testovací _http requests_
- rozjet plnohodnotně Docker:
  1. obraz s API (webem)
  2. obraz se [Swagger UI](https://swagger.io/tools/swagger-ui/)
  3. celé to vyzkoušet
  4. postup napsat do hlavního `README.md`
- odeslat do GitHub repozitáře
- zkusit udělat GitHub CI tak, aby se po aktualizaci spustil __PhpStan__ a __PhpUnit__
- aktualizovat finálně `README.md` a znovu vyzkoušet
- __nakonec znova přečíst zadání, celé si to zkontrolovat a API jako takové uzavřít, pak jít na FE__
- [!CAUTION] __Front-End__

## Poznámky pro vývojáře

### Spuštění projektu

V terminálu (Linux nebo WSH):

```bash
git clone git@github.com:ondrejd/laravel-moviez.git
cd laravel-moviez
composer install
./artisan migrate --step --seed
./artisan serve --port=8001
```

Nyní nám běží API na adrese `http://127.0.0.1:8001/api/v1`.

### Vývojářské nástroje

Pro kvalitu kódu použijte:

```bash
php ./vendor/bin/pint
```

Pro spuštění testů:

```bash
# Všechny testy
./artisan test
# Vybraná skupina testů
./artisan test --testsuite="Feature (API)"
./artisan test --testsuite="Feature (models)"
```
