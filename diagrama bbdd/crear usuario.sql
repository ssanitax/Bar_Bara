--aqui pegáis las tablas

CREATE USER 
'admin_bara'@'localhost' 
IDENTIFIED  BY 'BarBara_2025$';

GRANT USAGE ON *.* TO 'admin_bara'@'localhost';

ALTER USER 'admin_bara'@'localhost' 
REQUIRE NONE 
WITH MAX_QUERIES_PER_HOUR 0 
MAX_CONNECTIONS_PER_HOUR 0 
MAX_UPDATES_PER_HOUR 0 
MAX_USER_CONNECTIONS 0;

GRANT ALL PRIVILEGES ON Bar_Bara.* 
TO 'admin_bara'@'localhost';

FLUSH PRIVILEGES;