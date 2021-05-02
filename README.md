# PHP testing workshop (example app)

This is an example PHP application called Coins that's part of an automated testing workshop.
  
## Usage  
  
In the root of the project you'll find a Makefile (run `make help` to see all the commands).
It's based on Docker and Docker Compose, so you should download them and install them here:
- https://docs.docker.com/get-docker/
- https://docs.docker.com/compose/install/

Once you have Docker and Docker Compose installed you can build the containers:
```make build```

Install dependencies with Composer:
```make dependencies```

Run migration to build databases (for dev and test environments):
```make migrations```
```make migrations-test```


To start the application run:
```make start```

You should now be able to make requests to the url `http://localhost:8080`.
There's also a Postman (https://www.postman.com/downloads/) collection in the root of the repository
that you can import to make requests to the app.

To run all the tests:
```make test```

To get the shell of the application (to run single tests or other stuff):
```make shell```