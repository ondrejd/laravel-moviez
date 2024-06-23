# API pro filmy

Řešení zkušebního příkladu.

## Stručný popis

- je to založeno na frameworku __Laravel__
- jako databáze je použita SQLite
- schéma je poměrně jednoduché (jsou zde zobrazeny pouze mnou vytvořené tabulky, ostatní pocházejí přímo z frameworku):
  ```mermaid
  erDiagram
    genres {
      bigint id
      text name
      text color
    }
    genre_movie {
      bigint movie_id
      bigint genre_id
    }
    movies {
      bigint id
      text name
      text description
      text csfd
      text imdb
      text created_at
      text updated_at
    }

    genres ||--o{ genre_movie : fk_genre_to_movie
    movies ||--o{ genre_movie : fk_movie_to_genre
  ```
- jinak databáze se vytvoří pomocí automaticky pomocí _CLI_ příkazu (viz. níže) a lze rovnou i vygenerovat testovací data (doporučuji); databáze samotná je pak v `database/database.sqlite`
- pro uživatele je možno vygenerovat tzv. _personal access token_ a oprávnění jsou jednoduchá:
  1. autorizovaní uživatelé mohou vytvářet nové filmy a prohlížet všechny stávající
  2. upravovat či mazat filmy mohou jen užitelé, kteří daný film vytvořili
- součástí jsou testy pro API; unit testy jako takové nejsou
- pro kontrolu/opravu kvality kódu se používá [Laravel Pint](https://laravel.com/docs/11.x/pint)

## Poznámky pro vývojáře

### Spuštění projektu

Nejprve stáhnutí a vytvoření `.env` souboru:

```bash
git clone git@github.com:ondrejd/laravel-moviez.git
cd laravel-movie
cp .env.example .env
```

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

### Použití

#### Autorizace uživatele v API

Pro jednoduchost používáme osobní tokeny vygenerované přes konzolový příkaz, ale příslušný token by šel vygenerovat i na základě přihlašovacího formuláře.

Pokud spustíme aplikaci i s vytvořením testovacích dat (možnost `--seed` u migrací), pak nám stačí spustit příkaz:

```bash
./artisan app:create-personal-access-token
```

Případně:

```bash
docker compose exec api ash -c "./artisan app:create-personal-access-token"
```

Volby potvrdíme (stačí nám defaultní hodnoty) a vygenerovaný token si zkopírujeme pro použití například ve Swaggeru. Token vygenerovaný příkazem výše s defaultními hodnotami má platnost časově neomezenou.


 > __Pozn.__ V [tomto souboru](./docs/README.md) jsou popsány všechny dostupné soubory pro testování API vývojáři
