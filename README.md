# testM2E

## Консольна команда

Реалізовано консольна команда - upload-file яка обробляє файли типу csv та xml.

Знаходиться -  App\Console\Commands\UploadFile\UploadFIleCommand

В дожбі виконується увесь процес обробки файлу 

## Запис та оновлення даних

Оновленння даних та запис виконує метод updateMultiple
App\Services\UploadFil\UploadFileService

## Фільтрація

Фільтрація по даному - ship_to_name, customer_email, status, виконана в App\Http\Controllers\UploadFile\UploadFileController

## Використання

Використовував докер який також тут є у папці docker. Ще використовував фреймворк Laravel 10.10, mysql:8.0, php 8.1, nginx
