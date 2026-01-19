@echo off
echo ========================================
echo CafeConnect - Push to GitHub
echo ========================================
echo.
echo Repository: https://github.com/Vraj1102/Cafe_Connect.git
echo.
echo IMPORTANT: Make sure you have:
echo 1. GitHub account logged in
echo 2. Personal Access Token (if using HTTPS)
echo    OR
echo 3. SSH key configured (if using SSH)
echo.
echo ========================================
echo.

cd /d "%~dp0"

echo Checking Git status...
git status

echo.
echo Pushing to GitHub...
git push -u origin main

echo.
echo ========================================
echo.
if %ERRORLEVEL% EQU 0 (
    echo SUCCESS! Project pushed to GitHub.
    echo View at: https://github.com/Vraj1102/Cafe_Connect
) else (
    echo FAILED! Please check your GitHub credentials.
    echo.
    echo If you need to authenticate:
    echo 1. Generate Personal Access Token at: https://github.com/settings/tokens
    echo 2. Use token as password when prompted
    echo.
    echo OR configure SSH: https://docs.github.com/en/authentication/connecting-to-github-with-ssh
)
echo.
pause
