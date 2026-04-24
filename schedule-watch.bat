@echo off
cd /d d:\laragon\www\kso

:loop
echo [%date% %time%] Starting schedule:work...
D:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan schedule:work

echo [%date% %time%] Process crashed. Restarting in 5 seconds...
timeout /t 5 > nul

goto loop