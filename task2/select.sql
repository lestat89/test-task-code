# 1. Для заданного списка товаров получить названия всех категорий, в которых представлены товары;
# 1. For the given list of goods to receive names of all categories in which goods are provided;
select
  pc.productID,
  c.name
from categories as c
  join product_categories as pc on pc.categoryID = c.ID
where pc.productID in (1, 2, 3)


# 2. Для заданной категории получить список предложений всех товаров из этой категории и ее дочерних категорий;
# 2. For the given category to receive the list of sentences of all goods from this category and its child categories;

select p.name
from categories as c
  join category_child as cc on c.ID = cc.categoryID
  join product_categories as pc on pc.categoryID = c.ID or pc.categoryID = cc.childID
  join products as p on p.ID = pc.productID
where c.ID in (1, 171, 86, 256)
group by p.ID

# 3. Для заданного списка категорий получить количество предложений товаров в каждой категории;
# 3. For the given list of categories to receive quantity of sentences of goods in everyone categories;

select
  cc.childID,
  count(distinct pc.productID)
from categories as c
  join category_child as cc on cc.categoryID = c.ID
  join product_categories as pc on pc.categoryID = c.ID or pc.categoryID = cc.childID
where c.ID in (1, 171, 86, 256, 130)
group by cc.childID

# 4. Для заданного списка категорий получить общее количество уникальных предложений товара;
# 4. For the given list of categories to receive a total quantity of unique sentences goods;

select
  c.name,
  count(distinct pc.productID)
from categories as c
  join category_child as cc on cc.categoryID = c.ID
  join product_categories as pc on pc.categoryID = c.ID or pc.categoryID = cc.childID
where c.ID in (1, 171, 86, 256, 130)
group by c.ID

# 5. Для заданной категории получить ее полный путь в дереве (breadcrumb, «хлебные крошки»).
# 5. For the given category to receive its full path in a tree (breadcrumb, "grain crumbs").

select
  concat_ws(' > ', group_concat(ccc.name separator ' > '), c.name),
  c.ID
from categories as c
  join category_child as cc on cc.childID = c.ID
  join categories as ccc on ccc.ID = cc.categoryID
where c.ID in (1, 17, 232, 129)
group by c.ID
