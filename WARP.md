# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

Triangle POS (branded as "Hamro POS") is a Laravel-based Point of Sale system with modular architecture. It uses Laravel 10 with PHP 8.1+ and includes features for products, sales, purchases, inventory management, and reporting.

## Development Commands

### Local Development Setup
```bash
composer install
npm install
npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

### Frontend Assets
```bash
npm run dev          # Development build with Vite
npm run build        # Production build
```

### Database Operations
```bash
php artisan migrate --seed    # Run migrations with seeders
php artisan migrate:fresh     # Fresh migration (drops all tables)
php artisan db:seed          # Run only seeders
```

### Testing
```bash
./vendor/bin/phpunit                    # Run all tests
./vendor/bin/phpunit tests/Unit         # Run unit tests only
./vendor/bin/phpunit tests/Feature      # Run feature tests only
```

### Cache and Optimization
```bash
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Docker Deployment
```bash
docker build -t hamro-pos .
docker compose up -d --build
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

## Architecture

### Modular Structure
The application uses `nwidart/laravel-modules` for a modular architecture. Each business domain is a separate module in the `/Modules` directory:

- **Product**: Product management, categories, barcode printing
- **Sale/Purchase**: Transaction management
- **People**: Customer and supplier management  
- **Expense**: Expense tracking
- **Currency**: Multi-currency support
- **Adjustment**: Stock adjustments
- **Reports**: Business reporting
- **Setting**: System configuration
- **User**: User management with roles/permissions

Each module has its own:
- Controllers (`Http/Controllers/`)
- Models (`Entities/`)
- Routes (`Routes/web.php`, `Routes/api.php`)
- Database migrations (`Database/Migrations/`)
- Views (`Resources/views/`)

### Core Components

**Shopping Cart**: Uses `anayarojo/shoppingcart` for cart functionality with Livewire components (`app/Livewire/ProductCart.php`, `app/Livewire/SearchProduct.php`)

**Permissions**: Implements `spatie/laravel-permission` for role-based access control

**PDF Generation**: Uses `barryvdh/laravel-snappy` with wkhtmltopdf for invoices and reports

**Media Management**: Uses `spatie/laravel-medialibrary` for file uploads and product images

**DataTables**: Each module uses `yajra/laravel-datatables` for data presentation

### Key Helper Functions
Located in `app/Helpers/helpers.php`:
- `settings()`: Cached system settings retrieval
- `format_currency()`: Multi-currency formatting
- `make_reference_id()`: Generate reference numbers
- `array_merge_numeric_values()`: Utility for numeric array merging

### Authentication & Authorization
- Registration disabled (`Auth::routes(['register' => false])`)
- Default admin: `super.admin@test.com` / `12345678`
- Role-based permissions throughout modules

## Database

- **Default DB**: `hamro_pos` (MySQL)
- **Seeded data**: Includes sample products, users, and settings
- **Key tables**: Products, categories, sales, purchases, customers, suppliers, users, permissions

## Frontend

- **Framework**: Laravel Blade with Livewire 3.0
- **CSS Framework**: Bootstrap 4 + CoreUI
- **Build Tool**: Vite (replaces Laravel Mix)
- **Assets**: `resources/sass/app.scss`, `resources/js/app.js`, `resources/js/chart-config.js`

## Production Considerations

- PDF generation requires wkhtmltopdf binary (auto-configured for Linux)
- File storage uses local filesystem by default
- Session-based authentication
- Multi-currency support with configurable positions and separators
- Barcode generation for products using `milon/barcode`

## Module Development Pattern

When creating new modules or modifying existing ones:
1. Use Artisan commands: `php artisan module:make ModuleName`
2. Follow the established directory structure
3. Register routes in module's `Routes/web.php`
4. Use DataTable classes for listing pages
5. Implement proper permission checks in controllers
6. Follow the cart pattern for transaction-based modules

## Vercel Deployment

### Prerequisites
- Vercel account and CLI installed
- Serverless database (PlanetScale, Supabase, or AWS RDS)
- S3-compatible storage for file uploads
- SMTP service for email notifications

### Setup Steps

#### 1. Database Setup
```bash
# Option 1: PlanetScale (Recommended)
curl -L https://github.com/planetscale/cli/releases/latest/download/pscale_*_linux_amd64.tar.gz | tar -xz
pscale auth login
pscale database create hamro-pos
pscale connect hamro-pos

# Option 2: Supabase
npx supabase init
npx supabase start
```

#### 2. Environment Variables
Copy `.env.vercel` and configure in Vercel dashboard:
```bash
cp .env.vercel .env.production
# Edit with your actual credentials
```

Required Vercel environment variables:
- `APP_KEY`: Generate with `php artisan key:generate`
- `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_BUCKET`
- SMTP credentials for email functionality

#### 3. Deploy to Vercel
```bash
# Install Vercel CLI
npm i -g vercel

# Login and deploy
vercel login
vercel --prod

# Run setup script (one time only)
php vercel-setup.php
```

#### 4. Post-Deployment
```bash
# Test the deployment
curl https://your-app.vercel.app/api/health

# Monitor logs
vercel logs
```

### Limitations on Vercel

⚠️ **Important Considerations:**

1. **PDF Generation**: Limited wkhtmltopdf support - consider using browser-based PDF generation
2. **File Storage**: Must use cloud storage (S3/Cloudinary) - local storage not persistent
3. **Database**: No persistent local database - requires external database service
4. **Sessions**: Use cookie-based sessions, not file-based
5. **Cron Jobs**: Not supported - use external cron services or Vercel's cron features
6. **Cold Starts**: First request after idle period may be slower
7. **Function Timeout**: 30-second limit on function execution
8. **Memory Limits**: 1GB RAM limit per function

### Alternative Recommendations

For a full-featured POS system, consider these platforms instead:

- **Railway**: Better Laravel support with persistent storage
- **DigitalOcean App Platform**: Managed Laravel hosting
- **AWS Elastic Beanstalk**: Full PHP application support
- **Oracle Cloud (Free Tier)**: VM with Docker deployment

### Vercel-Optimized Features

When deploying to Vercel, these features work well:
- Product catalog browsing
- User authentication
- Basic reporting (with external DB)
- API endpoints
- Static asset delivery
