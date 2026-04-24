Set WshShell = CreateObject("WScript.Shell")
WshShell.CurrentDirectory = "D:\laragon\www\receiptServer"
WshShell.Run "D:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan schedule:run", 0, False