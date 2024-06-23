# TODO

- ~~dokončit základní verzi API~~
- ~~přidat testy pro modely~~
- ~~přidat testy pro API~~
- __rozjet plnohodnotně Docker__:
  1. ~~obraz s API~~
  2. ~~obraz se [Swagger UI](https://swagger.io/tools/swagger-ui/)~~
  3. ~~celé to vyzkoušet~~
  4. ~~postup napsat do hlavního `README.md` (a vymazat stávající postup - ponechat jen docker verzi)~~
- přidat Sanctum:
  1. upravit `v1.yaml` pro __Swagger__ (sekce _Security_)
  2. vyzkoušet v [Postman](https://www.postman.com/downloads/) a znova vyexportovat kolekci
  3. upravit stávající testovací _http requests_
- odeslat do GitHub repozitáře
- zkusit udělat GitHub CI tak, aby se po aktualizaci spustil __PhpStan__ a __PhpUnit__
- aktualizovat finálně `README.md` a znovu vyzkoušet
- __nakonec znova přečíst zadání, celé si to zkontrolovat a API jako takové uzavřít, pak jít na FE.__ Případně přidělat ty volitelné sekce, jako je filtrování, stránkování a vyhledávání ve filmech.
- [!CAUTION] __Front-End__

## Poznámky pro vývojáře

### Spuštění projektu

#### Lokálně

V terminálu (Linux nebo _WSH_), kde máme nainstalované __PHP__ a __Composer__.

```bash
git clone git@github.com:ondrejd/laravel-moviez.git
cd laravel-moviez
composer install
./artisan migrate --step --seed
./artisan serve --port=8001
```

Nyní nám běží API na adrese `http://127.0.0.1:8001/api/v1`. Vývojářské nástroje jsou dostupné z konzole:


```bash
# Kontrola/oprava kvality kódu
php ./vendor/bin/pint
# Spuštění všech testů
./artisan test
# Spuštění vybraných testů
./artisan test --testsuite="Feature (API)"
./artisan test --testsuite="Feature (models)"
```

#### Docker

Tady stačí reprodukovat tento postup (pozor napoprvé to chvíli trvá, než se vybuildují kontejnery):

```bash
docker compose up -d
docker compose exec api ash -c "composer install"
docker compose exec api ash -c "./artisan migrate --step --seed"
```

Teď by nám měl běžet API server i Swagger UI:

- __API server__: [http://127.0.0.1:8001/](http://127.0.0.1:8001/)
- __Swagger UI__: [http://127.0.0.1:8002/](http://127.0.0.1:8002/)

Vývojářské nástroje můžeme spouštět přímo z běžícího kontejneru:

```bash
docker compose exec api ash -c "php ./vendor/bin/pint"
docker compose exec api ash -c "./artisan test"
docker compose exec api ash -c "./artisan tinker"
```
