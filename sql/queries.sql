SELECT * FROM products
WHERE product_id = 6856;

SELECT * FROM viewProducts
WHERE product_id = 6856
ORDER BY product_category_category_id DESC;

SELECT product_category_product_id, count(*) as cnt
FROM product_category
GROUP BY product_category_product_id
ORDER BY cnt DESC;

SELECT product_variant_product_id, product_name, count(*) as cnt
FROM product_variants pv
JOIN products p ON (p.product_id = pv.product_variant_product_id)
GROUP BY product_variant_product_id
ORDER BY cnt DESC;

SELECT * FROM viewProductsInCategories
WHERE product_category_product_id = 7170;

select * from cart;

select * from customers;

select * from customer_sessions;

delete from customer_sessions where customer_session_id > 0;
delete from cart where cart_id > 0;
delete from customers where customer_id > 0;
