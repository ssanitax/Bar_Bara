-- Creamos un usuario dueño para la base de datos del bar
CREATE USER 'admin_bara'@'localhost' IDENTIFIED BY 'BarBara_2025';

-- Le damos todos los permisos solo sobre tu base de datos
GRANT ALL PRIVILEGES ON Bar_Bara.* TO 'admin_bara'@'localhost';

-- Refrescamos los cambios
FLUSH PRIVILEGES;
