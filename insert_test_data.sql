-- Insert countries with full details
INSERT IGNORE INTO `countries` (`code`, `name`, `capital`, `province`, `area`, `population`, `active`) VALUES
('ARG', 'Argentina', 'Buenos Aires', 'Buenos Aires', 2780400, 45195774, 1),
('BRA', 'Brasil', 'Brasilia', 'Distrito Federal', 8515770, 214300000, 1),
('CHL', 'Chile', 'Santiago', 'Santiago', 756102, 19458000, 1),
('URY', 'Uruguay', 'Montevideo', 'Montevideo', 176215, 3473730, 1),
('PRY', 'Paraguay', 'Asunción', 'Asunción', 406752, 7132538, 1),
('PER', 'Perú', 'Lima', 'Lima', 1285216, 32971846, 1),
('COL', 'Colombia', 'Bogotá', 'Cundinamarca', 1141748, 51520000, 1),
('ECU', 'Ecuador', 'Quito', 'Pichincha', 283561, 17800000, 1),
('BOL', 'Bolivia', 'La Paz', 'La Paz', 1098581, 11800000, 1),
('VEN', 'Venezuela', 'Caracas', 'Distrito Capital', 916445, 28200000, 1);

-- Insert provinces with detailed information
INSERT INTO `provinces` (`name`, `country_id`, `population`, `area`, `capital`, `capprovince`, `code`, `active`) VALUES
-- Argentina
('Buenos Aires', 1, 17541141, 307571, 'La Plata', 'Buenos Aires', 'BA', 1),
('Córdoba', 1, 3760450, 165321, 'Córdoba', 'Córdoba', 'CBA', 1),
('Santa Fe', 1, 3194537, 133007, 'Santa Fe', 'Rosario', 'SF', 1),
('Mendoza', 1, 1990338, 148827, 'Mendoza', 'Mendoza', 'MZA', 1),
-- Brasil
('São Paulo', 2, 46289333, 248222, 'São Paulo', 'São Paulo', 'SP', 1),
('Rio de Janeiro', 2, 17366189, 43696, 'Rio de Janeiro', 'Rio de Janeiro', 'RJ', 1),
('Minas Gerais', 2, 21411923, 586528, 'Belo Horizonte', 'Belo Horizonte', 'MG', 1),
('Rio Grande do Sul', 2, 11422973, 281748, 'Porto Alegre', 'Porto Alegre', 'RS', 1),
-- Chile
('Santiago', 3, 8125072, 15403, 'Santiago', 'Santiago', 'STG', 1),
('Valparaíso', 3, 1960170, 16396, 'Valparaíso', 'Valparaíso', 'VAL', 1),
('Concepción', 3, 2037414, 12145, 'Concepción', 'Concepción', 'CON', 1),
-- Uruguay - Complete list of all 19 departments
('Montevideo', 4, 1381228, 530, 'Montevideo', 'Montevideo', 'MVD', 1),
('Canelones', 4, 520187, 4536, 'Canelones', 'Canelones', 'CAN', 1),
('Maldonado', 4, 164300, 4793, 'Maldonado', 'Maldonado', 'MAL', 1),
('Artigas', 4, 73378, 11928, 'Artigas', 'Artigas', 'ART', 1),
('Cerro Largo', 4, 84698, 13648, 'Melo', 'Melo', 'CL', 1),
('Colonia', 4, 123203, 6106, 'Colonia del Sacramento', 'Colonia del Sacramento', 'COL', 1),
('Durazno', 4, 57088, 11643, 'Durazno', 'Durazno', 'DUR', 1),
('Flores', 4, 25050, 5144, 'Trinidad', 'Trinidad', 'FLO', 1),
('Florida', 4, 67048, 10417, 'Florida', 'Florida', 'FLA', 1),
('Lavalleja', 4, 58815, 10016, 'Minas', 'Minas', 'LAV', 1),
('Paysandú', 4, 113124, 13922, 'Paysandú', 'Paysandú', 'PAY', 1),
('Río Negro', 4, 54765, 9282, 'Fray Bentos', 'Fray Bentos', 'RN', 1),
('Rivera', 4, 103493, 9370, 'Rivera', 'Rivera', 'RIV', 1),
('Rocha', 4, 68088, 10551, 'Rocha', 'Rocha', 'ROC', 1),
('Salto', 4, 124878, 14163, 'Salto', 'Salto', 'SAL', 1),
('San José', 4, 108309, 4992, 'San José de Mayo', 'San José de Mayo', 'SJ', 1),
('Soriano', 4, 82595, 9008, 'Mercedes', 'Mercedes', 'SOR', 1),
('Tacuarembó', 4, 90053, 15438, 'Tacuarembó', 'Tacuarembó', 'TAC', 1),
('Treinta y Tres', 4, 48134, 9529, 'Treinta y Tres', 'Treinta y Tres', 'TT', 1),
-- Paraguay
('Asunción', 5, 520737, 117, 'Asunción', 'Asunción', 'ASU', 1),
('Central', 5, 1929834, 2465, 'Areguá', 'Areguá', 'CEN', 1),
('Alto Paraná', 5, 736092, 14895, 'Ciudad del Este', 'Ciudad del Este', 'ALT', 1),
-- Perú
('Lima', 6, 9485405, 34802, 'Lima', 'Lima', 'LIM', 1),
('Arequipa', 6, 1382730, 63345, 'Arequipa', 'Arequipa', 'ARE', 1),
('Cusco', 6, 1205527, 71987, 'Cusco', 'Cusco', 'CUS', 1),
-- Colombia
('Cundinamarca', 7, 2792877, 24210, 'Bogotá', 'Bogotá', 'CUN', 1),
('Antioquia', 7, 6407102, 63612, 'Medellín', 'Medellín', 'ANT', 1),
('Valle del Cauca', 7, 4475886, 22140, 'Cali', 'Cali', 'VDC', 1),
-- Ecuador
('Pichincha', 8, 2576287, 9612, 'Quito', 'Quito', 'PIC', 1),
('Guayas', 8, 3645483, 16741, 'Guayaquil', 'Guayaquil', 'GUA', 1),
('Azuay', 8, 712127, 8639, 'Cuenca', 'Cuenca', 'AZU', 1),
-- Bolivia
('La Paz', 9, 2756989, 133985, 'La Paz', 'La Paz', 'LPZ', 1),
('Santa Cruz', 9, 3224662, 370621, 'Santa Cruz de la Sierra', 'Santa Cruz de la Sierra', 'SCZ', 1),
('Cochabamba', 9, 1758143, 55631, 'Cochabamba', 'Cochabamba', 'CBB', 1),
-- Venezuela
('Distrito Capital', 10, 1943901, 433, 'Caracas', 'Caracas', 'DC', 1),
('Miranda', 10, 3194390, 7950, 'Los Teques', 'Los Teques', 'MIR', 1),
('Zulia', 10, 3704404, 63100, 'Maracaibo', 'Maracaibo', 'ZUL', 1);

-- Insert destinations with expanded coverage
INSERT INTO `destinations` (`name`, `province_id`, `postal_code`, `active`) VALUES
-- Buenos Aires destinations
('Buenos Aires Centro', 1, '1000', 1),
('Buenos Aires Norte', 1, '1001', 1),
('Buenos Aires Sur', 1, '1002', 1),
('La Plata Centro', 1, '1900', 1),
-- Córdoba destinations
('Córdoba Centro', 2, '5000', 1),
('Córdoba Norte', 2, '5001', 1),
('Villa Carlos Paz', 2, '5152', 1),
-- Santa Fe destinations
('Rosario Centro', 3, '2000', 1),
('Santa Fe Capital', 3, '3000', 1),
-- Mendoza destinations
('Mendoza Centro', 4, '5500', 1),
('Godoy Cruz', 4, '5501', 1),
-- São Paulo destinations
('São Paulo Centro', 5, '01000', 1),
('São Paulo Oeste', 5, '05000', 1),
('Guarulhos', 5, '07000', 1),
-- Rio de Janeiro destinations
('Rio Centro', 6, '20000', 1),
('Copacabana', 6, '22000', 1),
('Niterói', 6, '24000', 1),
-- Santiago destinations
('Santiago Centro', 9, '8320000', 1),
('Providencia', 9, '7500000', 1),
('Las Condes', 9, '7550000', 1),
-- Montevideo destinations
('Montevideo Centro', 12, '11000', 1),
('Pocitos', 12, '11300', 1),
('Carrasco', 12, '11500', 1);

-- Insert expanded test customers
INSERT INTO `customers` (
    `name`, `social_reason`, `fiscal_identifier`, `person_contact`,
    `email`, `password`, `telephone`, `country_id`, `province_id`, 
    `province_name_manual`, `destination_name_manual`, `destination_id`, `address`, `business_hours`, `type_user_id`, `active`
) VALUES
-- Argentina customers
('Empresa A', 'Empresa A S.A.', '30123456789', 'Juan Pérez',
 'contacto@empresaa.com', SHA1('password123'), '+54911111111', 1, 1,
 NULL, NULL, 1, 'Av. Corrientes 1234', 'Lun-Vie 9-18hs', 2, 1),

('Comercial BA', 'Comercial Buenos Aires SRL', '30987654321', 'Pedro Gomez',
 'ventas@comercialba.com', SHA1('password123'), '+54911222222', 1, 1,
 NULL, NULL, 2, 'Av. Santa Fe 4321', 'Lun-Vie 8-20hs, Sab 9-13hs', 2, 1),

('Distribuidora Córdoba', 'Distribuidora Córdoba SA', '30456789012', 'Ana Martinez',
 'ventas@distcordoba.com', SHA1('password123'), '+54351333333', 1, 2,
 NULL, NULL, 5, 'Av. Colón 1234', 'Lun-Vie 8:30-18hs', 3, 1),

-- Brasil customers
('Comercial B', 'Comercial B Ltda.', '15789456320', 'Maria Silva',
 'ventas@comercialb.com', SHA1('password123'), '+55922222222', 2, 5,
 NULL, NULL, 12, 'Rua Augusta 567', 'Lun-Sab 8-20hs', 2, 1),

('Importadora SP', 'Importadora São Paulo Ltda.', '14725836901', 'João Santos',
 'contato@importadorasp.com', SHA1('password123'), '+55911444444', 2, 5,
 NULL, NULL, 13, 'Av. Paulista 1000', 'Seg-Sex 9-18hs', 2, 1),

('Distribuidora Rio', 'Distribuidora Rio de Janeiro Ltda.', '12369874510', 'Roberto Oliveira',
 'vendas@distrio.com', SHA1('password123'), '+55921555555', 2, 6,
 NULL, NULL, 15, 'Av. Atlântica 500', 'Seg-Sab 8-19hs', 3, 1),

-- Chile customers
('Distribuidora C', 'Distribuidora C SpA', '76951357852', 'Carlos González',
 'pedidos@distribuidorac.com', SHA1('password123'), '+56933333333', 3, 9,
 NULL, NULL, 19, 'Av. Providencia 789', 'Lun-Vie 8:30-17:30hs', 3, 1),

('Comercial Santiago', 'Comercial Santiago SpA', '76147258369', 'Patricia Muñoz',
 'ventas@comercialsantiago.com', SHA1('password123'), '+56944444444', 3, 9,
 NULL, NULL, 20, 'Av. Las Condes 1234', 'Lun-Vie 9-18:30hs', 2, 1),

-- Uruguay customers
('Importadora D', 'Importadora D E.I.R.L', '20147258369', 'Ana Torres',
 'compras@importadorad.com', SHA1('password123'), '+59844444444', 4, 12,
 NULL, NULL, 21, 'Av. 18 de Julio 456', 'Lun-Vie 9-19hs, Sab 9-13hs', 2, 1),

('Distribuidora MVD', 'Distribuidora Montevideo S.A.', '21987654321', 'Diego Rodriguez',
 'ventas@distmvd.com', SHA1('password123'), '+59855555555', 4, 12,
 NULL, NULL, 22, 'Av. Brasil 789', 'Lun-Vie 9-18hs', 3, 1),

-- Customer with manual province
('Empresa Internacional', 'Empresa Internacional LLC', '12345678901', 'Maria Garcia',
 'contacto@empresaint.com', SHA1('password123'), '+1234567890', 4, NULL,
 'Región Especial', 'Localidad Manual', NULL, 'Calle Principal 123', 'Lun-Vie 8-17hs', 2, 1);

-- Insert tokens for each customer with both prod and dev tokens
INSERT INTO `token_customers` (`customer_id`, `token`, `token_dev`, `active`) VALUES
(1, CONCAT('tk_empresaa_', SHA2(CONCAT(RAND(), NOW()), 256)), 
    CONCAT('Dev-tk_empresaa_', SHA2(CONCAT(RAND(), NOW()), 256)), 1),
(2, CONCAT('tk_comercialba_', SHA2(CONCAT(RAND(), NOW()), 256)),
    CONCAT('Dev-tk_comercialba_', SHA2(CONCAT(RAND(), NOW()), 256)), 1),
(3, CONCAT('tk_distcordoba_', SHA2(CONCAT(RAND(), NOW()), 256)),
    CONCAT('Dev-tk_distcordoba_', SHA2(CONCAT(RAND(), NOW()), 256)), 1),
(4, CONCAT('tk_comercialb_', SHA2(CONCAT(RAND(), NOW()), 256)),
    CONCAT('Dev-tk_comercialb_', SHA2(CONCAT(RAND(), NOW()), 256)), 1),
(5, CONCAT('tk_importadorasp_', SHA2(CONCAT(RAND(), NOW()), 256)),
    CONCAT('Dev-tk_importadorasp_', SHA2(CONCAT(RAND(), NOW()), 256)), 1),
(6, CONCAT('tk_distrio_', SHA2(CONCAT(RAND(), NOW()), 256)),
    CONCAT('Dev-tk_distrio_', SHA2(CONCAT(RAND(), NOW()), 256)), 1),
(7, CONCAT('tk_distribuidorac_', SHA2(CONCAT(RAND(), NOW()), 256)),
    CONCAT('Dev-tk_distribuidorac_', SHA2(CONCAT(RAND(), NOW()), 256)), 1),
(8, CONCAT('tk_comercialsantiago_', SHA2(CONCAT(RAND(), NOW()), 256)),
    CONCAT('Dev-tk_comercialsantiago_', SHA2(CONCAT(RAND(), NOW()), 256)), 1),
(9, CONCAT('tk_importadorad_', SHA2(CONCAT(RAND(), NOW()), 256)),
    CONCAT('Dev-tk_importadorad_', SHA2(CONCAT(RAND(), NOW()), 256)), 1),
(10, CONCAT('tk_distmvd_', SHA2(CONCAT(RAND(), NOW()), 256)),
    CONCAT('Dev-tk_distmvd_', SHA2(CONCAT(RAND(), NOW()), 256)), 1);

-- Insert expanded shipping credentials
INSERT INTO `customer_shipping_credentials` (
    `customer_id`, `address`, `postal_code`, `city`, `province`,
    `country_code`, `province_code`, `street`, `active`
) VALUES
-- Argentina shipping credentials
(1, 'Av. Corrientes 1234', '1000', 'Buenos Aires', 'Buenos Aires',
 'ARG', 'BA', 'Av. Corrientes', 1),
(1, 'Av. Santa Fe 5678', '1001', 'Buenos Aires', 'Buenos Aires',
 'ARG', 'BA', 'Av. Santa Fe', 1),
(2, 'Av. Cabildo 2000', '1002', 'Buenos Aires', 'Buenos Aires',
 'ARG', 'BA', 'Av. Cabildo', 1),
(3, 'Av. Colón 1234', '5000', 'Córdoba', 'Córdoba',
 'ARG', 'CBA', 'Av. Colón', 1),
-- Brasil shipping credentials
(4, 'Rua Augusta 567', '01000', 'São Paulo', 'São Paulo',
 'BRA', 'SP', 'Rua Augusta', 1),
(4, 'Av. Paulista 890', '01310', 'São Paulo', 'São Paulo',
 'BRA', 'SP', 'Av. Paulista', 1),
(5, 'Av. Brigadeiro 1500', '01450', 'São Paulo', 'São Paulo',
 'BRA', 'SP', 'Av. Brigadeiro', 1),
(6, 'Av. Atlântica 500', '22010', 'Rio de Janeiro', 'Rio de Janeiro',
 'BRA', 'RJ', 'Av. Atlântica', 1),
-- Chile shipping credentials
(7, 'Av. Providencia 789', '7500000', 'Santiago', 'Santiago',
 'CHL', 'STG', 'Av. Providencia', 1),
(8, 'Av. Las Condes 1234', '7550000', 'Santiago', 'Santiago',
 'CHL', 'STG', 'Av. Las Condes', 1),
-- Uruguay shipping credentials
(9, 'Av. 18 de Julio 456', '11000', 'Montevideo', 'Montevideo',
 'URY', 'MVD', 'Av. 18 de Julio', 1),
(10, 'Av. Brasil 789', '11300', 'Montevideo', 'Montevideo',
 'URY', 'MVD', 'Av. Brasil', 1),
(10, 'Rambla República 1000', '11500', 'Montevideo', 'Montevideo',
 'URY', 'MVD', 'Rambla República', 1);

-- Insert order statuses
INSERT INTO `statuses` (`name`, `description`, `active`) VALUES
('Pendiente', 'Orden recién creada', 1),
('Confirmado', 'Orden confirmada y en proceso', 1),
('En preparación', 'Orden siendo preparada en almacén', 1),
('En tránsito', 'Paquete en camino', 1),
('En distribución', 'Paquete en proceso de entrega final', 1),
('Entregado', 'Paquete entregado al destinatario', 1),
('Cancelado', 'Orden cancelada', 1),
('Devuelto', 'Paquete devuelto al remitente', 1),
('Retenido', 'Paquete retenido en aduana', 1),
('Extraviado', 'Paquete extraviado en tránsito', 1);

-- Insert tariffs for each destination
INSERT INTO `tariff` (
    `destination_id`, `country_id`, `province_id`,
    `tariff_price`, `weight`, `volume`, `active`
) VALUES
-- Standard Package Prices (Uruguayan Pesos)
-- Hasta 2Kg / 40 x 20 x 20 cm
(1, 1, 1, 130.00, 2.00, 16000.00, 1),    -- Normal delivery
(1, 1, 1, 160.00, 2.00, 16000.00, 1),    -- 24h delivery

-- De 2 a 5 Kg / 40 x 30 x 30 cm
(1, 1, 1, 155.00, 5.00, 36000.00, 1),    -- Normal delivery
(1, 1, 1, 185.00, 5.00, 36000.00, 1),    -- 24h delivery

-- De 5 a 20 Kg / 100 x 60 x 60 cm
(1, 1, 1, 200.00, 20.00, 360000.00, 1),   -- Normal delivery
(1, 1, 1, 230.00, 20.00, 360000.00, 1),   -- 24h delivery

-- De 20 a 30 Kg / 100 x 60 x 60 cm
(1, 1, 1, 360.00, 30.00, 360000.00, 1),   -- Normal delivery
(1, 1, 1, 390.00, 30.00, 360000.00, 1),   -- 24h delivery

-- Paquetes de gran tamaño
(1, 1, 1, 750.00, 40.00, 500000.00, 1),   -- Normal delivery
(1, 1, 1, 980.00, 40.00, 500000.00, 1),   -- 24h delivery

-- Retiro de Mercadería
(1, 1, 1, 80.00, 0.00, 0.00, 1);     -- Fixed price

-- Insert test orders
INSERT INTO `orders` (
    `customer_id`, `tariff_id`, `status_id`, `order_number`,
    `total_amount`, `tracking_number`, `items`, `client`,
    `reference`, `shipping_data`, `postal_code`, `weight`,
    `volume`, `active`
) VALUES
(1, 1, 1, 'ORD-2024-001', 130.00, 'TRK001',
 '{"items":[{"name":"Product 1","quantity":1}]}',
 'Empresa A', 'Pedido 1',
 '{"address":"Av. Corrientes 1234","city":"Buenos Aires"}',
 '1000', 2.00, 16000.00, 1),

(2, 3, 2, 'ORD-2024-002', 155.00, 'TRK002',
 '{"items":[{"name":"Product 2","quantity":2}]}',
 'Comercial B', 'Pedido 2',
 '{"address":"Rua Augusta 567","city":"São Paulo"}',
 '01000', 5.00, 36000.00, 1),

(3, 5, 3, 'ORD-2024-003', 200.00, 'TRK003',
 '{"items":[{"name":"Product 3","quantity":1}]}',
 'Distribuidora C', 'Pedido 3',
 '{"address":"Av. Providencia 789","city":"Santiago"}',
 '8320000', 15.00, 360000.00, 1),

(4, 7, 4, 'ORD-2024-004', 360.00, 'TRK004',
 '{"items":[{"name":"Product 4","quantity":3}]}',
 'Importadora D', 'Pedido 4',
 '{"address":"Av. 18 de Julio 456","city":"Montevideo"}',
 '11000', 25.00, 360000.00, 1);

-- Insert order items
INSERT INTO `order_items` (
    `order_id`, `product_id`, `quantity`,
    `unit_price`, `total_price`, `active`
) VALUES
(1, 1, 1, 130.00, 130.00, 1),
(2, 2, 2, 77.50, 155.00, 1),
(3, 3, 1, 200.00, 200.00, 1),
(4, 4, 3, 120.00, 360.00, 1);

-- Insert test users with correct Ion Auth SHA1 passwords
INSERT INTO `users` (
    `ip_address`,
    `username`,
    `password`,
    `salt`,
    `email`,
    `created_on`,
    `active`,
    `name`,
    `surname`,
    `company`,
    `telefono`
) VALUES
('127.0.0.1', 'admin.test', SHA1(CONCAT('test123', 'salt_test1')), 'salt_test1', 'admin.test@lanube.com', UNIX_TIMESTAMP(), 1, 'Admin', 'User', 'La Nube', '+54911111111'),
('127.0.0.1', 'operator.test', SHA1(CONCAT('test123', 'salt_test2')), 'salt_test2', 'operator.test@lanube.com', UNIX_TIMESTAMP(), 1, 'Operator', 'User', 'La Nube', '+54922222222'),
('127.0.0.1', 'manager.test', SHA1(CONCAT('test123', 'salt_test3')), 'salt_test3', 'manager.test@lanube.com', UNIX_TIMESTAMP(), 1, 'Manager', 'User', 'La Nube', '+54933333333');

-- Insert additional admin users with correct Ion Auth SHA1 passwords
INSERT INTO `users` (
    `ip_address`,
    `username`,
    `password`,
    `salt`,
    `email`,
    `created_on`,
    `active`,
    `name`,
    `surname`,
    `company`,
    `telefono`
) VALUES
('127.0.0.1', 'admin4', SHA1(CONCAT('test123', 'salt_test4')), 'salt_test4', 'admin4@lanube.com', UNIX_TIMESTAMP(), 1, 'Admin', 'User 4', 'La Nube', '+54944444444'),
('127.0.0.1', 'admin5', SHA1(CONCAT('test123', 'salt_test5')), 'salt_test5', 'admin5@lanube.com', UNIX_TIMESTAMP(), 1, 'Admin', 'User 5', 'La Nube', '+54955555555');

-- Insert groups
INSERT INTO `groups` (`name`, `description`, `active`) VALUES
('admin.test', 'Administrator', 1),
('operator.test', 'System Operator', 1),
('manager.test', 'System Manager', 1);

-- Link users to groups
INSERT INTO `users_groups` (`id_user`, `id_group`, `active`)
SELECT u.id_user, g.id_group, 1
FROM `users` u
CROSS JOIN `groups` g
WHERE (u.username = 'admin.test' AND g.name = 'admin.test')
   OR (u.username = 'operator.test' AND g.name = 'operator.test')
   OR (u.username = 'manager.test' AND g.name = 'manager.test');

-- Link additional admin users to admin group
INSERT INTO `users_groups` (`id_user`, `id_group`, `active`)
SELECT u.id_user, g.id_group, 1
FROM `users` u
CROSS JOIN `groups` g
WHERE u.username IN ('admin4', 'admin5') AND g.name = 'admin.test';

-- Insert test login attempts
INSERT INTO `login_attempts` (
    `id_user`,
    `ip_address`,
    `login`,
    `time`
) VALUES
(1, '127.0.0.1', 'admin.test', UNIX_TIMESTAMP()),
(2, '127.0.0.1', 'operator.test', UNIX_TIMESTAMP()),
(3, '127.0.0.1', 'manager.test', UNIX_TIMESTAMP());

-- Insert test login errors
INSERT INTO `login_attempts_errors` (
    `id_attemp`,
    `ip_address`,
    `login`,
    `time`,
    `id_user`,
    `active`
) VALUES
(1, '127.0.0.1', 'wrong_user', UNIX_TIMESTAMP(), NULL, 1),
(2, '127.0.0.1', 'invalid', UNIX_TIMESTAMP(), NULL, 1),
(3, '127.0.0.1', 'admin', UNIX_TIMESTAMP(), 1, 1),
(4, '127.0.0.1', 'admin.test', UNIX_TIMESTAMP(), 2, 1),
(5, '127.0.0.1', 'operator.test', UNIX_TIMESTAMP(), 3, 1);

-- Insert login errors data
INSERT INTO `login_errors` (
    `user`,
    `password`,
    `ip_address`
) VALUES
('failed_user1', 'wrong_pass123', '192.168.1.100'),
('invalid_admin', 'incorrect456', '192.168.1.101'),
('wrong_login', 'test789', '192.168.1.102'),
('blocked_user', 'blocked123', '192.168.1.103'),
('unknown_user', 'unknown456', '192.168.1.104');

-- Insert activity logs
INSERT INTO `activity_log` (
    `id_user`, `action`, `description`, `ip_address`, `created_at`
) VALUES
(1, 'LOGIN', 'User logged into the system', '127.0.0.1', CURRENT_TIMESTAMP),
(1, 'CREATE_ORDER', 'Created order #ORD-2024-001', '127.0.0.1', CURRENT_TIMESTAMP),
(2, 'LOGIN', 'User logged into the system', '127.0.0.1', CURRENT_TIMESTAMP),
(2, 'UPDATE_ORDER', 'Updated order status to SHIPPED', '127.0.0.1', CURRENT_TIMESTAMP),
(3, 'LOGIN', 'User logged into the system', '127.0.0.1', CURRENT_TIMESTAMP),
(3, 'CREATE_CUSTOMER', 'Created new customer account', '127.0.0.1', CURRENT_TIMESTAMP);

-- First insert a root menu item
INSERT INTO `menus` (
    `description`, `link`, `status`, `parent`, `iconpath`, `active`, `dashboard`, `order`
) VALUES
('Root', '#', 1, NULL, 'fas fa-sitemap', 1, 0, 0);

-- Insert main menu categories
INSERT INTO `menus` (
    `description`, `link`, `status`, `parent`, `iconpath`, `active`, `dashboard`, `order`
) VALUES
-- Main sections
('Customer Management', 'ecommerce/customers', 1, 1, 'fas fa-users', 1, 1, 1),
('Order Management', 'ecommerce/orders', 1, 1, 'fas fa-shopping-cart', 1, 1, 2),
('Tariff Management', 'ecommerce/tariff', 1, 1, 'fas fa-dollar-sign', 1, 1, 3),
('Location Management', 'ecommerce/locations', 1, 1, 'fas fa-map-marker-alt', 1, 1, 4),
('User Management', 'backend/users', 1, 1, 'fas fa-user-shield', 1, 1, 5),
('System Configuration', 'backend/configuraciones', 1, 1, 'fas fa-cogs', 1, 1, 6),
('Reports', 'backend/reports', 1, 1, 'fas fa-chart-bar', 1, 1, 7),
('Authentication', 'backend/auth', 1, 1, 'fas fa-lock', 1, 1, 8),
('Other Utilities', 'backend/utilities', 1, 1, 'fas fa-tools', 1, 1, 9);

-- Now insert all submenu items
INSERT INTO `menus` (
    `description`, `link`, `status`, `parent`, `iconpath`, `active`, `dashboard`, `order`
)
SELECT 
    child.description,
    child.link,
    1 as status,
    m.id_menu as parent,
    child.icon as iconpath,
    1 as active,
    1 as dashboard,
    child.sort_order
FROM (
    -- Customer Management children
    SELECT 'Customer Management' as parent_desc, 'List Customers' as description, 'ecommerce/customers' as link, 'fas fa-list' as icon, 1 as sort_order UNION ALL
    SELECT 'Customer Management', 'Add Customer', 'ecommerce/customers/add', 'fas fa-user-plus', 2 UNION ALL
    SELECT 'Customer Management', 'Edit Customer', 'ecommerce/customers/edit', 'fas fa-edit', 3 UNION ALL
    SELECT 'Customer Management', 'Customer Tokens', 'ecommerce/customers/tokens', 'fas fa-key', 4 UNION ALL
    SELECT 'Customer Management', 'Generate Token', 'ecommerce/customers/generateToken', 'fas fa-plus-circle', 5 UNION ALL
    SELECT 'Customer Management', 'Revoke Token', 'ecommerce/customers/revokeToken', 'fas fa-minus-circle', 6 UNION ALL

    -- Order Management children
    SELECT 'Order Management', 'List Orders', 'ecommerce/orders' as link, 'fas fa-list', 1 UNION ALL
    SELECT 'Order Management', 'View Order', 'ecommerce/orders/view', 'fas fa-eye', 2 UNION ALL
    SELECT 'Order Management', 'Edit Order', 'ecommerce/orders/edit', 'fas fa-edit', 3 UNION ALL
    SELECT 'Order Management', 'Update Status', 'ecommerce/orders/status', 'fas fa-sync', 4 UNION ALL

    -- Tariff Management children
    SELECT 'Tariff Management', 'List Tariffs', 'ecommerce/tariff', 'fas fa-list', 1 UNION ALL
    SELECT 'Tariff Management', 'Add Tariff', 'ecommerce/tariff/add', 'fas fa-plus', 2 UNION ALL
    SELECT 'Tariff Management', 'Edit Tariff', 'ecommerce/tariff/edit', 'fas fa-edit', 3 UNION ALL

    -- Location Management children
    SELECT 'Location Management', 'Countries', 'ecommerce/countries', 'fas fa-globe', 1 UNION ALL
    SELECT 'Location Management', 'Provinces', 'ecommerce/provinces', 'fas fa-map', 2 UNION ALL
    SELECT 'Location Management', 'Destinations', 'ecommerce/destinations', 'fas fa-location-arrow', 3 UNION ALL

    -- User Management children
    SELECT 'User Management', 'List Users', 'backend/users', 'fas fa-list', 1 UNION ALL
    SELECT 'User Management', 'Add User', 'backend/users/add', 'fas fa-user-plus', 2 UNION ALL
    SELECT 'User Management', 'Edit User', 'backend/users/edit', 'fas fa-user-edit', 3 UNION ALL
    SELECT 'User Management', 'Change Password', 'backend/users/change_password', 'fas fa-key', 4 UNION ALL

    -- System Configuration children
    SELECT 'System Configuration', 'View Configurations', 'backend/configuraciones', 'fas fa-list', 1 UNION ALL
    SELECT 'System Configuration', 'Edit Configuration', 'backend/configuraciones/edit', 'fas fa-edit', 2 UNION ALL

    -- Reports children
    SELECT 'Reports', 'Order Reports', 'backend/reports/orders', 'fas fa-file-alt', 1 UNION ALL
    SELECT 'Reports', 'Customer Reports', 'backend/reports/customers', 'fas fa-users', 2 UNION ALL
    SELECT 'Reports', 'Activity Logs', 'backend/reports/activity', 'fas fa-history', 3 UNION ALL

    -- Authentication children
    SELECT 'Authentication', 'Login', 'backend/auth/login', 'fas fa-sign-in-alt', 1 UNION ALL
    SELECT 'Authentication', 'Logout', 'backend/auth/logout', 'fas fa-sign-out-alt', 2 UNION ALL
    SELECT 'Authentication', 'Forgot Password', 'backend/auth/forgot_password', 'fas fa-unlock', 3 UNION ALL

    -- Other Utilities children
    SELECT 'Other Utilities', 'Activity Logs', 'backend/auditoria', 'fas fa-clipboard-list', 1 UNION ALL
    SELECT 'Other Utilities', 'System Logs', 'backend/logs', 'fas fa-file-alt', 2 UNION ALL
    SELECT 'Other Utilities', 'Database Backup', 'backend/backup', 'fas fa-database', 3
) as child
JOIN `menus` m ON m.description = child.parent_desc;

-- Add permissions for all menus to admin group
INSERT INTO `permissions` (
    `id_group`, `id_menu`, `read`, `insert`, `update`, `delete`, 
    `export`, `print`, `invoice`, `active`
)
SELECT 
    g.id_group,
    m.id_menu,
    1, 1, 1, 1, 1, 1, 1, 1
FROM `groups` g
CROSS JOIN `menus` m
WHERE g.name = 'admin.test'
AND NOT EXISTS (
    SELECT 1 FROM `permissions` p 
    WHERE p.`id_menu` = m.`id_menu` 
    AND p.`id_group` = g.`id_group`
);

-- Add basic read permissions for operator group
INSERT INTO `permissions` (
    `id_group`, `id_menu`, `read`, `insert`, `update`, `delete`, 
    `export`, `print`, `invoice`, `active`
)
SELECT 
    g.id_group,
    m.id_menu,
    1, 0, 0, 0, 1, 1, 0, 1
FROM `groups` g
CROSS JOIN `menus` m
WHERE g.name = 'operator.test'
AND NOT EXISTS (
    SELECT 1 FROM `permissions` p 
    WHERE p.`id_menu` = m.`id_menu` 
    AND p.`id_group` = g.`id_group`
);

-- Add management permissions for manager group
INSERT INTO `permissions` (
    `id_group`, `id_menu`, `read`, `insert`, `update`, `delete`, 
    `export`, `print`, `invoice`, `active`
)
SELECT 
    g.id_group,
    m.id_menu,
    1, 1, 1, 0, 1, 1, 1, 1
FROM `groups` g
CROSS JOIN `menus` m
WHERE g.name = 'manager.test'
AND NOT EXISTS (
    SELECT 1 FROM `permissions` p 
    WHERE p.`id_menu` = m.`id_menu` 
    AND p.`id_group` = g.`id_group`
);

-- Insert product categories
INSERT INTO `product_categories` (
    `name`, `description`, `parent_id`, `order`, `active`
) VALUES
('Electronics', 'Electronic devices and accessories', NULL, 1, 1),
('Clothing', 'Apparel and fashion items', NULL, 2, 1),
('Home & Garden', 'Home improvement and garden supplies', NULL, 3, 1),
('Books', 'Books and publications', NULL, 4, 1),

-- Electronics subcategories
('Smartphones', 'Mobile phones and accessories', 1, 1, 1),
('Laptops', 'Portable computers', 1, 2, 1),
('Tablets', 'Tablet devices', 1, 3, 1),

-- Clothing subcategories
('Men''s Wear', 'Clothing for men', 2, 1, 1),
('Women''s Wear', 'Clothing for women', 2, 2, 1),
('Children''s Wear', 'Clothing for children', 2, 3, 1);

-- Insert configurations
INSERT INTO `configurations` (
    `id_configuration`, `name`, `value`, `key_id`, `input`, `required`,
    `icon`, `ordering`, `enabled`, `active`, `description`
) VALUES
(1, 'Email Remitente', 'nahuelbalsasbtta@gmail.com', 'email_remitente', 'email', 1,
 'fa-envelope', 1, 1, 1, 'Email address used as sender for system emails'),
(2, 'Email Soporte', 'support@lanube.com', 'email_soporte', 'email', 1,
 'fa-envelope', 2, 1, 1, 'Support email address'),
(3, 'Email Administrador', 'operaciones@d-unit.world', 'email_admin', 'email', 1,
 'fa-envelope', 3, 1, 1, 'Administrator email for notifications'),
(4, 'Email QA', 'qa@lanube.com', 'email_qa', 'email', 1,
 'fa-envelope', 4, 1, 1, 'QA team email for testing'),
(5, 'Nombre Sistema', 'La Nube', 'nombre_sistema', 'text', 1,
 'fa-cloud', 5, 1, 1, 'System name displayed in emails and interface'),
(6, 'URL Sistema', 'http://localhost:8000', 'url_sistema', 'text', 1,
 'fa-link', 6, 1, 1, 'Base URL of the system'),
(7, 'Captcha Site Key', '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI', 'captcha_site_key', 'text', 1,
 'fa-shield-alt', 7, 1, 1, 'Google reCAPTCHA site key'),
(8, 'Captcha Secret Key', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe', 'captcha_secret_key', 'text', 1,
 'fa-key', 8, 1, 1, 'Google reCAPTCHA secret key');

-- Insert email templates
INSERT INTO `email_templates` (
    `name`, `subject`, `content`, `variables`, `active`
) VALUES
('Customer Registration', 'Bienvenido a La Nube - Confirmación de registro',
 'Estimado/a {customer_name},\n\nGracias por registrarse en La Nube. Su cuenta ha sido creada exitosamente.\n\nDetalles de su cuenta:\nEmail: {email}\nEmpresa: {enterprise}\n\nPuede acceder al sistema usando su email y contraseña.\n\nSaludos cordiales,\nEquipo de La Nube',
 '{"customer_name":"","email":"","enterprise":""}',
 1),
('Admin Registration Notification', 'Nuevo registro de cliente',
 'Se ha registrado un nuevo cliente en el sistema.\n\nDetalles:\nEmpresa: {enterprise}\nContacto: {customer_name}\nEmail: {email}\n\nPor favor, verifique la información y active los tokens correspondientes.',
 '{"customer_name":"","email":"","enterprise":""}',
 1);

-- Insert FAQs
INSERT INTO `faqs` (`question`, `answer`, `active`) VALUES
('¿Cuál es el tiempo de entrega estándar?', 'El tiempo de entrega estándar es de 48 horas. Sin embargo, también ofrecemos un servicio express de 24 horas por un costo adicional.', 1),

('¿Qué áreas geográficas cubren?', 'Actualmente cubrimos toda el área metropolitana de Montevideo y zonas aledañas. Consulta nuestro mapa de cobertura para más detalles.', 1),

('¿Cómo puedo rastrear mi envío?', 'Puedes rastrear tu envío ingresando el número de seguimiento en nuestra plataforma web o aplicación móvil. También recibirás actualizaciones por email.', 1),

('¿Qué sucede si no hay nadie para recibir el paquete?', 'Si no hay nadie para recibir el paquete, dejaremos un aviso de visita. El destinatario tendrá 5 días corridos para recoger el envío en nuestro centro logístico.', 1),

('¿Cuál es el peso máximo permitido?', 'Aceptamos paquetes de hasta 40kg. Para envíos más pesados, contáctanos para una cotización especial.', 1),

('¿Cómo debo embalar mi paquete?', 'Recomendamos usar cajas resistentes, material de relleno para proteger el contenido y cinta adhesiva de calidad. El paquete debe estar bien sellado y etiquetado.', 1),

('¿Qué formas de pago aceptan?', 'Aceptamos tarjetas de crédito, débito, transferencias bancarias y pagos en efectivo. Para clientes corporativos ofrecemos crédito previa evaluación.', 1),

('¿Ofrecen seguro para los envíos?', 'Sí, todos nuestros envíos incluyen un seguro básico. También ofrecemos seguros adicionales para envíos de mayor valor.', 1),

('¿Cómo puedo contratar sus servicios?', 'Puedes registrarte en nuestra plataforma web, completar el formulario de registro y comenzar a utilizar nuestros servicios inmediatamente.', 1),

('¿Tienen servicio de almacenamiento?', 'Sí, ofrecemos servicios de almacenamiento en nuestras bodegas desde 10m² hasta 50m², con vigilancia 24/7 y control de inventario.', 1);

-- Insert user types
INSERT INTO `tipo_usuario` (`name`, `description`, `active`) VALUES
('Individual', 'Cliente individual o persona física', 1),
('Empresa', 'Cliente empresarial o persona jurídica', 1),
('Distribuidor', 'Distribuidor autorizado', 1),
('Mayorista', 'Cliente mayorista', 1);

-- Ensure admin group has all permissions for user management
INSERT INTO `permissions` (
    `id_group`, `id_menu`, `read`, `insert`, `update`, `delete`, 
    `export`, `print`, `invoice`, `active`
)
SELECT 
    g.id_group,
    m.id_menu,
    1, 1, 1, 1, 1, 1, 1, 1
FROM `groups` g
CROSS JOIN `menus` m
WHERE g.name = 'admin'
AND m.link LIKE 'backend/users%'
AND NOT EXISTS (
    SELECT 1 FROM `permissions` p 
    WHERE p.id_menu = m.id_menu 
    AND p.id_group = g.id_group
)
ON DUPLICATE KEY UPDATE
    `read` = 1,
    `insert` = 1,
    `update` = 1,
    `delete` = 1,
    `export` = 1,
    `print` = 1,
    `invoice` = 1,
    `active` = 1;

-- Ensure proper user-group association
INSERT INTO `users_groups` (`id_user`, `id_group`, `active`)
SELECT u.id_user, g.id_group, 1
FROM `users` u
CROSS JOIN `groups` g
WHERE u.username = 'admin'
AND g.name = 'admin'
AND NOT EXISTS (
    SELECT 1 FROM `users_groups` ug 
    WHERE ug.id_user = u.id_user 
    AND ug.id_group = g.id_group
);

-- Reset and setup proper permissions
TRUNCATE TABLE `permissions`;

-- Insert base permissions for admin group
INSERT INTO `permissions` (
    `id_group`,
    `id_menu`,
    `read`,
    `insert`,
    `update`,
    `delete`,
    `export`,
    `print`,
    `invoice`,
    `active`
)
SELECT 
    g.id_group,
    m.id_menu,
    1, 1, 1, 1, 1, 1, 1, 1
FROM `groups` g
CROSS JOIN `menus` m
WHERE g.name = 'admin';

-- Ensure specific permissions for log pages
INSERT INTO `permissions` (
    `id_group`,
    `id_menu`,
    `read`,
    `insert`,
    `update`,
    `delete`,
    `export`,
    `print`,
    `invoice`,
    `active`
)
SELECT 
    g.id_group,
    m.id_menu,
    1, 1, 1, 1, 1, 1, 1, 1
FROM `groups` g
CROSS JOIN `menus` m
WHERE g.name = 'admin'
AND m.link IN ('backend/auditoria', 'backend/logs')
ON DUPLICATE KEY UPDATE
    `read` = 1,
    `insert` = 1,
    `update` = 1,
    `delete` = 1,
    `export` = 1,
    `print` = 1,
    `invoice` = 1,
    `active` = 1;

-- Reset user-group associations for admin
DELETE FROM `users_groups` WHERE id_user IN (
    SELECT id_user FROM users WHERE username = 'admin'
);

-- Recreate admin user-group association
INSERT INTO `users_groups` (`id_user`, `id_group`, `active`)
SELECT DISTINCT u.id_user, g.id_group, 1
FROM `users` u
JOIN `groups` g ON g.name = 'admin'
WHERE u.username = 'admin'
AND NOT EXISTS (
    SELECT 1 FROM `users_groups` ug 
    WHERE ug.id_user = u.id_user 
    AND ug.id_group = g.id_group
);

-- Update admin user status
UPDATE `users` SET active = 1 WHERE username = 'admin';

-- Update admin group status
UPDATE `groups` SET active = 1 WHERE name = 'admin';

-- Log the permission reset
INSERT INTO `activity_log` (
    `id_user`,
    `action`,
    `description`,
    `ip_address`,
    `created_at`
) 
SELECT 
    u.id_user,
    'PERMISSION_RESET',
    'Full permissions reset and setup completed',
    '127.0.0.1',
    NOW()
FROM `users` u
WHERE u.username = 'admin'
LIMIT 1;