create table if not exists users
(

    id         int          not null primary key auto_increment,
    name       varchar(255) not null,
    email      varchar(255) not null unique,
    password   varchar(100) not null,
    drink      int          not null default 0,
    role       varchar(10)  not null default 'user',
    created_at timestamp    not null default current_timestamp,
    updated_at timestamp    not null default current_timestamp on update current_timestamp

);

create table if not exists users_token
(
    id         int          not null primary key auto_increment,
    user_id    int          not null,
    token      varchar(255) not null,
    user_agent varchar(255) not null,
    ip         varchar(255) not null,
    expired_at timestamp    not null,
    created_at timestamp    not null default current_timestamp,
    updated_at timestamp    not null default current_timestamp on update current_timestamp,
    foreign key (user_id) references users (id)

);

create table if not exists users_drink
(
    id         int       not null primary key auto_increment,
    user_id    int       not null,
    drink      int       not null,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp,
    foreign key (user_id) references users (id)

);
