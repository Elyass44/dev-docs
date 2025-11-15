# WSL Development Environment Setup Guide

Complete guide to setting up a modern development environment with WSL, Oh My Zsh, Docker, and Symfony CLI on Windows.

---

## 1. Install Cmder (Optional)

1. Download Cmder from [cmder.app](https://cmder.app/)
2. Extract and run Cmder
3. Configure Cmder aliases by editing: `%CMDER_ROOT%\config\user_aliases.cmd`
4. Add a custom alias for WSL:
   ```
   linux=wsl ~
   ```
5. Save and restart Cmder

---

## 2. Install WSL

Open Cmder or PowerShell as Administrator and run:

```bash
wsl --install
```

This installs WSL 2 with Ubuntu by default. Restart your computer when prompted.

After restart, set up your Linux username and password when prompted.

### Starting WSL at home directory

- Direct command: `wsl ~`
- Or use your Cmder alias: `linux`

---

## 3. Install Oh My Zsh (Optional)

Inside WSL:

### Install Zsh
```bash
sudo apt update
sudo apt install zsh
```

### Install Oh My Zsh
```bash
sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"
```

### Set Zsh as default shell
```bash
chsh -s $(which zsh)
```

Close and reopen WSL to apply changes.

---

## 4. Install Docker

### Install Docker Desktop for Windows

1. Download and install [Docker Desktop](https://www.docker.com/products/docker-desktop/)
2. Restart your computer when prompted
3. Open Docker Desktop
4. Go to **Settings → Resources → WSL Integration**
5. Enable integration with your WSL distro (Ubuntu)
6. Apply & Restart

### Verify Docker in WSL

```bash
docker --version
docker ps
docker run hello-world
```

---

## 5. Install Symfony CLI and Requirements (inside wsl)

### Install PHP and required extensions

```bash
sudo apt update
sudo apt install php php-cli php-fpm php-mysql php-xml php-curl php-mbstring php-zip php-intl php-gd unzip
```

### Install Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

Verify installation:
```bash
composer --version
```

### Install Symfony CLI

```bash
curl -sS https://get.symfony.com/cli/installer | bash
```

### Add Symfony to PATH

Edit `~/.zshrc`:
```bash
nano ~/.zshrc
```

Add this line at the end:
```bash
export PATH="$HOME/.symfony5/bin:$PATH"
```

Reload the configuration:
```bash
source ~/.zshrc
```

### Verify Symfony installation

```bash
symfony -V
symfony check:requirements
```

---

## Summary

You now have a complete development environment with:
- Cmder terminal with custom aliases
- WSL 2 with Ubuntu
- Oh My Zsh for an enhanced shell experience
- Docker Desktop with WSL integration
- PHP with all required extensions
- Composer for dependency management
- Symfony CLI for project creation and management
