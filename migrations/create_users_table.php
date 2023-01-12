<?php

return [
    'ran' => 1,
    'query' => "CREATE TABLE users (
                  id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                  name varchar(191) DEFAULT NULL,
                  family varchar(191) DEFAULT NULL,
                  username varchar(191) NOT NULL,
                  password varchar(191) NOT NULL,
                  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                  PRIMARY KEY (id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
];