Tady jsou uložené soubory pro lokální testování API ve dvou složkách:

- [__HttpRequests__](./HttpRequests) pro použití v IDE [PhpStorm](https://www.jetbrains.com/phpstorm/)
- [__Postman__](./Postman) kolekce pro import do aplikace [Postman](https://www.postman.com/downloads/)
- [__Swagger__](./Swagger) pro použití s prohlížečem [Swagger](https://swagger.io/tools/swagger-ui/) přes _Docker_:
  ```sh
  docker run -p 80:8080 -v $(pwd):/tmp -e SWAGGER_FILE=./docs/Swagger/v1.yaml swaggerapi/swagger-ui
  ```
