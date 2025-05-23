create table if not exists category(
   id int primary key auto_increment,
   name varchar(255) not null unique,
   description text
);
create table if not exists user(
   id int primary key auto_increment,
   username varchar(255) not null unique,
   password varchar(255) not null,
   email varchar(255) not null unique,
   created date default (current_date)
);
create table if not exists post(
   id int primary key auto_increment,
   title varchar(255) not null unique,
   short_content text,
   full_content text,
   author varchar(255) not null,
   category varchar(255) not null,
   image varchar(255),
   created date default (current_date),
   foreign key (category) references category(name) on delete cascade on update cascade,
   foreign key (author) references user(username) on delete cascade on update cascade
);
alter table post add column updated date default (current_date);
alter table user add column role varchar(10) default 'user';
alter table user add column avatar varchar(255);
alter table post modify column created datetime default now() ;
alter table post modify column updated datetime default now();

ALTER TABLE post DROP INDEX title;
select * from user;
select * from post;
select * from category;
update user set role = 'admin' where username = 'tranhatan'
