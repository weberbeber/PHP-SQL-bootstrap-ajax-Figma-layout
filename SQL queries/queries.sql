/* 1) Составьте список пользователей users, которые осуществили хотя бы один заказ orders в интернет магазине. */
use shop;

SELECT DISTINCT name
FROM orders JOIN users
ON orders.user_id = users.id;

/* 2) Выведите список товаров products и разделов catalogs, который соответствует товару. */
USE shop; 
 
SELECT products.name, catalogs.name 
FROM products JOIN catalogs
ON products.catalog_id = catalogs.id
WHERE products.catalog_id = catalogs.id;

/* 3) В базе данных shop и sample присутствуют одни и те же таблицы.
  * Переместите запись id = 1 из таблицы shop.users в таблицу sample.users. Используйте транзакции. */
use sample;

START TRANSACTION;
INSERT INTO sample.users (name, birthday_at, created_at, updated_at)
SELECT name, birthday_at, created_at, updated_at
FROM shop.users
WHERE id = 1;

DELETE FROM shop.users
WHERE id = 1;
COMMIT;

/* 4) Выведите одного случайного пользователя из таблицы shop.users, старше 30 лет, сделавшего минимум 3 заказа за последние полгода */
USE shop;

SELECT name
FROM (
SELECT name, count(name) 
FROM orders JOIN users
ON orders.user_id = users.id
where (birthday_at < date_sub(CURDATE(), INTERVAL 30 YEAR))
AND 
(orders.created_at >= date_sub(CURDATE(), INTERVAL 6 MONTH))
GROUP BY name
HAVING count(name) >= 3
) AS order_users
ORDER BY RAND()
LIMIT 1;