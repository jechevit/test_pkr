# Тестовое задание с яблоками.

## Установка


1. Клонируем проект с GitHub:
    ````
    git clone https://github.com/jechevit/testApple.git
    ````
2. Открываем терминал и выполняем ```` init ```` выбрав  ```` dev ```` окружение.
3. Выполнить команду  ````composer update````.
4. Создать БД. Заполнить имя БД и реквизиты доступа в ````common/config/main-local.php````
5. Выполнить команду для создания таблиц RBAC ````php yii migrate --migrationPath=@yii/rbac/migrations````, и команду для миграций ```` php yii migrate```` и .
   > Уточнение. После выполнения миграции будет создан пользователь admin с правами админа (password: 123456789), и пользователь user с правами гостя (password: 123456789). 
6. Создать виртуальный хост для frontend. Зайти на backend, авторизоваться и генерировать яблоки.
