Test task 1
============


Russian description
-------------

Написать систему аутентификации пользователей. Система должна предоставлять форму входа (имя
пользователя и пароль) и страницу пользователя в системе.

Функциональные требования к системе:
1. Форма входа должна содержать два текстовых поля для ввода имени пользователя и пароля.
2. В случае успешного входа должна быть показана страница пользователя.
3. Страница пользователя должна содержать сообщение: «Добрый день, <имя пользователя>» и
кнопку выхода из системы.
4. При нажатии на кнопку выхода должна открываться страница входа.
5. В случае неуспешного входа должна быть показана страница входа с сообщением: «Неверные
данные».
6. После успешного входа страница входа не должна быть доступна, пользователь должен быть
перенаправлен на страницу пользователя.
7. Страница пользователя не должна быть доступна, если вход не выполнен. Пользователь должен
быть перенаправлен на страницу входа.
8. В случае 3-х неуспешных попыток входа подряд система должна быть заблокирована на 5 минут,
при этом при попытке входа должно выводиться сообщение: «Попробуйте еще раз через <N>
секунд».

Требования к реализации:
1. Данные хранить в текстовом файле, базу данных не использовать.
2. При разработке желательно использовать архитектуру MVC.
3. Допускается использование фреймворка на выбор исполнителя.

English description
-------------

To write an authentication system of users. The system shall provide the form of an input (a name
the user and the password) and the page of the user in system.

The functional requirements to system:
1. The form of an input shall contain two text boxes for input of user name and the password.
2. In case of a successful input the page of the user shall be shown.
3. The page of the user shall contain the message: "Good afternoon, <username>" and
button of leaving the system.
4. When clicking the button of an output the page of an input shall open.
5. In case of an unsuccessful input the page of an input with the message shall be shown: "Incorrect
data".
6. After a successful input the page of an input shall not be available, the user shall be
it is redirected on the page of the user.
7. The page of the user shall not be available if the input is not executed. The user shall
to be redirected on the page of an input.
8. In case of 3 unsuccessful attempts of an input in a row system shall be disabled for 5 minutes,
at the same time in attempt of an input the message shall be displayed: "Try once again through <N>
seconds".

Requirements to implementation:
1. This to store in the text file not to use the database.
2. By development it is desirable to use architecture of MVC.
3. Use of a framework on the performer's choice is allowed.

### Requirements

  * Your local machine: PHP 7.1 or higher.
  * Your application: use any version of Symfony 4.0.x.

### Initialization of the project

**security-bundle it was not used according to the task**

```console
$ cd project/
$ composer install
```

### Run project

1. Change to the project directory
2. Execute the php -S 127.0.0.1:8000 -t public command;
3. Browse to the http://localhost:8000/ URL.
   

### Default login

* username: test
* password: test
