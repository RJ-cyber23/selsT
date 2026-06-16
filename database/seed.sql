PRAGMA foreign_keys = OFF;

DELETE FROM Sales;
DELETE FROM Products;
DELETE FROM Customers;
DELETE FROM Suppliers;
DELETE FROM Unit_of_Measure;
DELETE FROM Categories;
DELETE FROM Brands;
DELETE FROM Users;

DELETE FROM sqlite_sequence;

-- Brands (10)
INSERT INTO Brands (brand_name, user_id) VALUES ('Nike', 1);
INSERT INTO Brands (brand_name, user_id) VALUES ('Adidas', 1);
INSERT INTO Brands (brand_name, user_id) VALUES ('Puma', 1);
INSERT INTO Brands (brand_name, user_id) VALUES ('Under Armour', 1);
INSERT INTO Brands (brand_name, user_id) VALUES ('Reebok', 1);
INSERT INTO Brands (brand_name, user_id) VALUES ('New Balance', 1);
INSERT INTO Brands (brand_name, user_id) VALUES ('Converse', 1);
INSERT INTO Brands (brand_name, user_id) VALUES ('Vans', 1);
INSERT INTO Brands (brand_name, user_id) VALUES ('Levi''s');
INSERT INTO Brands (brand_name, user_id) VALUES ('The North Face', 1);

-- Categories (10)
INSERT INTO Categories (category_name, user_id) VALUES ('T-Shirts', 1);
INSERT INTO Categories (category_name, user_id) VALUES ('Pants', 1);
INSERT INTO Categories (category_name, user_id) VALUES ('Shoes', 1);
INSERT INTO Categories (category_name, user_id) VALUES ('Accessories', 1);
INSERT INTO Categories (category_name, user_id) VALUES ('Jackets', 1);
INSERT INTO Categories (category_name, user_id) VALUES ('Shorts', 1);
INSERT INTO Categories (category_name, user_id) VALUES ('Hats', 1);
INSERT INTO Categories (category_name, user_id) VALUES ('Bags', 1);
INSERT INTO Categories (category_name, user_id) VALUES ('Socks', 1);
INSERT INTO Categories (category_name, user_id) VALUES ('Undergarments', 1);

-- Unit of Measure (7)
INSERT INTO Unit_of_Measure (uom_name, user_id) VALUES ('Piece', 1);
INSERT INTO Unit_of_Measure (uom_name, user_id) VALUES ('Pair', 1);
INSERT INTO Unit_of_Measure (uom_name, user_id) VALUES ('Set', 1);
INSERT INTO Unit_of_Measure (uom_name, user_id) VALUES ('Pack', 1);
INSERT INTO Unit_of_Measure (uom_name, user_id) VALUES ('Box', 1);
INSERT INTO Unit_of_Measure (uom_name, user_id) VALUES ('Dozen', 1);
INSERT INTO Unit_of_Measure (uom_name, user_id) VALUES ('Kilogram', 1);

-- Suppliers (10)
INSERT INTO Suppliers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Carlos', 'Garcia', '1985-03-15', '09171234567', 'carlos.garcia@gmail.com', 'Manila City', 1);
INSERT INTO Suppliers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Maria', 'Santos', '1990-07-22', '09181234567', 'maria.santos@gmail.com', 'Quezon City', 1);
INSERT INTO Suppliers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Juan', 'Dela Cruz', '1982-11-08', '09191234567', 'juan.delacruz@gmail.com', 'Makati City', 1);
INSERT INTO Suppliers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Ana', 'Reyes', '1995-01-30', '09201234567', 'ana.reyes@gmail.com', 'Taguig City', 1);
INSERT INTO Suppliers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Pedro', 'Santos', '1988-06-14', '09211234567', 'pedro.santos@gmail.com', 'Pasig City', 1);
INSERT INTO Suppliers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Sofia', 'Gonzales', '1992-09-25', '09221234567', 'sofia.gonzales@gmail.com', 'Mandaluyong City', 1);
INSERT INTO Suppliers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Miguel', 'Fernandez', '1980-04-18', '09231234567', 'miguel.fernandez@gmail.com', 'Cebu City', 1);
INSERT INTO Suppliers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Lisa', 'Tan', '1993-12-05', '09241234567', 'lisa.tan@gmail.com', 'Davao City', 1);
INSERT INTO Suppliers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Jose', 'Ramirez', '1987-08-20', '09251234567', 'jose.ramirez@gmail.com', 'BGC Taguig', 1);
INSERT INTO Suppliers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Elena', 'Cruz', '1991-02-14', '09261234567', 'elena.cruz@gmail.com', 'Paranaque City', 1);

-- Customers (15)
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('John', 'Smith', '1990-05-15', '09151112221', 'john.smith@gmail.com', 'Manila City', 1, 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Emily', 'Johnson', '1992-08-22', '09151112222', 'emily.johnson@gmail.com', 'Quezon City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Michael', 'Williams', '1988-03-10', '09151112223', 'michael.williams@gmail.com', 'Makati City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Sarah', 'Brown', '1995-11-30', '09151112224', 'sarah.brown@gmail.com', 'Taguig City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('David', 'Jones', '1991-07-04', '09151112225', 'david.jones@gmail.com', 'Pasig City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Jessica', 'Garcia', '1993-12-18', '09151112226', 'jessica.garcia@gmail.com', 'Mandaluyong City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('James', 'Martinez', '1989-09-25', '09151112227', 'james.martinez@gmail.com', 'Cebu City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Ashley', 'Davis', '1994-04-14', '09151112228', 'ashley.davis@gmail.com', 'Davao City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Robert', 'Rodriguez', '1987-06-08', '09151112229', 'robert.rodriguez@gmail.com', 'BGC Taguig', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Amanda', 'Wilson', '1996-01-20', '09151112230', 'amanda.wilson@gmail.com', 'Paranaque City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Daniel', 'Taylor', '1990-10-05', '09151112231', 'daniel.taylor@gmail.com', 'Manila City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Stephanie', 'Anderson', '1992-03-12', '09151112232', 'stephanie.anderson@gmail.com', 'Quezon City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Joseph', 'Thomas', '1985-08-28', '09151112233', 'joseph.thomas@gmail.com', 'Makati City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Nicole', 'Jackson', '1994-11-15', '09151112234', 'nicole.jackson@gmail.com', 'Taguig City', 1);
INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id) VALUES ('Christopher', 'White', '1988-07-19', '09151112235', 'christopher.white@gmail.com', 'Pasig City', 1);

-- Products (30)
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Nike Air Max', 3, 'M', 50, 2, 0.80, 1, 1, 500.00, 4500.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Adidas Ultraboost', 3, 'L', 35, 2, 0.75, 2, 2, 600.00, 5500.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Puma Classic Tee', 1, 'XL', 80, 1, 0.20, 3, 3, 150.00, 800.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Under Armour Cap', 7, 'M', 60, 1, 0.10, 4, 4, 100.00, 500.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Reebok Gym Bag', 8, 'M', 25, 1, 1.20, 5, 5, 300.00, 2000.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('New Balance Shorts', 6, 'L', 45, 1, 0.25, 6, 6, 120.00, 900.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Converse Crew Socks', 9, 'M', 100, 4, 0.05, 7, 7, 50.00, 200.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Vans Slip-On', 3, 'S', 30, 2, 0.70, 8, 8, 400.00, 3200.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Levi''s Denim Jacket', 5, 'XL', 20, 1, 1.50, 9, 9, 800.00, 4500.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('North Face Backpack', 8, 'M', 40, 1, 0.90, 10, 10, 350.00, 2500.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Nike Dri-FIT Tee', 1, 'L', 70, 1, 0.18, 1, 1, 180.00, 1000.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Adidas Track Pants', 2, 'M', 55, 1, 0.50, 2, 2, 250.00, 1800.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Puma Hoodie', 5, 'L', 30, 1, 0.80, 3, 3, 400.00, 2800.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Under Armour Leggings', 2, 'S', 40, 1, 0.30, 4, 4, 200.00, 1500.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Reebok Training Shoes', 3, 'M', 28, 2, 0.85, 5, 5, 550.00, 4800.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('New Balance Capri', 2, 'M', 35, 1, 0.35, 6, 6, 180.00, 1200.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Converse High Top', 3, 'L', 22, 2, 0.90, 7, 7, 450.00, 3800.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Vans Skate Tee', 1, 'XL', 65, 1, 0.20, 8, 8, 130.00, 750.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Levi''s Cargo Pants', 2, 'L', 38, 1, 0.60, 9, 9, 300.00, 2200.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('North Face Windbreaker', 5, 'M', 18, 1, 0.55, 10, 10, 700.00, 3500.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Nike Running Shorts', 6, 'M', 48, 1, 0.22, 1, 1, 140.00, 850.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Adidas Snapback Cap', 7, 'M', 55, 1, 0.12, 2, 2, 110.00, 600.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Puma Socks 3-Pack', 9, 'M', 90, 4, 0.15, 3, 3, 70.00, 350.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Under Armour Sports Bra', 10, 'S', 42, 1, 0.15, 4, 4, 220.00, 1300.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Reebok Duffel Bag', 8, 'L', 15, 1, 1.10, 5, 5, 320.00, 2200.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('New Balance 574 Classic', 3, 'M', 32, 2, 0.78, 6, 6, 480.00, 4200.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Converse All Star Tee', 1, 'S', 75, 1, 0.18, 7, 7, 140.00, 700.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Vans Skateboard Deck', 4, 'M', 12, 1, 2.50, 8, 8, 900.00, 3500.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('Levi''s Belt', 4, 'M', 60, 1, 0.25, 9, 9, 150.00, 800.00, 1);
INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id) VALUES ('North Face Beanie', 7, 'M', 70, 1, 0.08, 10, 10, 90.00, 450.00, 1);

-- Sales (30)
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (1, 3, 2, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (2, 5, 1, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (3, 1, 3, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (4, 7, 2, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (5, 2, 1, 'cancelled', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (6, 9, 4, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (7, 4, 5, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (8, 6, 1, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (9, 8, 1, 'cancelled', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (10, 10, 2, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (11, 11, 2, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (12, 12, 3, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (13, 13, 1, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (14, 14, 2, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (15, 15, 1, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (16, 1, 3, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (17, 2, 1, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (18, 3, 2, 'cancelled', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (19, 4, 4, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (20, 5, 1, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (21, 6, 2, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (22, 7, 3, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (23, 8, 6, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (24, 9, 2, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (25, 10, 1, 'cancelled', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (26, 11, 2, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (27, 12, 3, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (28, 13, 1, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (29, 14, 2, 'completed', 1);
INSERT INTO Sales (product_id, customer_id, quantity, status, user_id) VALUES (30, 15, 1, 'completed', 1);

-- Users (3)
INSERT INTO Users (first_name, last_name, bod, phone_number, Gmail, location_address, username, password) VALUES ('Admin', 'User', '1990-01-01', '09170000001', 'admin@gmail.com', 'Manila City', 'admin', '$2y$12$8iHAvnyQ8dPVEUF3BO98keUrMs.jzkvinLnD.stRwI3sESNHRtdAO');
INSERT INTO Users (first_name, last_name, bod, phone_number, Gmail, location_address, username, password) VALUES ('John', 'Doe', '1992-06-15', '09170000002', 'john.doe@gmail.com', 'Quezon City', 'johndoe', '$2y$12$8iHAvnyQ8dPVEUF3BO98keUrMs.jzkvinLnD.stRwI3sESNHRtdAO');
INSERT INTO Users (first_name, last_name, bod, phone_number, Gmail, location_address, username, password) VALUES ('Jane', 'Smith', '1995-09-20', '09170000003', 'jane.smith@gmail.com', 'Makati City', 'janesmith', '$2y$12$8iHAvnyQ8dPVEUF3BO98keUrMs.jzkvinLnD.stRwI3sESNHRtdAO');

PRAGMA foreign_keys = ON;
