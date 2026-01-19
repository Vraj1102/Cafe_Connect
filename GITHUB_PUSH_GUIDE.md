# GitHub Push Guide

## Your Repository
**URL:** https://github.com/Vraj1102/Cafe_Connect

## Status
✅ Git initialized
✅ All files committed
✅ Remote repository configured
⏳ Ready to push

## Option 1: Push via Command Line (Recommended)

### Step 1: Open Command Prompt
```bash
cd C:\xampp\htdocs\CafeConnect
```

### Step 2: Push to GitHub
```bash
git push -u origin main
```

### Step 3: Authenticate
When prompted, enter:
- **Username:** Your GitHub username
- **Password:** Your Personal Access Token (NOT your GitHub password)

## Option 2: Use the Batch Script
Double-click: `push_to_github.bat`

## Getting Personal Access Token

If you don't have a Personal Access Token:

1. Go to: https://github.com/settings/tokens
2. Click "Generate new token" → "Generate new token (classic)"
3. Give it a name: "CafeConnect"
4. Select scopes: ✅ repo (all)
5. Click "Generate token"
6. **COPY THE TOKEN** (you won't see it again!)
7. Use this token as your password when pushing

## Alternative: Use GitHub Desktop

1. Download: https://desktop.github.com/
2. Install and sign in
3. File → Add Local Repository
4. Select: `C:\xampp\htdocs\CafeConnect`
5. Click "Publish repository"

## Verify Push Success

After pushing, visit:
https://github.com/Vraj1102/Cafe_Connect

You should see all your files!

## Files Excluded from Git

The following files are NOT pushed (for security):
- `config/stripe_config.php` (contains your Stripe keys)
- `config/conn_db.php` (contains database credentials)
- `/vendor/` directory (Composer dependencies)

Instead, example files are provided:
- `config/stripe_config.example.php`
- `config/conn_db.example.php`

## What's Included

✅ All source code
✅ Database schema (cafeconnect.sql)
✅ Design system CSS
✅ Documentation files
✅ Setup instructions
✅ Example configuration files

## Troubleshooting

### Error: "Authentication failed"
- Make sure you're using Personal Access Token, not password
- Generate new token at: https://github.com/settings/tokens

### Error: "Permission denied"
- Check if you have write access to the repository
- Verify repository URL: `git remote -v`

### Error: "Updates were rejected"
- Pull first: `git pull origin main`
- Then push: `git push origin main`

## Next Steps After Push

1. Update README.md on GitHub with project description
2. Add topics/tags to repository
3. Enable GitHub Pages (if needed)
4. Set up branch protection rules
5. Invite collaborators

## Need Help?

GitHub Docs: https://docs.github.com/en/get-started
