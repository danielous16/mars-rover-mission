create table IF not exists `vehicles` (
    id           varchar(36) not null,
    type         tinyint     not null,
    coordinate_x tinyint     not null,
    coordinate_y tinyint     not null,
    orientation  varchar(1)  not null,
    created_at   datetime    not null,
    updated_at   datetime    not null,
    constraint vehicles_id_uindex
    PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;