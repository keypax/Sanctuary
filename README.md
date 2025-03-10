# Sanctuary

Sanctuary is an animal management system designed for use in animal shelters. Although it is currently in development, the project is intended to be available pro bono for the public good.

## Requirements

- Docker
- [Make](https://en.wikipedia.org/wiki/Make_(software))

## Installation

Clone the repository:

```bash
git clone https://github.com/keypax/Sanctuary
```

Navigate to the project directory:

```bash
cd Sanctuary
```

Build and start the application:

```bash
make build
make start
make composer-install
make create-db
```

Once the setup is complete, visit: [http://localhost:8080/register](http://localhost:8080/register)

## TODO List

| Feature                                                                                                                       | Status      |
|-------------------------------------------------------------------------------------------------------------------------------|-------------|
| Adding and editing animals                                                                                                    | Done        |
| Adding and removing animal photos                                                                                             | Done        |
| User registration and login                                                                                                   | Done        |
| Printing animal data cards                                                                                                    | Done        |
| Animal history tracking                                                                                                       | Done        |
| Creation of an API with access for external entities                                                                          | In Progress |
| New user type: Volunteer (requires approval or rejection of changes made by volunteers with restricted access)                  | Todo        |
| Daily reports for staff                                                                                                         | Todo        |
| Automatic printing of promotional posters                                                                                     | Todo        |
| Dog walking service information                                                                                                 | Todo        |
| Automated translation of descriptions into several languages                                                                  | Todo        |
| Monthly/annual record keeping and statistics                                                                                  | Todo        |
| Enhanced, mobile-friendly front-end                                                                                           | Todo        |
| Creation of an API-based demo for external clients to view current shelter animals without visiting in person                    | Todo        |
| Sending emails to clients about new animals they are interested in                                                            | Todo        |
