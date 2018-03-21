CREATE TABLE product( 
    id INTEGER UNIQUE not null, 
    name varchar(20) UNIQUE not null,
    quantity int,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX unique_index ON product (id);
