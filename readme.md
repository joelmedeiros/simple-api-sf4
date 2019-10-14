## Getting started

You will need [Docker](https://www.docker.com/get-started) and [Docker-Compose](https://docs.docker.com/compose/) installed to build this application.

Run the commands below on your favorite terminal inside the project folder:
 
```bash
docker-compose up -d
docker-compose exec php composer install
```

### Running the tests

All tests were wrote using [codeception](https://codeception.com) library, then we need to use its commands to run all tests:

```bash
docker-compose exec php vendor/bin/codecept run
```

For this task, I did not wrote Unit tests, because In my concern, It was not needed.

After run the tests, some data will be generated to be used by our API. 

### API

The routes are available by the command: 
```bash
 docker-compose exec php bin/console debug:router
```

And you can use as well your postman, importing the collection in the root folder of this project.
