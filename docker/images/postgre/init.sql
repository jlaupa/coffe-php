CREATE TABLE orders(
   id SERIAL PRIMARY KEY,
   drink_type VARCHAR(20) NOT NULL,
   sugars INT NOT NULL,
   stick INT NOT NULL,
   extra_hot INT NOT NULL
);v