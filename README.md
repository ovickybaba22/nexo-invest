<p align="center">
  <img src="public/img/logo_white.png" alt="Nexo Invest" width="140">
</p>

# Nexo Invest

Modern Laravel + Vite application that powers the Nexo Invest landing page, client dashboard, deposits / withdrawals, profit engine, and admin utilities. This README captures everything you need to run the project locally and deploy it safely.

## Requirements

- PHP 8.3 with the following extensions: `pdo_mysql`, `openssl`, `mbstring`, `curl`, `intl`, `bcmath`.
- Composer 2.x
- Node 18+ / npm 9+
- MySQL 8 (or compatible)

## Local setup

```bash
git clone <repo>
cd nexo-invest
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
```

Run the dev servers:

```bash
npm run dev        # Vite + Tailwind watcher
php artisan serve  # Laravel API + web UI
```

Visit `http://localhost:8000`.

## Environment variables

`APP_NAME`, `APP_URL`, `APP_ENV`, `APP_DEBUG` – standard Laravel settings.  
`DB_*` – database credentials.  
`QUEUE_CONNECTION` – defaults to `database`. Ensure `php artisan queue:work` runs anywhere email/IPN jobs are dispatched.  
`MAIL_*` – configure your SMTP provider before production.  
`NOWPAYMENTS_API_KEY`, `NOWPAYMENTS_IPN_KEY`, `NOWPAYMENTS_IPN_URL` – required for the crypto deposit flow.  
`NOWPAYMENTS_ALLOWED_CURRENCIES` – comma-separated fiat currencies you want to expose in the deposit form (defaults to `USD,EUR,GBP,BTC,ETH,USDT,USDC`).  
`APP_URL` should match the public HTTPS domain (TradingView + NOWPayments verify this value).

After editing env vars run:

```bash
php artisan optimize:clear
```

## Background jobs & scheduler

- **Profit accrual** (`investments:accrue-daily-profit`) is registered in `app/Console/Kernel.php` and runs daily at `00:05`. Production servers must execute Laravel’s scheduler every minute:

  ```
  * * * * * php /var/www/nexo-invest/artisan schedule:run >> /dev/null 2>&1
  ```

- **Queue worker** – run `php artisan queue:work --tries=3` under a supervisor so deposit emails and withdrawal notifications send reliably.  
  A ready-to-copy sample is available in `deploy/supervisor/nexo-queue.conf`:

  ```bash
  sudo cp deploy/supervisor/nexo-queue.conf /etc/supervisor/conf.d/nexo-queue.conf
  sudo supervisorctl reread
  sudo supervisorctl update
  sudo supervisorctl start nexo_queue:*
  ```

## Building for production

```bash
npm run build      # Generates hashed CSS/JS via Vite
php artisan config:cache route:cache view:cache event:cache
```

## Deployment checklist

1. Ensure `.env` contains production values (database, mail, NOWPayments, `APP_URL=https://…`).
2. Run database migrations (`php artisan migrate --force`).
3. Build assets with `npm run build` (or via CI).
4. Clear + cache config/routes/views as shown above.
5. Start queue worker(s) and confirm the cron entry is invoking `schedule:run`.
6. Serve the app over HTTPS (TradingView + NOWPayments require it).
7. Whitelist your domain with TradingView widgets (per their embed policy).

## Tests

```
php artisan test
```

## Support / contact

Open an issue or contact the engineering team that maintains the Nexo Invest platform. This project is proprietary and should not be redistributed without approval.
