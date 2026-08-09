# Madlancer

A freelance services marketplace built with Laravel 9 and Livewire, where sellers list services (gigs), buyers browse categories and place orders, and both sides manage the order lifecycle through messaging, deliveries, reviews, and refunds.

## Features

- Service listings by category, with search and filtering
- Cart and checkout with Stripe / PayPal payments
- Seller dashboard for managing orders, deliveries, and earnings
- Buyer account area: orders, favorites, reviews, refund requests, billing
- In-app messaging between buyers and sellers
- Social login (Google, Facebook, LinkedIn, Twitter) via Laravel Socialite

## Tech stack

- PHP 8.0+ / Laravel 9
- Livewire 2
- MySQL
- Tailwind CSS
- Stripe (Cashier) and PayPal for payments

## Local setup

```bash
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```
