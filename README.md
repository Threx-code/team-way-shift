This application requires PHP ^8.3

IF you have Docker follow the setup below, or clone the repository and run it the best way you could locally

## Installation RUN the commands below in the terminal (Docker is required)
- cd ~/path/to/the/directory/where/you/download/the/project
- cp .env.example .env
- Add the database configuration to the .env file
- composer install
- docker compose build
- docker compose ps -a (To see the list of containers started)
- docker compose up -d
- docker exec -it caApp /bin/sh
- Run the migrations (php artisan migrate)
