# ⛳ Golf API

REST API for managing golf equipment ads. Built with Laravel 10+ and hexagonal architecture.

## Tech Stack

-   PHP 8.2 + Laravel 10+
-   MySQL 8.0
-   Docker & Docker Compose
-   Laravel Sanctum (authentication)

## Quick Start

### Environment Variables

Create a .env file from the example:

```bash
cp .env.example .env
```

### Required variables:

```bash
# App
APP_NAME="Golf API"
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:xxx  # Generated with: php artisan key:generate
APP_URL=http://localhost:8081

# Database
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=golf_api
DB_USERNAME=golf_user
DB_PASSWORD=secret

# Gemini
GEMINI_API_KEY=<your_gemini_api_key>
```

**Prerequisites:** Docker & Docker Compose installed

```bash
# Clone the repo
git clone https://github.com/jesusaugusto0x2/golf-api.git
cd golf-api

# Copy environment file
cp .env.example .env

# Start containers
docker-compose up -d

# Install dependencies
docker exec -it golf-api-app composer install

# Generate app key
docker exec -it golf-api-app php artisan key:generate

# Run migrations
docker exec -it golf-api-app php artisan migrate

# (Optional) Seed database
docker exec -it golf-api-app php artisan db:seed
```

**API running at:** http://localhost:8081

## API Endpoints

### Public Endpoints

**List Ads**

```bash
GET /api/ads

# With filters
GET /api/ads?category_id=1&min_price=100&max_price=500
```

**Register**

```bash
POST /api/register
Content-Type: application/json

{
  "name": "John",
  "surname": "Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Login**

```bash
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

### Protected Endpoints

Include token in header: `Authorization: Bearer {token}`

**Get Current User**

```bash
GET /api/user
```

**Logout**

```bash
POST /api/logout
```

**Create Ad**

```bash
POST /api/ads
Content-Type: application/json
Authorization: Bearer {token}

{
  "category_id": 1,
  "title": "TaylorMade M6 Driver",
  "price": 350.00,
  "condition": "new",
  "description": "Great condition driver",
  "ends_at": "2025-12-31"
}
```

Valid status values: `new`, `used`, `refurbished`, `like_new`

**Delete Ad**

```bash
DELETE /api/ads/{adId}
Authorization: Bearer {token}
```

## Categories

    1. Drivers
    2. Woods
    3. Hybrids
    4. Driving Irons
    5. Irons
    6. Wedges
    7. Putters

## Useful Commands

```bash
# Install/update dependencies
docker exec -it golf-api-app composer install

# Run migrations
docker exec -it golf-api-app php artisan migrate

# Seed database
docker exec -it golf-api-app php artisan db:seed

# Fresh database (reset + seed)
docker exec -it golf-api-app php artisan migrate:fresh --seed

# Clear cache
docker exec -it golf-api-app php artisan cache:clear

# View logs
docker logs -f golf-api-app

# Access container
docker exec -it golf-api-app bash

# Stop containers
docker-compose down

# Restart containers
docker-compose restart
```

## Database Access

```
Host: localhost
Port: 33060
Database: golf_api
Username: golf_user
Password: secret
```
