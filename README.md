# Задание
+ Реализовать контроллер с валидацией и загрузкой excel файла.
+ Доступ к контроллеру загрузки закрыть basic-авторизацией.
+ Загруженный файл через jobs поэтапно (по 1000 строк) парсить в БД (таблица rows).
+ Прогресс парсинга файла хранить в redis (уникальный ключ + количество обработанных строк).
+ Поля excel: id, name, date (d.m.Y)
+ Для парсинга excel можете использовать любой пакет из composer
+ Реализовать контроллер для вывода импортированных данных (rows) с группировкой по date - двумерный массив
+ Будет плюсом если вы реализуете через laravel echo передачу event-а на создание записи в rows
+ Будет плюсом написание тестов

Пример файла для импорта: https://yadi.sk/i/YuwPGwcIzv1DBQ

# Необходимо настроить в .ENV
+ DB - подключение
+ QUEUE_CONNECTION
+ BROADCAST_DRIVER=pusher
+ REDIS_CLIENT=predis
+ PUSHER_APP_ID=APP_ID (random)
+ PUSHER_APP_KEY=APP_KEY (random)
+ PUSHER_APP_SECRET=APP_SECRET (random)

# Для запуска проекта выполнить команды
+ php artisan migrate:refresh --seed
+ php artisan queue:work
+ php artisan websockets:serve

# Загрузки файла и отображение сообщений 
+ главная стр

# Учетные данные (default)
+ Пользователь: test@test.ru
+ Пароль: test
