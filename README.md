# Steven Lu - Tech Exercise

[![codecov](https://codecov.io/gh/the14thsky/tech-lab/branch/master/graph/badge.svg?token=VF8GL9JDH4)](https://codecov.io/gh/the14thsky/tech-lab)

This package is regarding coding test for job interview.

# Usage
To get the laravel system working, please follow these steps below:
```bash
composer install
cp -i .env.example .env
php artisan key:generate
php artisan migrate
php artisan test
```

Functions cover:
```text
POST /api/chair 
    - with form-data ['chair_slug' => 'omega', 'chair_name' => 'Omega', 'body' => ['price' => 389, 'currency' => 'SGD']]
GET /api/chair/omega/price
POST /api/chair/
    - with form-data ['chair_slug' => 'omega', 'chair_name' => 'Omega', 'body' => ['price' => 450, 'currency' => 'SGD']]
GET /api/chair/omega/price
GET /api/chair/omega/price?timestamp=1440568980
GET /api/chair/omega/get-all-records
GET /api/chair/get-all-records
```
