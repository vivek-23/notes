delimiter //
create trigger update_products
before delete on category for each row
begin
	update products set cat_id = 0 where cat_id = OLD.id;
end//
delimiter ;


-- In the above code, category ID of the products get updated before the category deletion from category table
