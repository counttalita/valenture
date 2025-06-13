# Learner Progress Dashboard - Coding Challenge

## Getting Started

The following instructions will get the project up and running on a fresh Linux (Ubuntu/Debian recommended) machine. These steps assume basic familiarity with the Linux terminal.

### 1. Prerequisites

- **PHP 8.2+** (with extensions: mbstring, pdo, openssl, tokenizer, xml, ctype, json, bcmath, fileinfo)
- **Composer** (latest)
- **Node.js** (v18+ recommended) & npm
- **SQLite** (or MySQL/PostgreSQL, but SQLite is default)
- **Git**

#### Install PHP & Extensions
```bash
sudo apt update
sudo apt install php php-mbstring php-xml php-bcmath php-json php-ctype php-fileinfo php-pdo php-sqlite3 unzip curl git -y
```

#### Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### Install Node.js & npm
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

### 2. Clone the Repository
```bash
git clone <your-repo-url>
cd learner-progress
```

### 3. Install PHP Dependencies
```bash
composer install
```

### 4. Install Node.js Dependencies (for frontend)
```bash
npm install
```

### 5. Environment Setup
- Copy the example environment file:
```bash
cp .env.example .env
```
- Edit `.env` to set your `APP_NAME`, `APP_URL`, and database settings (SQLite is default):
  - For SQLite, ensure you have a `database/database.sqlite` file:
```bash
touch database/database.sqlite
```
  - In `.env`, set:
```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/your/project/database/database.sqlite
```

### 6. Generate Application Key
```bash
php artisan key:generate
```

### 7. Run Migrations & Seed Database
```bash
php artisan migrate --seed
```

### 8. Build Frontend Assets (if using Vite or Mix)
```bash
npm run build    # For production
# or
npm run dev      # For hot-reload during development
```

### 9. Set Permissions (Important for Linux)
```bash
sudo chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### 10. Start the Development Servers
- **Backend (Laravel API):**
```bash
php artisan serve
```
- **Frontend (if using Vite):**
```bash
npm run dev
```

Visit the app at [http://localhost:8000](http://localhost:8000) (or the port shown in your terminal).

---

## Troubleshooting & Common Issues
- **Blank Page or 500 Error:** Check `.env` settings, run `php artisan config:clear` and `php artisan cache:clear`.
- **Permission Denied:** Ensure `storage` and `bootstrap/cache` are writable by web server.
- **Missing PHP Extensions:** Run `php -m` and install any missing extensions.
- **Node/NPM Issues:** Delete `node_modules` and run `npm install` again.
- **Database Errors:** Ensure your SQLite file exists and path is correct in `.env`.

---

## Useful Commands
- `php artisan migrate:fresh --seed` — Reset and reseed database
- `php artisan route:list` — List all API/web routes
- `php artisan tinker` — Interactive shell for Laravel
- `npm run dev` — Hot-reload frontend
- `npm run build` — Production frontend build

---

## Project Structure (key folders)
- `app/` — Laravel app code (models, controllers, etc)
- `database/` — Migrations, seeders, SQLite file
- `routes/` — API and web route definitions
- `resources/views/` — Blade templates (UI)
- `public/` — Public web root
- `package.json` — Node.js dependencies
- `composer.json` — PHP dependencies

---

For any issues, please check the Laravel and Node.js documentation, or contact the project maintainer.