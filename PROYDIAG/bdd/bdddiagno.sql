create database if not exists basejason default character set UTF8;
use basejason;

create table if not exists category (
  category_id int not null auto_increment,
  ca_name varchar(100) not null,
  PRIMARY KEY(category_id)
)ENGINE=InnoDB default charset=UTF8 auto_increment=1;

create table if not exists currency (
  currency_id int not null auto_increment,
  shortname char(3) not null,
  longname varchar(100) not null,
  PRIMARY KEY(currency_id)
)ENGINE=InnoDB default charset=UTF8 auto_increment=1;

create table if not exists country(
  country_id int not null auto_increment,
  coshortname char(4) not null,
  colongname varchar(100) not null,
  primary key(country_id)
)ENGINE=InnoDB default charset=UTF8 auto_increment=1;

create table if not exists item(
  id_item int not null auto_increment,
  title_item varchar(100),
  category_id int not null,
  price real not null,
  symbol char(1) not null,
  currency_id int not null,
  country_id int not null,
  created_at timestamp not null,
  modified_at timestamp,
  primary key(id_item),
  foreign key(category_id) references category(category_id),
  foreign key(currency_id) references currency(currency_id),
  foreign key(country_id) references country(country_id)
)ENGINE=InnoDB default charset=UTF8 auto_increment=1;

insert into category values(1,"Categoría 1");
insert into category values(2,"Categoría 2");
insert into category values(3,"Categoría 3");
insert into category values(1234,"Categoría 1234");

insert into currency values(1,"CL","Pesos chilenos");
insert into currency values(2,"YN","Yen japonés");
insert into currency values(3,"US","Dólar ucraniano");

insert into country values(1,"CHL","Chile");
insert into country values(2,"JPN","Japón");
insert into country values(3,"UKR","Ucrania");

insert into item values(1,"Item 1",1,10000,"F",1,1,'2020-01-01 01:30:00','2021-03-09 09:05:45');
insert into item values(2,"Item 2",2,15000,"7",2,2,'2020-02-02 02:30:00','2021-10-11 22:55:30');
insert into item values(3,"Item 3",3,20000,"?",3,3,'2020-03-03 03:30:00','2021-08-04 17:30:00');