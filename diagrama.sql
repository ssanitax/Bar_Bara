CREATE TABLE usuario (
  id INT,
  nombre_usuario VARCHAR(255),
  apellidos VARCHAR(255),
  correo VARCHAR(255),
  contrasea VARCHAR(255),
  PRIMARY KEY (id)
);

CREATE TABLE pedido (
  id INT,
  usuario_id INT,
  numero_mesa VARCHAR(255),
  fecha VARCHAR(255),
  hora VARCHAR(255),
  productos VARCHAR(255),
  cantidad_producto VARCHAR(255),
  total VARCHAR(255),
  pedir_cuenta VARCHAR(255),
  PRIMARY KEY (id),
  CONSTRAINT fk_pedido_1 FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

CREATE TABLE producto (
  id INT,
  nombre_producto VARCHAR(255),
  precio VARCHAR(255),
  descripcion VARCHAR(255),
  categoria VARCHAR(255),
  imagen VARCHAR(255),
  PRIMARY KEY (id)
);

CREATE TABLE contenido_pedido (
  id INT,
  pedido_id INT,
  cantidad VARCHAR(255),
  subtotal VARCHAR(255),
  producto_id INT,
  PRIMARY KEY (id),
  CONSTRAINT fk_contenido_pedido_1 FOREIGN KEY (pedido_id) REFERENCES pedido(id),
  CONSTRAINT fk_contenido_pedido_2 FOREIGN KEY (producto_id) REFERENCES producto(id)
);
