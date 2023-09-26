We'll implement a small web app serving needs of a bikesharing platform and its users.

## Entities

**Bike:**
- id: uuid
- location: coordinates (longitude and latitude)
- lastServiceTimestamp: datetime
- standId: uuid; nullable

**Stand:**
- id: uuid
- name: alphanumeric string
- location: coordinates (longitude and latitude)

**User:**
- id: uuid
- name: alphanumeric string
- emailAddress: alphanumeric string; unique
- role: REGULAR, SERVICEMAN

**Ride:**
- id: uuid
- userId: uuid
- bikeId: uuid
- startStandId: uuid
- startTimestamp: datetime
- endStandId: uuid; nullable
- endTimestamp: datetime; nullable


## Data Hierarchy

- User -> Bike (M:N): _Users_ ride many _Bikes_ in time. This relation is stored as a _Ride_.
- Bike -> Stand (1:N): _Bike_ is at zero or one stand at a time but there may be many _Bikes_ at one _Stand_.


## Use Cases

Each role can do everything the previous ones can.

**Anonymous:**
- register
- log in
- watch current location of bikes not due for service at a map
- see location of all stands at a map

**Regular:**
- ride bike
- complete ongoing ride if within 50 metres from selected stand
- review past rides, sorted by startTimestamp in descending order

**Service man:**
- see which bikes are due for service, sorted by lastServiceTimestamp in ascending order
- mark bike serviced


## Features

Service provides web UI (server-side or client-side, we'll discuss both during the labs).

Service provides API (REST or GraphQL, we'll discuss both during the labs) described by API documentation.

Service enables _Bike_ location updates via WebSockets.

Service enables _Bike_ location subscriptions via WebSockets or Server-Sent Events (SSE).

Web UI is translated to English and one more language, it allows switching languages easily.

Users can log in using two authentication methods (username/password, OAuth, Kerberos, WebAuthn, OTP, ...).


## Deployment and Maintenance

Service can be run with one command, preferably using Docker Compose.


## Allowed Technology

If I've heard of it, it's allowed.

For dynamically typed languages with optional type system, using types is mandatory. That is: Node.js with Typescript, PHP with type declarations etc.

Preferred stack: JDK 17, Maven, Spring Boot 3, MySQL, JavaScript


## Implementation Requirements

- Correct implementation of selected architecture
- Correct separation of application layers
- Reasonably long methods (typically 50-100 lines, exceptions allowed)
- Well-commented methods/functions, data models, attributes
- Logs written where appropriate and structured (log levels, common format)
- Bike ride management module covered with automated tests (unit, integration)
- Configurations must be read from property files, environment variables etc.


## Evaluation

50 points maximum, subtracting points for any violation of requirements.
