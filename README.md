# Practice Programming Lab

A local PHP-based programming practice dashboard for browsing source files, viewing code, and running supported programs.

## Features

- Browse and search programming files
- View source code in the browser
- Run supported programs and view output
- Interactive input and basic error reporting
- Organised Java and PHP practical collections

## Lab Exercises

| Folder | Contents |
|---|---|
| `Java_Lab_BCAC592/` | 19 Object Oriented Programming with Java lab exercises |
| `PHP_MySQL_Lab_BCAC591/` | 22 PHP & MySQL lab exercises, database schema and sample data |
| `Existing_Programs/Java/` | Previously collected Java practice programs |
| `Existing_Programs/PHP/` | Previously collected PHP practice files |

Each lab folder has its own README with instructions.

## Requirements

- PHP 8+
- Apache (XAMPP recommended)
- Java JDK for Java exercises
- MySQL/MariaDB for database exercises
- Compilers or interpreters for other languages you want to run

## Setup

1. Clone this repository into your web server's document root (for XAMPP, `htdocs`).
2. Start Apache from the XAMPP Control Panel.
3. Open:

   `http://localhost/practice_programmming_lab/`

4. Install the required compiler or interpreter for the language you want to use.

For PHP & MySQL exercises, import `PHP_MySQL_Lab_BCAC591/database.sql` into MySQL and follow that folder's README.

## Security Notice

This project is intended for local practice. The program runner executes code on the host machine and is **not a secure sandbox**. Do not expose it to the public Internet or use it to run untrusted code. Use proper isolation and resource limits before considering public or multi-user deployment.

## Project Status

Under development. Runtime support depends on the installed toolchains and runner configuration; not every language or exercise has been tested on every platform.

## Author

**sparkz8085** · [GitHub](https://github.com/sparkz8085)
