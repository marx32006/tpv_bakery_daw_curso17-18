create database bakery default character set utf8 collate utf8_unicode_ci;
#utf8_general_ci

create user admin@localhost identified by '1234';

grant all on bakery.* to admin@localhost;

flush privileges;

use bakery;

create table if not exists member (
    id bigint(20) not null auto_increment primary key,
    login varchar(40) not null unique,
    password varchar(250) not null,
) engine = innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists ticket (
    id bigint not null auto_increment primary key,
    date timestamp default current_timestamp on update current_timestamp not null,
    idmember bigint(20) not null,
    idclient bigint(20),
    foreign key (idmember) references member(id) on delete restrict,
    foreign key (idclient) references cliente(id) on delete restrict
) engine = innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists ticketdetail (
    id bigint(20) not null auto_increment primary key,
    idticket bigint(20) not null,
    idproduct bigint(20) not null,
    quantity tinyint(4) not null,
    price decimal(10,2) not null,
    unique(idticket, idproduct),
    foreign key (idticket) references ticket(id) on delete restrict,
    foreign key (idproduct) references producto(id) on delete restrict
) engine = innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists producto (
    id bigint(20) not null auto_increment primary key,
    idfamily bigint(20) not null,
    product varchar(100) not null,
    price decimal(10,2) not null,
    descripcion text,
    unique(idfamily, product),
    foreign key (idfamily) references family(id) on delete restrict
) engine = innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists family (
    id bigint(20) not null auto_increment primary key,
    family varchar(100) not null unique
) engine = innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists cliente (
    id bigint(20) not null auto_increment primary key,
    name varchar(40) not null,
    sumame varchar(60) not null,
    tin varchar(20) not null,
    address VARCHAR(100) not null,
    location VARCHAR(100),
    postalcode VARCHAR(5),
    province VARCHAR(30),
    email VARCHAR(100),
    unique(name, sumame, tin)
) engine = innodb default character set = utf8 collate utf8_unicode_ci;