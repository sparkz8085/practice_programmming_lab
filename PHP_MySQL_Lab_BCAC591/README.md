# PHP & MySQL Lab — BCAC 591

This folder contains the 22 PHP & MySQL practical exercises from the BCAC 591 lab sheet.

## Requirements

- PHP 8.0 or later
- MySQL or MariaDB
- PHP PDO MySQL extension
- Apache through XAMPP, or PHP's built-in development server

## Run the basic exercises

Place this folder inside your web server document root (for XAMPP, `htdocs`). Open the required PHP file through localhost, for example:

```
http://localhost/PHP_MySQL_Lab_BCAC591/01_welcome.php
```

The text-file exercises use `sample.txt` in this folder. The write exercise creates `form_data.txt`; ensure the web server can write to this directory.

## Run the database exercises (17–22)

1. Start Apache and MySQL.
2. Import `database.sql` using phpMyAdmin or the MySQL command line.
3. Open `db.php` and set the database host, name, username and password, or define the environment variables `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASS`.
4. Register an account using `17_registration_login.php`.
5. Log in, then open the CMS, voting, event and forum exercises. The CMS, voting, event and forum pages require a logged-in account.
6. Add sample candidates, products and events using phpMyAdmin or the statements in `seed.sql`.

## Files

- `01`–`16`: PHP basics, forms, arrays, file handling and OOP.
- `17`: Registration and login with password hashing.
- `18`: Basic content management system.
- `19`: Demo voting system with a unique vote per account.
- `20`: Product catalogue with category filtering and search.
- `21`: Event listing and registration.
- `22`: Discussion forum with threads and replies.

These are educational lab exercises, not production-ready applications. The voting exercise is a demonstration and must not be used for real elections. For public deployment, add CSRF protection, stronger authorization, rate limiting, logging, and a security review.
