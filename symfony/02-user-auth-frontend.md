# User Authentication Frontend

Setup user authentication with login form for Symfony.

---

## 1. Create User Entity

```bash
make bash
bin/console make:user
```

Answer the prompts:
- Class name: **User**
- Store users in database: **yes**
- Unique property: **email**
- Hash passwords: **yes**

This creates:
- `src/Entity/User.php`
- `src/Repository/UserRepository.php`

---

## 2. Create Migration

```bash
bin/console make:migration
bin/console doctrine:migrations:migrate
```

---

## 3. Create Login Form

```bash
bin/console make:security:form-login
```

This creates:
- `src/Controller/SecurityController.php`
- `templates/security/login.html.twig`

**Note:** This command also automatically updates `config/packages/security.yaml` with the firewall configuration.

---

## 4. Create Test User (Optional)

```bash
bin/console make:command app:create-user
```

For a complete user creation command template, see: [CreateUserCommand.php](../../templates/symfony/CreateUserCommand.php)

Run it:
```bash
bin/console app:create-user
bin/console app:create-user --admin
```

---

## 5. Test Authentication

1. Visit http://localhost:8080/login
2. Try login if you created a user
3. You should be redirected to home page
4. To log out http://localhost:8080/logout
