# practice_programmming_lab
# Practice Programming Lab 🚀

A local web-based programming practice dashboard built with PHP. Browse your programming files, view source code, run supported programs, provide interactive input, and inspect program output and errors from one interface.

**Repository:** [practice_programmming_lab](https://github.com/sparkz8085/practice_programmming_lab)

## ✨ Features

- 📂 **Recursive File Scanner** — Automatically discovers supported source files inside the project directory and its subdirectories.
- 🔎 **Keyboard-Based File Search** — Find programming files quickly.
- 📝 **Source Code Viewer** — View source code directly in the dashboard.
- ▶️ **Run Programs** — Compile or check code before execution where supported by the runner.
- 💻 **Interactive Console** — Provide input to running programs and view their output.
- 🛠️ **Readable Error Messages** — Get simplified explanations for selected common programming errors, alongside technical details.
- 🌐 **Multi-Language Practice** — Work with several programming languages from one dashboard.
- ⏹️ **Program Control** — Stop running programs through the dashboard.

## 🧑‍💻 Supported Languages

The runner is designed to support the following languages, provided their required runtimes or compilers are installed:

- PHP
- Python
- Java
- C
- C++
- JavaScript
- TypeScript
- Go
- Rust
- Ruby
- Perl
- Lua
- Kotlin

Actual compatibility depends on the installed toolchains, source-file format, and runner configuration.

## 📋 Requirements

- Linux environment (Fedora Linux is the primary development environment)
- XAMPP for Linux, including Apache and PHP CLI
- PHP 8.0 or later
- Git
- A compatible compiler or interpreter for each language you want to run
- A modern web browser

**Important:** The current runner uses `/opt/lampp/bin/php` to launch its background process. If your XAMPP installation uses a different path, update the configuration in `index.php`.

## ⚙️ Installation

### 1. Clone the repository

Open a terminal and run:

```bash
cd /opt/lampp/htdocs
sudo git clone https://github.com/sparkz8085/practice_programmming_lab.git
```

### 2. Set project ownership

```bash
sudo chown -R "$USER":"$(id -gn)" \
practice_programmming_lab
```

### 3. Start XAMPP

```bash
sudo /opt/lampp/lampp start
```

### 4. Install required language toolchains

Install the compilers and interpreters for the languages you want to use. For example, on Fedora:

```bash
sudo dnf install git gcc gcc-c++ make \
python3 nodejs npm ruby perl lua golang rust cargo
```

Java and other language toolchains may need to be installed separately. Follow the official installation instructions for each language.

### 5. Open the dashboard

Visit:

```text
http://localhost/practice_programmming_lab/
```

## ▶️ How to Use

1. Start Apache through XAMPP.
2. Open the dashboard in your browser.
3. Select a supported source file.
4. Review the displayed code.
5. Click **Run** to start the program.
6. If the program requests input, enter the required value in the console and submit it.
7. Review the output or error explanation.
8. Stop the program when necessary.

## 📁 Project Structure

```text
practice_programmming_lab/
├── index.php       # Web dashboard and API endpoints
├── runner.php      # Background execution and process management
├── README.md       # Project documentation
├── .gitignore      # Git exclusions
└── *.java          # Example programming exercises
```

Other source files and subdirectories can be added as needed.

## 🔐 Security Notice

**This project is intended for local development and trusted environments.**

The runner executes source code on the host machine. Running untrusted code through a web-accessible runner can expose files, processes, and system resources.

- Do not expose this dashboard directly to the public Internet.
- Do not run untrusted programs.
- Do not run the web server or runner with unnecessary administrative privileges.
- Use a properly isolated sandbox with resource limits before considering multi-user or public deployment.
- Never commit passwords, API keys, database credentials, or private configuration files.

The current runner's execution controls should not be treated as a complete security sandbox.

## 🚧 Project Status

This is a programming practice project under development. Some languages, environments, and interactive programs may require additional configuration or testing.

Contributions, bug reports, and suggestions are welcome.

## 👨‍💻 Author

**sparkz8085**

GitHub: [@sparkz8085](https://github.com/sparkz8085)



## 🪟 Windows Setup Guide

This section explains how to prepare the project on Windows. **The current background runner is Linux-oriented and requires Windows compatibility updates before program execution will work reliably.**

### 📋 Requirements

- Windows 10 or Windows 11
- Git for Windows
- XAMPP for Windows
- A modern web browser
- Compilers or interpreters for the programming languages you want to use

### 1. Install XAMPP

Download XAMPP for Windows from the official website:

https://www.apachefriends.org/

Install it using the default location:

```text
C:\xampp
```

Open the XAMPP Control Panel and start **Apache**.

### 2. Clone the Repository

Open PowerShell or Git Bash and run:

```powershell
cd C:\xampp\htdocs
git clone https://github.com/sparkz8085/practice_programmming_lab.git
```

The project folder should be:

```text
C:\xampp\htdocs\practice_programmming_lab
```

### 3. Open the Dashboard

Open your browser and visit:

```text
http://localhost/practice_programmming_lab/
```

Apache should serve the PHP dashboard if the installation is configured correctly.

### 4. Install Language Toolchains

Install the compilers or interpreters for the languages you intend to use. For example:

- PHP — included with XAMPP
- Python — https://www.python.org/downloads/windows/
- Java — https://adoptium.net/
- Node.js — https://nodejs.org/
- C/C++ — install a suitable Windows compiler toolchain

Verify each installation in PowerShell using its version command, such as:

```powershell
php --version
python --version
java --version
node --version
gcc --version
```

Not every command will work until the corresponding toolchain is installed and configured in `PATH`.

### ⚠️ Windows Compatibility Status

The current runner uses Linux-specific process-launching commands and a Linux PHP executable path. Consequently, the dashboard's program-execution features are **not yet guaranteed to work on Windows**.

Before using the Run feature on Windows, the runner must be adapted to use Windows-compatible process management, executable paths, and command handling.

Do not expose the runner to the public Internet. It executes code on the host machine and requires appropriate isolation before being used with untrusted programs.


---

If you find this project useful, consider giving the repository a ⭐ on GitHub!
