/* create product images updates */
SELECT CONCAT('UPDATE products SET product_image = ''', CAST(image AS CHAR), ''' WHERE product_abx_id = ', CAST(productId AS CHAR),';') AS s
FROM `CubeCart_inventory`;

/* create category description updates */