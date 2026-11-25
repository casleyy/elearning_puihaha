# Puihaha E-Learning Platform - Progress

This project uses `pilueta_laravel_updated` as the starting point. The older ZIP is an earlier subset and should not be overlaid on this project.

## Checklist

- [x] Member CRUD and search: create, profile, edit, deactivate/reactivate, search and filter. Membership numbers are generated uniquely. New member registration now creates a pending Application transaction.
- [x] Category and level management: CRUD screens and validation. Categories are seeded. Level fee, validity and benefits are editable; configure these before registering members.
- [x] Transaction processing: application and renewal transaction, unique transaction reference, payment record and payment reference, status changes (Pending, Paid, Approved, Cancelled, Expired), paid-only approval, renewal validity dates, transaction/payment history and printable receipt.
- [ ] MySQL: project is configured to use MySQL in `.env`; create the selected database and run migrations.
- [ ] Dashboard: totals for members, active memberships, pending transactions and collected payments.
- [ ] Authentication: login/logout and protect administrative routes.
- [ ] Final documentation and screenshots for submission.

## Start with the updated project

1. Extract this ZIP and open a terminal in its project folder.
2. Install dependencies with `composer install`.
3. Copy `.env.example` to `.env`, set the MySQL database name and credentials, then run `php artisan key:generate`.
4. Create the MySQL database named in `.env`.
5. Run `php artisan migrate` to add the new transaction, payment, and membership expiry tables/column. Do not run `migrate:fresh` against a database with work you need to keep.
6. Configure fees and validity periods in Membership Levels before creating members.
7. Start the app using `php artisan serve`. For automatic expiry updates, keep `php artisan schedule:work` running; the scheduled command marks past memberships as expired.

## Transaction workflow

Registering a member creates a Pending Application for that member's configured level fee. Record one full payment from the transaction page; this changes the status to Paid. Only Paid transactions can be approved. Approval activates the member and sets the membership expiry date. Create a Renewal transaction from the member profile to renew an existing record.

This is a classroom payment ledger: it records a payment method and amount, but it does not connect to a real bank, card processor, or GCash API.
