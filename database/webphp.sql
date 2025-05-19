create table if not exists category(
   id int primary key auto_increment,
   name varchar(255) not null unique,
   description text
);
create table if not exists post(
   id int primary key auto_increment,
   title varchar(255) not null unique,
   short_content text,
   full_content text,
   author varchar(255) not null,
   category varchar(255) not null,
   image varchar(255),
   date date default current_date,
   foreign key (category) references category(name) on delete cascade on update cascade
);
