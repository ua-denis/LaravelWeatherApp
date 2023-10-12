## Install to development environment:
You need to install [docker](https://www.docker.com/) and follow next steps:

1. Copy `.env.example` into `.env`;
2. In `.env` file set values to `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` and `WEATHER_API_KEY` (from [openweathermap.org](https://openweathermap.org));
3. Add next records into your `hosts` file:
   ```
   127.0.0.1 laravel-weather-app.test
   ```
4. Install docker containers `docker-compose up -d`;
5. Run the following commands: 
   ```
   docker-compose exec ws 
   composer install
   php artisan key:generate
   php artisan migrate
   npm install
   npm run build
   ```
