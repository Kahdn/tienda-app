

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE productos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INTEGER DEFAULT 0,
    categoria VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE productos ADD COLUMN activo BOOLEAN DEFAULT true;

INSERT INTO productos (nombre, descripcion, precio, stock, categoria) VALUES
('Laptop Pro 15"',    'Laptop de alto rendimiento con procesador i9', 25999.99, 10, 'Computadoras'),
('Mouse Inalámbrico', 'Mouse ergonómico con conexión Bluetooth',         599.00, 50, 'Periféricos'),
('Teclado Mecánico',  'Teclado gaming con switches Cherry MX Red',      1299.00, 30, 'Periféricos'),
('Monitor 4K 27"',    'Monitor UHD con panel IPS y 144Hz',              8999.00, 15, 'Monitores'),
('Webcam HD 1080p',   'Cámara web con micrófono integrado',              799.00, 25, 'Accesorios'),
('SSD 1TB NVMe',      'Disco sólido M.2 PCIe Gen4 hasta 7000MB/s',     1899.00, 40, 'Almacenamiento');

