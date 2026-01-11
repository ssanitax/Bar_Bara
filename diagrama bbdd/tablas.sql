CREATE TABLE usuario (
  id INT NOT NULL,
  nombre_usuario VARCHAR(255),
  apellidos VARCHAR(255),
  correo VARCHAR(255),
  contrasena VARCHAR(255),
  PRIMARY KEY (id)
);

CREATE TABLE pedido (
  id INT NOT NULL,
  usuario_id INT,
  numero_mesa INT,
  fecha VARCHAR(255),
  hora VARCHAR(255),
  productos VARCHAR(255),
  cantidad_producto INT,
  total DECIMAL(10,2),
  pedir_cuenta VARCHAR(255),
  PRIMARY KEY (id),
  CONSTRAINT fk_pedido_1 FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

CREATE TABLE producto (
  id INT NOT NULL,
  nombre_producto VARCHAR(255),
  precio DECIMAL(4,2),
  descripcion VARCHAR(255),
  categoria VARCHAR(255),
  imagen VARCHAR(255),
  PRIMARY KEY (id)
);

CREATE TABLE contenido_pedido (
  id INT NOT NULL,
  pedido_id INT,
  cantidad INT,
  subtotal DECIMAL(10,2),
  producto_id INT,
  PRIMARY KEY (id),
  CONSTRAINT fk_contenido_pedido_1 FOREIGN KEY (pedido_id) REFERENCES pedido(id),
  CONSTRAINT fk_contenido_pedido_2 FOREIGN KEY (producto_id) REFERENCES producto(id)
);


--NUEVO

SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE usuario MODIFY COLUMN id INT AUTO_INCREMENT;

SET FOREIGN_KEY_CHECKS = 1;

---------

SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE pedido MODIFY COLUMN id INT AUTO_INCREMENT;

ALTER TABLE contenido_pedido MODIFY COLUMN id INT AUTO_INCREMENT;

SET FOREIGN_KEY_CHECKS = 1;