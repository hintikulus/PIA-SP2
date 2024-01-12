# Bikesharing app
Semestral assignment for PIA-E in 2023/2024

[Full documentation](doc/documentation.pdf) (in Czech).
## Assignment
Full text of the assignment [here](assignment.md).

## Setup
The application is dockerized, so the preferred way to run it is to use the prepared docker configuration.
In the project there is a Makefile file with prepared rules and commands. So to setup the project you need to execute the following set of commands.

Create and run docker containers:
```
make
```

The previous command will start 3 containers. Apache server with PHP, MariaDB, and Redis.
At the same time, all necessary commands for running the program are executed. Also, database migrations are run to create the database structure.

In the default configuration, the application starts and is accessible from `[http://localhost](http://localhost)`.

The default user with administrator rights has access credentials.
```
login: admin
password: admin
```

## Implementation specifications
- PHP (Nette framework) for server side backend
- Latte templating engine for server side page rendering
- Nette ajax, Naja for dynamic AJAX comunication
- MySQL as a database system
  - Implemented database migrations
- Redis for session storage
- Leaflet for map display
- Simple REST API
- Simple WebSocket communication
  - used ZeroMQ pusher
- Authentication methods
  - user and password
  - Google OAuth2
- Multi language support (Czech and English implemented)

## API
Since my application does not necessarily require an API to use, I only created a couple of GET REST API endpoints. 
### List of stands
```
GET http://<base_address>/api/stands
```

### Stand detail
```
GET http://<base_address>/api/stands/<id>
```

### Ride detail
```
GET http://<base_address>/api/rides/<id>
```

## Running tests
There are several tests in the app to demonstrate how to use it. For example, the servicing of wheels to be serviced is tested.
Run the tests with this command:
```
make nt
```