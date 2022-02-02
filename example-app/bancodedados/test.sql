
/*comando para buscar dados:*/
SELECT * FROM persons_laravel WHERE name LIKE value% or pet LIKE value% or age LIKE value%;

/*comando para apagar dados:*/
DELETE FROM persons_laravel WHERE id = value;

/*id se autoincrementa
comando para inserir dados:*/
INSERT INTO persons_laravel(name,age,pet) VALUES(value,value,value);

/*comando para atualizar dados:*/

UPDATE persons_laravel SET name = value , age =  value , pet = value WHERE id = value;
/*


*OBSERVAÇÃO AS TABELAS FORAM CRIADAS AUTOMATICAMENTES

*PELO php artisan make:migration
criação das tabelas
*/

CREATE DATABASE laravel;
USE laravel;
CREATE TABLE persons_laravel(
    id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    pet int(10) NOT NULL
);

CREATE TABLE login_models(
    id int(11) PRIMARY KEY AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    password varchar(255) NOT NULL
);


