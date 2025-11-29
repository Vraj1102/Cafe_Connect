@echo off
echo Fixing all PHP file paths...
echo.

REM Fix customer files
for %%f in (customer\*.php) do (
    powershell -Command "(Get-Content '%%f') -replace 'include\(\"conn_db.php\"\)', 'include(\"../config/conn_db.php\")' -replace 'include\(''conn_db.php''\)', 'include(''../config/conn_db.php'')' -replace 'include\(\"head.php\"\)', 'include(\"../includes/head.php\")' -replace 'include\(''head.php''\)', 'include(''../includes/head.php'')' -replace 'include\(\"nav_header.php\"\)', 'include(\"../includes/nav_header.php\")' -replace 'include\(''nav_header.php''\)', 'include(''../includes/nav_header.php'')' -replace 'include\(\"restricted.php\"\)', 'include(\"../includes/restricted.php\")' -replace 'include\(''restricted.php''\)', 'include(''../includes/restricted.php'')' -replace 'href=\"css/', 'href=\"../assets/css/' -replace 'href=''css/', 'href=''../assets/css/' -replace 'src=\"js/', 'src=\"../assets/js/' -replace 'src=''js/', 'src=''../assets/js/' -replace 'src=\"img/', 'src=\"/Sai Cafe/assets/img/' -replace 'src=''img/', 'src=''/Sai Cafe/assets/img/' -replace 'src=\\\"img/', 'src=\"/Sai Cafe/assets/img/' | Set-Content '%%f'"
    echo Fixed: %%f
)

echo.
echo All customer files fixed!
pause
