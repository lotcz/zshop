SELECT * FROM products
WHERE product_id = 6856;

SELECT * FROM viewProducts
WHERE product_id = 6856
ORDER BY product_category_category_id DESC;

SELECT product_category_product_id, count(*) as cnt
FROM product_category
GROUP BY product_category_product_id
ORDER BY cnt DESC;

SELECT product_category_product_id, count(*) as cnt
FROM product_category
GROUP BY product_category_product_id
ORDER BY cnt DESC;

select * from cart;

select * from aliases;

DELETE FROM aliases WHERE alias_id = 3