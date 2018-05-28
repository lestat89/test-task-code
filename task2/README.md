Test task 2
============


Russian description
-------------

Товары на сайт интернет-магазина сгруппированы по категориям. Категории организованы в
древовидную структуру с уровнем вложенности до 4 включительно. Значимые атрибуты категории:
название. Значимые атрибуты товара: название и цена. Один продукт может относиться к нескольким
категориям.

1. Разработать структуру базы данных MySQL для хранения дерева категорий, списка продуктов и
информации о принадлежности продуктов к категориям.
2. Заполнить таблицы тестовыми данными.
3. Написать SQL-запросы для получения следующих данных:
   1. Для заданного списка товаров получить названия всех категорий, в которых
представлены товары;
   2. Для заданной категории получить список предложений всех товаров из этой категории и
ее дочерних категорий;
   3. Для заданного списка категорий получить количество предложений товаров в каждой
категории;
   4. Для заданного списка категорий получить общее количество уникальных предложений
товара;
   5. Для заданной категории получить ее полный путь в дереве (breadcrumb, «хлебные
крошки»).
4. Проверить и обосновать оптимальность запросов.

Предоставить дамп базы и sql-файл с заданиями согласно задаче и текстами запросов решений.

English description
-------------

Goods on the website of an e-commerce shop are grouped in categories. Categories are organized in
tree structure with the nesting level to 4 inclusively. Significant attributes of category:
name. Significant attributes of goods: name and price. One product can concern several
to categories.

1. To develop MySQL database structure for storage of a tree of categories, the list of products and
information on belonging of products to categories.
2. To fill out tables with test data.
3. To write SQL queries for obtaining the following data:
   1. For the given list of goods to receive names of all categories in which
goods are provided;
   2. For the given category to receive the list of sentences of all goods from this category and
its child categories;
   3. For the given list of categories to receive quantity of sentences of goods in everyone
categories;
   4. For the given list of categories to receive a total quantity of unique sentences
goods;
   5. For the given category to receive its full path in a tree (breadcrumb, "grain
crumbs").
4. To check and justify optimality of requests.

To provide a dumping of a basis and the sql-file with jobs according to the task and texts of requests of decisions.

### Requirements

  * Directory dump/ - schema and data
  * File select.sql - requests to a database
