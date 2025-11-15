# Symfony Project with Docker Setup

Guide to create a new Symfony project with Docker (PHP, Nginx, PostgreSQL, Mailpit).

---

## Prerequisites

### Install Make

```bash
sudo apt update
sudo apt install make
```

---

## 1. Create Symfony Project

```bash
cd ~/www
symfony new project-name --webapp
cd project-name
```

**Options:**
- `--webapp` - Full application (Twig, Doctrine, Security, Forms)
- No flag - Minimal installation
- `--version=7.2` - To define symfony version

---

## 2. Docker Stack

| Service | Port | Description |
|---------|------|-------------|
| Nginx | 8080 | Web server |
| PHP 8.3-FPM | 9000 | PHP with pdo_pgsql, intl, gd, zip, opcache |
| PostgreSQL 16 | 5432 | Database |
| Mailpit | 1080 | Email viewer (web UI) |
| Mailpit SMTP | 1025 | Mail server |
| DB Browser | 3001 | Database management UI |

---

## 3. Project Structure

```
project-name/
├── compose.yaml                    # Docker services
├── Makefile                        # Commands shortcuts
├── .env.local                      # Local environment config
├── docker/
│   ├── Dockerfile                 # PHP image
│   ├── nginx.conf                 # Nginx config
│   ├── entrypoint.sh             # Auto-setup script
│   └── prod/                      # Production files (future)
├── src/
├── public/
├── var/
└── config/
```

---

## 4. Setup Files

Copy these template files to your project:

### Templates available at: `~/dev-docs/templates/`

1. **[compose.yaml](../templates/docker/compose.yaml)** → project root
2. **[Dockerfile](../templates/docker/Dockerfile)** → `docker/Dockerfile`
3. **[nginx.conf](../templates/docker/nginx.conf)** → `docker/nginx.conf`
4. **[entrypoint.sh](../templates/docker/entrypoint.sh)** → `docker/entrypoint.sh`
5. **[Makefile](../templates/Makefile)** → project root

**Important:** Make entrypoint executable:
```bash
chmod +x docker/entrypoint.sh
```

---

## 5. Configuration

### Create `.env.local` file

```bash
APP_ENV=dev

# Database (adjust if needed)
DATABASE_URL=postgresql://db_user:db_password@postgres:5432/db_name?serverVersion=16&charset=utf8

# Mailer
MAILER_DSN=smtp://mailpit:1025
```

**Note:** Adjust database credentials to match your `compose.yaml`

---

## 6. Start Everything

```bash
make build
```

That's it! The entrypoint automatically:
- Waits for PostgreSQL
- Installs Composer dependencies
- Creates the database
- Sets proper permissions

---

## 7. Make Commands

| Command | Description |
|---------|-------------|
| `make start` | Start containers |
| `make build` | Build & start (no cache) |
| `make stop` | Stop containers |
| `make restart` | Restart containers |
| `make bash` | Enter PHP container (www-data) |
| `make bash-root` | Enter PHP container (root) |
| `make log` | Symfony logs |
| `make log-clear` | Clear Symfony logs |
| `make dlog` | Docker logs |
| `make clear-cache` | Clear Symfony cache |

---

## 8. Access Points

- **App:** http://localhost:8080
- **Mailpit:** http://localhost:1080
- **DB Browser:** http://localhost:3001
- **PostgreSQL:** localhost:5432

---

## 9. Daily Workflow

### Start:
```bash
make start
```

### Run symfony commands:
```bash
make bash
php bin/console doctrine:migrations:migrate
php bin/console *
```

### Stop:
```bash
make stop
```

---

## Troubleshooting

### Check logs:
```bash
make dlog
make log
```

### Permission issues:
```bash
make bash-root
chown -R www-data:www-data var/
```

### Rebuild everything:
```bash
make stop
docker system prune -a
make build
```
