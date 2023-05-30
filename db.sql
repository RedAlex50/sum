CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  quantity VARCHAR(255) NOT NULL
);

CREATE TABLE dishes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE dish_products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dish_id INT NOT NULL,
  product_id INT NOT NULL,
  FOREIGN KEY (dish_id) REFERENCES dishes(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE menu (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE menu_dishes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  menu_id INT NOT NULL,
  dish_id INT NOT NULL,
  FOREIGN KEY (menu_id) REFERENCES menu(id),
  FOREIGN KEY (dish_id) REFERENCES dishes(id)
);

CREATE TABLE journal (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_date DATE NOT NULL
);

CREATE TABLE journal_dishes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  journal_id INT NOT NULL,
  dish_id INT NOT NULL,
  FOREIGN KEY (journal_id) REFERENCES journal(id),
  FOREIGN KEY (dish_id) REFERENCES dishes(id)
);