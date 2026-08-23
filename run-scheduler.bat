@echo off
"C:\laragon\bin\php\php-8.5.6-Win32-vs17-x64\php.exe" "C:\laragon\www\presensi-kko\artisan" schedule:run >> "C:\laragon\www\presensi-kko\storage\logs\scheduler.log" 2>&1
