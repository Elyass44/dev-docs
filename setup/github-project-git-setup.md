# Git & GitHub Setup

Connect a symfony project to a GitHub repository.

---

## 1. Create GitHub Repository

Go to [github.com](https://github.com) and create a new repository:
- Choose repository name
- Select visibility (Public/Private)
- **DON'T** initialize with README, .gitignore, or license

After creation, GitHub will show you the repository URL.

---

## 2. Configure Git in wsl (First Time Only)

If not already configured:

```bash
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"
```

---

## 3. Setup SSH Key in wsl (First time only)

### Generate key:
```bash
ssh-keygen -t ed25519 -C "your.email@example.com"
```

### Add to SSH agent:
```bash
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/id_ed25519
```

### Copy public key and add to GitHub:
```bash
cat ~/.ssh/id_ed25519.pub
```

Go to GitHub → Settings → SSH and GPG keys → New SSH key → Paste and save.

### Test:
```bash
ssh -T git@github.com
```

## 4. Rename Branch from master to main

Symfony uses `master` by default, GitHub uses `main`:

```bash
cd your-project/
git branch -M main
```

---

## 5. Review and Commit Initial Setup

Check what will be committed:
```bash
git status
```

Add your Docker setup and any changes:
```bash
git add .
git commit -m "Initial project setup"
```

---

## 6. Link to GitHub & push

```bash
# Add remote (replace with your repository URL)
git remote add origin git@github.com:your-username/your-project-name.git

# Push to GitHub
git push -u origin main
```

---

## Useful Commands

```bash
# View commit history
git log --oneline

# Pull latest changes
git pull

# Discard local changes
git checkout -- filename

# Create new branch
git checkout -b feature/new-feature

# Switch branches
git checkout main
```
