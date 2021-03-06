<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Часть №1

Создайте веб страницу, которая будет выводить иерархию сотрудников в древовидной форме.
<ultype="disc">
<li> Информация о каждом сотруднике должна храниться в базе данных и содержать следующие данные:
<ul type="circle">
<li>ФИО;</li>
<li>Должность;</li>
<li>Дата приема на работу;</li>
<li>Размер заработной платы;</li>
</ul></li>    
<li>У каждого сотрудника есть 1 начальник;</li>
<li>База данных должна содержать не менее 50 000 сотрудников и 5 уровней иерархий.</li>
<li>Не забудьте отобразить должность сотрудника.</li>
</ul>    

## Часть №2 (опциональная)

1. Создайте базу данных используя миграции Laravel.
2. Используйте Laravel seeder для заполнения базы данных.
3. Используйте Twitter Bootstrap для создания базовых стилей Вашей страницы.
4. Создайте еще одну страницу и выведите на ней список сотрудников со всей имеющейся о сотруднике информацией из базы данных и возможностью сортировать по любому полю.
5. Добавьте возможность поиска сотрудников по любому полю для страницы созданной в задаче 4.
6. Добавьте возможность сортировать (и искать если Вы выполнили задачу №5) по любому полю без перезагрузки страницы, например используя ajax.
7. Используя стандартные функции Laravel, осуществите аутентификацию пользователя для раздела веб сайта доступного только для зарегистрированных пользователей.
8. Перенесите функционал разработанный в задачах 4, 5 и 6 (используя ajax запросы) в раздел доступный только для зарегистрированных пользователей.
9. В разделе доступном только для зарегистрированных пользователей, реализуйте остальные CRUD операции для записей сотрудников. Пожалуйста заметьте, что все поля касающиеся пользователей должны быть редактируемыми, включая начальника каждого сотрудника.
10. Осуществите возможность загружать фотографию сотрудника и отобразите ее на странице, где можно редактировать данные о сотрудник. Добавьте дополнительную колонку с уменьшенной фотографией сотрудника на странице списка всех сотрудников.
11. Осуществите возможность перераспределения сотрудников в случае изменения начальника (бонусом может быть то, что вы сможете это осуществить с применением встроенных механизмов/парадигм, предлагаемых Laravel ORM).
12. Реализуйте ленивую загрузку для дерева сотрудников. Например, показывайте мпервые два уровня иерархии по умолчанию и подгружайте 2 следующих уровня или всю ветку дерева при клике на сотрудника второго уровня.
13. Реализуйте возможность менять начальника сотрудника используя drag-n-drop сразу в дереве сотрудников.
14. Создайте структуру базы данных используя MySQL Workbench (не забудьте закомитить проект MySQL Workbench в git) и сгенерируйте файл(ы) миграций с помощью Laravel из существующей БД MySQL, или прямо из файла проекта MySQL Workbench.
