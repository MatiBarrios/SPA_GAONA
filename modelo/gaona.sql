-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2022 a las 03:20:54
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gaona`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `asignar_cita_agente` (IN `id_cita` INT, IN `id_agente` INT, IN `fecha_y_hora` DATETIME)  BEGIN
	UPDATE cita SET idAgente = id_agente, aceptada = TRUE WHERE id = id_cita;
    INSERT INTO agenda (tipoActividad,  estado, fechaYHoraInicio, fechaYHoraFin, idCita, idAgente) VALUES ("cita", "en proceso", fecha_y_hora, ADDTIME(fecha_y_hora, "2:00:00"), id_cita, id_agente);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `crear_cierre_caja` ()  BEGIN
	IF((SELECT COUNT(id) FROM cierre_caja WHERE fecha = DATE(NOW())) = 0) THEN
    	INSERT INTO cierre_caja (fecha) VALUE (NOW());
    END IF;
    
    UPDATE movimiento_cuenta SET idCierreCaja = (SELECT id FROM cierre_caja WHERE fecha = DATE(NOW())) WHERE idCierreCaja IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_cliente_corporativo` (IN `cod_cliente` INT, IN `num_cuit` BIGINT(11), IN `tel` BIGINT, IN `mail` VARCHAR(100), IN `razon_social` VARCHAR(100), IN `nom_propietarios` TEXT, IN `dir_administracion` VARCHAR(200), IN `id_agente` INT)  BEGIN
	UPDATE cliente SET telefono = tel, correo = mail WHERE codCliente = cod_cliente;
    UPDATE cliente_corporativo SET razonSocial = razon_social, propietarios = nom_propietarios, cuit = num_cuit, direccionAdministracion = dir_administracion, idAgenteACargo = id_agente WHERE codCliente = cod_cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_cliente_particular` (IN `cod_cliente` INT, IN `num_cuil` BIGINT(11), IN `tel` BIGINT, IN `mail` VARCHAR(100))  BEGIN
	UPDATE cliente SET telefono = tel, correo = mail WHERE codCliente = cod_cliente;
    UPDATE cliente_particular SET cuil = num_cuil WHERE codCliente = cod_cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generar_reportes` (IN `inicio` DATE, IN `fin` DATE, IN `nom_tipo` VARCHAR(7))  BEGIN
	DECLARE id_reporte INT;
	INSERT INTO reporte (tipo, fechaInicio, fechaFin) VALUES (nom_tipo, inicio, fin);
    SET @id_reporte = (SELECT id FROM reporte ORDER BY id DESC LIMIT 1);
    INSERT INTO reporte_pagos (numTransaccion, idReporte) SELECT numTransaccion, @id_reporte FROM pago WHERE fecha BETWEEN inicio AND fin;
    INSERT INTO reporte_clientes (codCliente, idReporte) SELECT codCliente, @id_reporte FROM cliente WHERE fechaRegistrado BETWEEN inicio AND fin;
    INSERT INTO reporte_historico_propiedad (idHistoricoPropiedad, idReporte) SELECT id, @id_reporte FROM historico_propiedad WHERE fecha BETWEEN inicio AND fin;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generar_reporte_transacciones` (IN `inicio` DATE, IN `fin` DATE)  BEGIN
	DECLARE id_reporte INT;
	INSERT INTO reporte (fechaInicio, fechaFin) VALUES (inicio, fin);
    SET @id_reporte = (SELECT id FROM reporte ORDER BY id DESC LIMIT 1);
    INSERT INTO relacion_reporte_cuenta (idMovimientoCuenta, idReporte) SELECT id, @id_reporte FROM movimiento_cuenta WHERE fecha BETWEEN inicio AND fin;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_agenda_agente` (IN `id_agente` INT)  SELECT tipoActividad, estado, fechaYHoraInicio, fechaYHoraFin, cita.codCliente, cliente_particular.nombre, cliente_particular.apellido, cliente_corporativo.razonSocial AS empresa, cita.codPropiedad, propiedad.pais, propiedad.provincia, propiedad.localidad, propiedad.barrio, propiedad.direccion FROM agenda
LEFT JOIN cita ON idCita = cita.id 
LEFT JOIN propiedad ON propiedad.codPropiedad = cita.codPropiedad
LEFT JOIN cliente_corporativo ON cliente_corporativo.codCliente = cita.codCliente
LEFT JOIN cliente_particular ON cliente_particular.codCliente = cita.codCliente
WHERE idAgente = id_agente$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_agenda_todo` ()  SELECT tipoActividad, estado, fechaYHoraInicio, fechaYHoraFin, cita.codCliente, cliente_particular.nombre, cliente_particular.apellido, cliente_corporativo.razonSocial AS empresa, cita.codPropiedad, propiedad.pais, propiedad.provincia, propiedad.localidad, propiedad.barrio, propiedad.direccion FROM agenda
LEFT JOIN cita ON idCita = cita.id 
LEFT JOIN propiedad ON propiedad.codPropiedad = cita.codPropiedad
LEFT JOIN cliente_corporativo ON cliente_corporativo.codCliente = cita.codCliente
LEFT JOIN cliente_particular ON cliente_particular.codCliente = cita.codCliente$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_citas` ()  SELECT cliente_particular.nombre AS nombreCliente, cliente_particular.apellido AS apellidoCliente, cliente_corporativo.razonSocial AS empresaCliente, empleado.nombre AS nombreAgente, empleado.apellido AS apellidoAgente, fechaYHoraCita, fechaYHoraRegistro, aceptada, codPropiedad FROM cita
INNER JOIN cliente ON cita.codCliente = cliente.codCliente
LEFT JOIN cliente_particular ON cliente_particular.codCliente = cita.codCliente
LEFT JOIN cliente_corporativo ON cliente_corporativo.codCliente = cita.codCliente
LEFT JOIN empleado ON empleado.id = idAgente
WHERE aceptada IS NOT FALSE ORDER BY fechaYHoraRegistro$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_citas_no_agendadas` ()  SELECT cita.id,cliente_particular.nombre AS nombreCliente, cliente_particular.apellido AS apellidoCliente, cliente_corporativo.razonSocial AS empresaCliente, empleado.nombre AS nombreAgente, empleado.apellido AS apellidoAgente, fechaYHoraCita, fechaYHoraRegistro, codPropiedad FROM cita
INNER JOIN cliente ON cita.codCliente = cliente.codCliente
LEFT JOIN cliente_particular ON cliente_particular.codCliente = cita.codCliente
LEFT JOIN cliente_corporativo ON cliente_corporativo.codCliente = cita.codCliente
LEFT JOIN empleado ON empleado.id = idAgente
WHERE aceptada IS NULL ORDER BY fechaYHoraRegistro$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_movimientos_cuenta` ()  SELECT tipo_caja.nomTipo AS tipoCaja, concepto, monto, fecha, idCierreCaja, codPropiedad, cliente_particular.nombre AS nombreCliente, cliente_corporativo.razonSocial AS empresaCliente FROM movimiento_cuenta
INNER JOIN tipo_caja ON tipo_caja.id = idTipoCaja
LEFT JOIN cliente ON movimiento_cuenta.codCliente = cliente.codCliente
LEFT JOIN cliente_particular ON cliente.codCliente = cliente_particular.codCliente
LEFT JOIN cliente_corporativo ON cliente.codCliente = cliente_corporativo.codCliente$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_pagos` ()  SELECT cliente_particular.nombre AS nombreCliente, cliente_corporativo.razonSocial AS empresaCliente, idContrato, formaPago, fecha, mes, anio, interes, expensas, esFinanciada, comision, precio, moneda FROM pago
INNER JOIN cliente ON pago.codCliente = cliente.codCliente
LEFT JOIN cliente_particular ON cliente_particular.codCliente = pago.codCliente
LEFT JOIN cliente_corporativo ON cliente_corporativo.codCliente = pago.codCliente
LEFT JOIN alquiler ON pago.numTransaccion = alquiler.numTransaccion
LEFT JOIN venta ON pago.numTransaccion = venta.numTransaccion$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_propiedades_habilitadas` ()  SELECT codPropiedad, duenio_particular.nombre AS nombre_duenio, duenio_corporativo.razonSocial AS empresa_duenia, inquilino_particular.nombre AS nombre_inquilino, inquilino_corporativo.razonSocial AS empresa_inquilina, tipo, superficie, pais, provincia, localidad, barrio, direccion, codpostal, numBanios, numSuites, TIMESTAMPDIFF(YEAR, fechaConstruccion, NOW()) AS antiguedad, espacios, artefactos, servicios, precioAlquiler, precioVenta, fechaRegistrada FROM `propiedad`
LEFT JOIN cliente duenio ON duenio.codCliente = propiedad.codDuenio
LEFT JOIN cliente inquilino ON inquilino.codCliente = propiedad.codInquilino
LEFT JOIN cliente_particular duenio_particular ON duenio_particular.codCliente = propiedad.codDuenio
LEFT JOIN cliente_particular inquilino_particular ON inquilino_particular.codCliente = propiedad.codInquilino
LEFT JOIN cliente_corporativo duenio_corporativo ON duenio_corporativo.codCliente = propiedad.codDuenio
LEFT JOIN cliente_corporativo inquilino_corporativo ON inquilino_corporativo.codCliente = propiedad.codInquilino
WHERE precioVenta IS NOT NULL OR (precioAlquiler IS NOT NULL AND codInquilino IS NULL)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_propiedades_inhabilitadas` ()  SELECT codPropiedad, duenio_particular.nombre AS nombre_duenio, duenio_corporativo.razonSocial AS empresa_duenia, inquilino_particular.nombre AS nombre_inquilino, inquilino_corporativo.razonSocial AS empresa_inquilina, tipo, superficie, pais, provincia, localidad, barrio, direccion, codpostal, numBanios, numSuites, TIMESTAMPDIFF(YEAR, fechaConstruccion, NOW()) AS antiguedad, espacios, artefactos, servicios, precioAlquiler, precioVenta, fechaRegistrada FROM `propiedad`
LEFT JOIN cliente duenio ON duenio.codCliente = propiedad.codDuenio
LEFT JOIN cliente inquilino ON inquilino.codCliente = propiedad.codInquilino
LEFT JOIN cliente_particular duenio_particular ON duenio_particular.codCliente = propiedad.codDuenio
LEFT JOIN cliente_particular inquilino_particular ON inquilino_particular.codCliente = propiedad.codInquilino
LEFT JOIN cliente_corporativo duenio_corporativo ON duenio_corporativo.codCliente = propiedad.codDuenio
LEFT JOIN cliente_corporativo inquilino_corporativo ON inquilino_corporativo.codCliente = propiedad.codInquilino
WHERE precioVenta IS NULL AND (precioAlquiler IS NULL OR codInquilino IS NOT NULL)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_propiedades_todas` ()  SELECT codPropiedad, duenio_particular.nombre AS nombre_duenio, duenio_corporativo.razonSocial AS empresa_duenia, inquilino_particular.nombre AS nombre_inquilino, inquilino_corporativo.razonSocial AS empresa_inquilina, tipo, superficie, pais, provincia, localidad, barrio, direccion, codpostal, numBanios, numSuites, TIMESTAMPDIFF(YEAR, fechaConstruccion, NOW()) AS antiguedad, espacios, artefactos, servicios, precioAlquiler, precioVenta, fechaRegistrada FROM `propiedad`
LEFT JOIN cliente duenio ON duenio.codCliente = propiedad.codDuenio
LEFT JOIN cliente inquilino ON inquilino.codCliente = propiedad.codInquilino
LEFT JOIN cliente_particular duenio_particular ON duenio_particular.codCliente = propiedad.codDuenio
LEFT JOIN cliente_particular inquilino_particular ON inquilino_particular.codCliente = propiedad.codInquilino
LEFT JOIN cliente_corporativo duenio_corporativo ON duenio_corporativo.codCliente = propiedad.codDuenio
LEFT JOIN cliente_corporativo inquilino_corporativo ON inquilino_corporativo.codCliente = propiedad.codInquilino$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_reportes_alquiler` ()  SELECT reporte.id, tipo, fechaInicio, fechaFin, mes, anio, interes, expensas, formaPago, fecha, precio FROM pago
INNER JOIN alquiler ON alquiler.numTransaccion = pago.numTransaccion
INNER JOIN reporte_pagos ON pago.numTransaccion = reporte_pagos.numTransaccion
INNER JOIN reporte ON reporte_pagos.idReporte = reporte.id
GROUP BY tipo ORDER BY id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_reportes_clientes` ()  SELECT reporte.id, tipo, fechaInicio, fechaFin, cliente.codCliente, dni, cuil, nombre, apellido, razonSocial, fechaRegistrado, telefono, correo FROM cliente
INNER JOIN cliente_particular ON cliente.codCliente = cliente_particular.codCliente
INNER JOIN cliente_corporativo ON cliente.codCliente = cliente_corporativo.codCliente
INNER JOIN reporte_clientes ON reporte_clientes.codCliente = cliente.codCliente
INNER JOIN reporte ON reporte_clientes.idReporte = reporte.id
GROUP BY tipo ORDER BY id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_reportes_propiedades` ()  SELECT reporte.id, tipo, fechaInicio, fechaFin, codPropiedad, precioVentaAnterior, precioAlquilerAnterior, duenio_p.nombre AS nombreDuenio, duenio_p.apellido AS apellidoDuenio, duenio_c.razonSocial AS empresaDuenia, inquilino_p.nombre AS nombreInquilino, inquilino_p.apellido AS apellidoInquilino, inquilino_c.razonSocial AS empresaInquilina, fecha FROM historico_propiedad
LEFT JOIN cliente_particular inquilino_p ON historico_propiedad.codInquilinoAnterior = inquilino_p.codCliente
LEFT JOIN cliente_corporativo inquilino_c ON historico_propiedad.codInquilinoAnterior = inquilino_c.codCliente
LEFT JOIN cliente_particular duenio_p ON historico_propiedad.codInquilinoAnterior = duenio_p.codCliente
LEFT JOIN cliente_corporativo duenio_c ON historico_propiedad.codInquilinoAnterior = duenio_c.codCliente
INNER JOIN reporte_historico_propiedad ON reporte_historico_propiedad.idHistoricoPropiedad = historico_propiedad.id
INNER JOIN reporte ON reporte_historico_propiedad.idReporte = reporte.id
GROUP BY tipo ORDER BY id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `leer_reportes_venta` ()  SELECT reporte.id, tipo, fechaInicio, fechaFin, esFinanciada, comision, formaPago, fecha, precio, moneda FROM pago
INNER JOIN venta ON venta.numTransaccion = pago.numTransaccion
INNER JOIN reporte_pagos ON pago.numTransaccion = reporte_pagos.numTransaccion
INNER JOIN reporte ON reporte_pagos.idReporte = reporte.id
GROUP BY tipo ORDER BY id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `nuevo_empleado` (IN `nom` VARCHAR(50), IN `ape` VARCHAR(50), IN `docum` INT, IN `nom_cargo` VARCHAR(30), IN `tel1` BIGINT, IN `tel2` BIGINT, IN `mail` VARCHAR(100), IN `usr` VARCHAR(20), IN `pass` VARCHAR(20))  BEGIN
    IF((SELECT COUNT(id) FROM empleado WHERE usuario=usr) != 0) THEN
    	SELECT FALSE;
    ELSE
    	INSERT INTO empleado (cargo, nombre, apellido, dni, usuario, contrasenia, correo, telefono, telefonoAlternativo) VALUES (nom_cargo, nom, ape, docum, usr, MD5(pass), mail, tel1, tel2);
        SELECT TRUE;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_cliente_corporativo` (IN `num_dni` INT, IN `num_cuit` BIGINT(11), IN `tel` BIGINT, IN `mail` VARCHAR(100), IN `razon_social` VARCHAR(100), IN `nom_propietarios` TEXT, IN `direccion_administracion` VARCHAR(200), IN `id_agente` INT)  BEGIN
    DECLARE cod_cliente INT;
	IF((SELECT COUNT(codCliente) FROM cliente WHERE dni = num_dni) = 0 AND (SELECT COUNT(codCliente) FROM cliente_corporativo WHERE cuit = num_cuit) = 0) THEN
		INSERT INTO cliente (dni, fechaRegistrado, telefono, correo) VALUES (num_dni, NOW(), tel, mail);
        SET @cod_cliente = (SELECT codCliente FROM cliente ORDER BY codCliente DESC LIMIT 1);
        INSERT INTO cliente_corporativo (codCliente, razonSocial, propietarios, cuit, direccionAdministracion, idAgenteACargo) VALUES (@cod_cliente, razon_social, nom_propietarios, num_cuit, direccion_administracion, id_agente);
        SELECT TRUE;
	ELSE SELECT FALSE;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_cliente_particular` (IN `num_dni` INT, IN `num_cuil` BIGINT(11), IN `tel` BIGINT, IN `mail` VARCHAR(100), IN `nom` VARCHAR(50), IN `ape` VARCHAR(50), IN `nacimiento` DATE)  BEGIN
    DECLARE cod_cliente INT;
	IF((SELECT COUNT(codCliente) FROM cliente WHERE dni = num_dni) = 0 AND (SELECT COUNT(codCliente) FROM cliente_particular WHERE cuil = num_cuil) = 0) THEN
		INSERT INTO cliente (dni, fechaRegistrado, telefono, correo) VALUES (num_dni, NOW(), tel, mail);
        SET @cod_cliente = (SELECT codCliente FROM cliente ORDER BY codCliente DESC LIMIT 1);
        INSERT INTO cliente_particular (codCliente, nombre, apellido, fechaNacimiento, cuil) VALUES (@cod_cliente, nom, ape, nacimiento, num_cuil);
        SELECT TRUE;
	ELSE SELECT FALSE;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_pago_alquiler` (IN `cod_cliente` INT, IN `id_contrato` INT, IN `forma_pago` VARCHAR(30), IN `mes_pago` TINYINT, IN `anio_pago` SMALLINT, IN `cant_interes` FLOAT, IN `cant_expensas` INT, IN `precio_alq` INT)  BEGIN
	DECLARE num_transaccion INT;
	INSERT INTO pago (codCliente, id_contrato, formaPago, fecha, precio) VALUES (cod_cliente, id_contrato, forma_pago, NOW(), precio_alq);
    SET @num_transaccion = (SELECT numTransaccion FROM pago ORDER BY numTransaccion DESC LIMIT 1);
    INSERT INTO alquiler (numTransaccion, mes, anio, interes, expensas) VALUES (@num_transaccion, mes_pago, anio_pago, cant_interes, cant_expensas);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_pago_venta` (IN `cod_cliente` INT, IN `id_contrato` INT, IN `forma_pago` VARCHAR(30), IN `financiada` BOOLEAN, IN `cant_comision` FLOAT, IN `num_precio` INT, IN `tipo_moneda` VARCHAR(20))  BEGIN
	DECLARE num_transaccion INT;
	INSERT INTO pago (codCliente, id_contrato, formaPago, fecha, precio) VALUES (cod_cliente, id_contrato, forma_pago, NOW(), num_precio);
    SET @num_transaccion = (SELECT numTransaccion FROM pago ORDER BY numTransaccion DESC LIMIT 1);
    INSERT INTO venta (numTransaccion, esFinanciada, comision, moneda) VALUES (@num_transaccion, financiada, cant_comision, tipo_moneda);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `tipoActividad` varchar(50) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `fechaYHoraInicio` datetime NOT NULL,
  `fechaYHoraFin` datetime NOT NULL,
  `idCita` int(11) DEFAULT NULL,
  `idAgente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `agenda`
--

INSERT INTO `agenda` (`id`, `tipoActividad`, `estado`, `fechaYHoraInicio`, `fechaYHoraFin`, `idCita`, `idAgente`) VALUES
(1, 'Actividad', 'en proceso', '2022-11-07 18:30:27', '2022-11-07 18:30:27', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquiler`
--

CREATE TABLE `alquiler` (
  `numTransaccion` int(11) NOT NULL,
  `mes` tinyint(4) NOT NULL,
  `anio` smallint(6) NOT NULL,
  `interes` float NOT NULL DEFAULT 0,
  `expensas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `nomCargo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`nomCargo`) VALUES
('Administrador'),
('Agente inmobiliario'),
('Cajera'),
('Empleado de marketing'),
('Gerente general'),
('Jefa de administración'),
('Jefa de comercialización'),
('Secretaria de comercialización');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierre_caja`
--

CREATE TABLE `cierre_caja` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cierre_caja`
--

INSERT INTO `cierre_caja` (`id`, `fecha`) VALUES
(1, '2022-11-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id` int(11) NOT NULL,
  `codCliente` int(11) NOT NULL,
  `idAgente` int(11) DEFAULT NULL,
  `fechaYHoraCita` datetime NOT NULL,
  `fechaYHoraRegistro` datetime NOT NULL,
  `aceptada` tinyint(1) DEFAULT NULL,
  `codPropiedad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id`, `codCliente`, `idAgente`, `fechaYHoraCita`, `fechaYHoraRegistro`, `aceptada`, `codPropiedad`) VALUES
(1, 1, 1, '2022-11-09 02:49:46', '2022-11-09 02:49:46', NULL, 1),
(2, 1, 1, '2022-11-22 00:25:24', '2022-11-16 00:25:24', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `codCliente` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
  `fechaRegistrado` date NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`codCliente`, `dni`, `fechaRegistrado`, `telefono`, `correo`) VALUES
(1, 44553234, '2022-11-08', 431145534456, 'htyui');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_corporativo`
--

CREATE TABLE `cliente_corporativo` (
  `codCliente` int(11) NOT NULL,
  `razonSocial` varchar(100) NOT NULL,
  `propietarios` text NOT NULL,
  `cuit` bigint(11) NOT NULL,
  `direccionAdministracion` varchar(200) NOT NULL,
  `idAgenteACargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_particular`
--

CREATE TABLE `cliente_particular` (
  `codCliente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `cuil` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente_particular`
--

INSERT INTO `cliente_particular` (`codCliente`, `nombre`, `apellido`, `fechaNacimiento`, `cuil`) VALUES
(1, 'Juan', 'Pérez', '2022-11-18', 549646);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato`
--

CREATE TABLE `contrato` (
  `id` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `codPropiedad` int(11) NOT NULL,
  `idAgente` int(11) NOT NULL,
  `codigoLocadorVendedor` int(11) NOT NULL,
  `codigoLocatorioComprador` int(11) NOT NULL,
  `esDeVenta` tinyint(1) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codCliente` int(11) NOT NULL,
  `informacion` text NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id` int(11) NOT NULL,
  `cargo` varchar(30) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `dni` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `contrasenia` varchar(32) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `telefonoAlternativo` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `cargo`, `nombre`, `apellido`, `dni`, `usuario`, `contrasenia`, `correo`, `telefono`, `telefonoAlternativo`) VALUES
(1, 'Agente inmobiliario', 'Freddie', 'Mercury', 34450334, 'agente', '81dc9bdb52d04dc20036dbd8313ed055', '0', 1134355432, NULL),
(5, 'Secretaria de comercialización', 'Brian ', 'May', 2222222, 'secretaria', '81dc9bdb52d04dc20036dbd8313ed055', 'bmay@gmail.com', 123123213, 123213213);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_actividad`
--

CREATE TABLE `estado_actividad` (
  `nomEstado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_actividad`
--

INSERT INTO `estado_actividad` (`nomEstado`) VALUES
('cancelado'),
('en proceso'),
('finalizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_propiedad`
--

CREATE TABLE `historico_propiedad` (
  `id` int(11) NOT NULL,
  `codDuenioAnterior` int(11) DEFAULT NULL,
  `codInquilinoAnterior` int(11) DEFAULT NULL,
  `codPropiedad` int(11) NOT NULL,
  `precioVentaAnterior` int(11) DEFAULT NULL,
  `precioAlquilerAnterior` int(11) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_propiedad`
--

CREATE TABLE `imagen_propiedad` (
  `id` int(11) NOT NULL,
  `codPropiedad` int(11) NOT NULL,
  `enlace` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `imagen_propiedad`
--

INSERT INTO `imagen_propiedad` (`id`, `codPropiedad`, `enlace`) VALUES
(1, 1, 'https://i0.wp.com/denorteanorte.com/wp-content/uploads/2019/07/Vicente-L%C3%B3pez-Pirillo-Gaspar-Campos-1065-.jpg?fit=4608%2C2240&ssl=1'),
(2, 1, 'https://cloudfront-us-east-1.images.arcpublishing.com/infobae/3JZBEFPYEZB5BGSG5KMKUZB53U.jpg'),
(3, 1, 'https://i.ytimg.com/vi/QNHaYeBlMtc/maxresdefault.jpg'),
(4, 2, 'https://www.chacodiapordia.com/wp-content/uploads/2018/11/ChaletRapaccioli_23-696x456.jpg\r\n'),
(5, 2, 'https://media-cdn.tripadvisor.com/media/photo-s/10/1b/98/1a/chalet-villa-perrando.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_cuenta`
--

CREATE TABLE `movimiento_cuenta` (
  `id` int(11) NOT NULL,
  `tipoCaja` varchar(8) NOT NULL,
  `concepto` varchar(30) NOT NULL,
  `monto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idCierreCaja` int(11) DEFAULT NULL,
  `codPropiedad` int(11) DEFAULT NULL,
  `codCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movimiento_cuenta`
--

INSERT INTO `movimiento_cuenta` (`id`, `tipoCaja`, `concepto`, `monto`, `fecha`, `idCierreCaja`, `codPropiedad`, `codCliente`) VALUES
(1, 'Alquiler', 'no se', 1000, '2022-11-08', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `numTransaccion` int(11) NOT NULL,
  `codCliente` int(11) NOT NULL,
  `idContrato` int(11) NOT NULL,
  `formaPago` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedad`
--

CREATE TABLE `propiedad` (
  `codPropiedad` int(11) NOT NULL,
  `codDuenio` int(11) DEFAULT NULL,
  `codInquilino` int(11) DEFAULT NULL,
  `tipo` varchar(14) NOT NULL,
  `superficie` int(11) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `localidad` varchar(50) NOT NULL,
  `barrio` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `codpostal` int(11) NOT NULL,
  `numBanios` int(11) NOT NULL,
  `numSuites` int(11) NOT NULL,
  `fechaConstruccion` date NOT NULL,
  `espacios` text NOT NULL,
  `artefactos` text NOT NULL,
  `servicios` text NOT NULL,
  `precioAlquiler` int(11) DEFAULT NULL,
  `precioVenta` int(11) DEFAULT NULL,
  `fechaRegistrada` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `propiedad`
--

INSERT INTO `propiedad` (`codPropiedad`, `codDuenio`, `codInquilino`, `tipo`, `superficie`, `pais`, `provincia`, `localidad`, `barrio`, `direccion`, `codpostal`, `numBanios`, `numSuites`, `fechaConstruccion`, `espacios`, `artefactos`, `servicios`, `precioAlquiler`, `precioVenta`, `fechaRegistrada`) VALUES
(1, NULL, NULL, 'Casa', 100, 'Argentina', 'Chaco', 'Charata', '90 Viviendas', 'Sarmiento 312', 3730, 1, 0, '1945-10-24', '', '', '', NULL, NULL, '2014-11-06'),
(2, NULL, NULL, 'Chalet', 0, 'Argentina', 'Chaco', 'Resistencia', 'Microcentro', 'Av.Sarmiento 398', 3500, 2, 5, '1924-11-25', 'Vivero', 'Piano, Guitarra, Tocadiscos', 'Museo', NULL, NULL, '2022-11-25');

--
-- Disparadores `propiedad`
--
DELIMITER $$
CREATE TRIGGER `cargar_historial_propiedad` AFTER UPDATE ON `propiedad` FOR EACH ROW BEGIN
	IF((OLD.codDuenio != NEW.codDuenio) OR (OLD.codInquilino != NEW.codInquilino) OR (OLD.precioVenta != NEW.precioVenta) OR (OLD.precioAlquiler != NEW.precioAlquiler)) THEN
		INSERT INTO historico_propiedad (codDuenioAnterior, codInquilinoAnterior, codPropiedad, precioVentaAnterior, precioAlquilerAnterior, fecha) VALUES (OLD.codDuenio, OLD.codInquilino, OLD.codPropiedad, OLD.precioVenta, OLD.precioAlquiler, NOW());
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacion_reporte_cuenta`
--

CREATE TABLE `relacion_reporte_cuenta` (
  `id` int(11) NOT NULL,
  `idMovimientoCuenta` int(11) NOT NULL,
  `idReporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `relacion_reporte_cuenta`
--

INSERT INTO `relacion_reporte_cuenta` (`id`, `idMovimientoCuenta`, `idReporte`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id` int(11) NOT NULL,
  `tipo` varchar(7) DEFAULT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reporte`
--

INSERT INTO `reporte` (`id`, `tipo`, `fechaInicio`, `fechaFin`) VALUES
(1, 'Diario', '2022-11-08', '2022-11-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_clientes`
--

CREATE TABLE `reporte_clientes` (
  `id` int(11) NOT NULL,
  `codCliente` int(11) NOT NULL,
  `idReporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_historico_propiedad`
--

CREATE TABLE `reporte_historico_propiedad` (
  `id` int(11) NOT NULL,
  `idHistoricoPropiedad` int(11) NOT NULL,
  `idReporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_pagos`
--

CREATE TABLE `reporte_pagos` (
  `id` int(11) NOT NULL,
  `numTransaccion` int(11) NOT NULL,
  `idReporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_caja`
--

CREATE TABLE `tipo_caja` (
  `nomTipo` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_caja`
--

INSERT INTO `tipo_caja` (`nomTipo`) VALUES
('Alquiler'),
('Venta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_propiedad`
--

CREATE TABLE `tipo_propiedad` (
  `nomTipo` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_propiedad`
--

INSERT INTO `tipo_propiedad` (`nomTipo`) VALUES
('Cabaña'),
('Casa'),
('Casa con local'),
('Chalet'),
('Cochera'),
('Departamento'),
('Local');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_reporte`
--

CREATE TABLE `tipo_reporte` (
  `nomTipo` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_reporte`
--

INSERT INTO `tipo_reporte` (`nomTipo`) VALUES
('Anual'),
('Diario'),
('Mensual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `numTransaccion` int(11) NOT NULL,
  `esFinanciada` tinyint(1) NOT NULL,
  `comision` float NOT NULL,
  `moneda` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idCita_2` (`idCita`),
  ADD KEY `idAgente` (`idAgente`),
  ADD KEY `idCita` (`idCita`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  ADD PRIMARY KEY (`numTransaccion`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`nomCargo`);

--
-- Indices de la tabla `cierre_caja`
--
ALTER TABLE `cierre_caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codCliente` (`codCliente`),
  ADD KEY `codPropiedad` (`codPropiedad`),
  ADD KEY `idAgente` (`idAgente`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`codCliente`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `cliente_corporativo`
--
ALTER TABLE `cliente_corporativo`
  ADD PRIMARY KEY (`codCliente`),
  ADD UNIQUE KEY `cuit` (`cuit`),
  ADD KEY `idAgenteACargo` (`idAgenteACargo`);

--
-- Indices de la tabla `cliente_particular`
--
ALTER TABLE `cliente_particular`
  ADD PRIMARY KEY (`codCliente`),
  ADD UNIQUE KEY `cuil` (`cuil`);

--
-- Indices de la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codigoLocadorVendedor` (`codigoLocadorVendedor`),
  ADD KEY `codigoLocatorioComprador` (`codigoLocatorioComprador`),
  ADD KEY `codPropiedad` (`codPropiedad`),
  ADD KEY `idAgente` (`idAgente`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codCliente` (`codCliente`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `cargo` (`cargo`);

--
-- Indices de la tabla `estado_actividad`
--
ALTER TABLE `estado_actividad`
  ADD PRIMARY KEY (`nomEstado`);

--
-- Indices de la tabla `historico_propiedad`
--
ALTER TABLE `historico_propiedad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codDuenioAnterior` (`codDuenioAnterior`),
  ADD KEY `codPropiedad` (`codPropiedad`),
  ADD KEY `codInquilinoAnterior` (`codInquilinoAnterior`);

--
-- Indices de la tabla `imagen_propiedad`
--
ALTER TABLE `imagen_propiedad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codPropiedad` (`codPropiedad`);

--
-- Indices de la tabla `movimiento_cuenta`
--
ALTER TABLE `movimiento_cuenta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codCliente` (`codCliente`),
  ADD KEY `codPropiedad` (`codPropiedad`),
  ADD KEY `idCierreCaja` (`idCierreCaja`),
  ADD KEY `tipoCaja` (`tipoCaja`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`numTransaccion`),
  ADD KEY `codCliente` (`codCliente`),
  ADD KEY `idContrato` (`idContrato`);

--
-- Indices de la tabla `propiedad`
--
ALTER TABLE `propiedad`
  ADD PRIMARY KEY (`codPropiedad`),
  ADD KEY `codDuenio` (`codDuenio`),
  ADD KEY `propiedad_ibfk_3` (`codInquilino`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `relacion_reporte_cuenta`
--
ALTER TABLE `relacion_reporte_cuenta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMovimientoCuenta` (`idMovimientoCuenta`),
  ADD KEY `idReporte` (`idReporte`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `reporte_clientes`
--
ALTER TABLE `reporte_clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codCliente` (`codCliente`),
  ADD KEY `idReporte` (`idReporte`);

--
-- Indices de la tabla `reporte_historico_propiedad`
--
ALTER TABLE `reporte_historico_propiedad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idHistoricoPropiedad` (`idHistoricoPropiedad`),
  ADD KEY `idReporte` (`idReporte`);

--
-- Indices de la tabla `reporte_pagos`
--
ALTER TABLE `reporte_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `numTransaccion` (`numTransaccion`);

--
-- Indices de la tabla `tipo_caja`
--
ALTER TABLE `tipo_caja`
  ADD PRIMARY KEY (`nomTipo`);

--
-- Indices de la tabla `tipo_propiedad`
--
ALTER TABLE `tipo_propiedad`
  ADD PRIMARY KEY (`nomTipo`);

--
-- Indices de la tabla `tipo_reporte`
--
ALTER TABLE `tipo_reporte`
  ADD PRIMARY KEY (`nomTipo`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`numTransaccion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  MODIFY `numTransaccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cierre_caja`
--
ALTER TABLE `cierre_caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `codCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cliente_corporativo`
--
ALTER TABLE `cliente_corporativo`
  MODIFY `codCliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente_particular`
--
ALTER TABLE `cliente_particular`
  MODIFY `codCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contrato`
--
ALTER TABLE `contrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `historico_propiedad`
--
ALTER TABLE `historico_propiedad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen_propiedad`
--
ALTER TABLE `imagen_propiedad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `movimiento_cuenta`
--
ALTER TABLE `movimiento_cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `numTransaccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `propiedad`
--
ALTER TABLE `propiedad`
  MODIFY `codPropiedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `relacion_reporte_cuenta`
--
ALTER TABLE `relacion_reporte_cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `reporte_clientes`
--
ALTER TABLE `reporte_clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_historico_propiedad`
--
ALTER TABLE `reporte_historico_propiedad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_pagos`
--
ALTER TABLE `reporte_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `numTransaccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`idAgente`) REFERENCES `empleado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agenda_ibfk_2` FOREIGN KEY (`idCita`) REFERENCES `cita` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agenda_ibfk_3` FOREIGN KEY (`estado`) REFERENCES `estado_actividad` (`nomEstado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alquiler`
--
ALTER TABLE `alquiler`
  ADD CONSTRAINT `alquiler_ibfk_1` FOREIGN KEY (`numTransaccion`) REFERENCES `pago` (`numTransaccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`codCliente`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`codPropiedad`) REFERENCES `propiedad` (`codPropiedad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`idAgente`) REFERENCES `empleado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente_corporativo`
--
ALTER TABLE `cliente_corporativo`
  ADD CONSTRAINT `cliente_corporativo_ibfk_1` FOREIGN KEY (`codCliente`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cliente_corporativo_ibfk_2` FOREIGN KEY (`idAgenteACargo`) REFERENCES `empleado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente_particular`
--
ALTER TABLE `cliente_particular`
  ADD CONSTRAINT `cliente_particular_ibfk_1` FOREIGN KEY (`codCliente`) REFERENCES `cliente` (`codCliente`);

--
-- Filtros para la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD CONSTRAINT `contrato_ibfk_1` FOREIGN KEY (`codigoLocadorVendedor`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contrato_ibfk_2` FOREIGN KEY (`codigoLocatorioComprador`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contrato_ibfk_3` FOREIGN KEY (`codPropiedad`) REFERENCES `propiedad` (`codPropiedad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contrato_ibfk_4` FOREIGN KEY (`idAgente`) REFERENCES `empleado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`codCliente`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`cargo`) REFERENCES `cargo` (`nomCargo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_propiedad`
--
ALTER TABLE `historico_propiedad`
  ADD CONSTRAINT `historico_propiedad_ibfk_1` FOREIGN KEY (`codDuenioAnterior`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_propiedad_ibfk_2` FOREIGN KEY (`codPropiedad`) REFERENCES `propiedad` (`codPropiedad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_propiedad_ibfk_3` FOREIGN KEY (`codInquilinoAnterior`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagen_propiedad`
--
ALTER TABLE `imagen_propiedad`
  ADD CONSTRAINT `imagen_propiedad_ibfk_1` FOREIGN KEY (`codPropiedad`) REFERENCES `propiedad` (`codPropiedad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movimiento_cuenta`
--
ALTER TABLE `movimiento_cuenta`
  ADD CONSTRAINT `movimiento_cuenta_ibfk_1` FOREIGN KEY (`codCliente`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimiento_cuenta_ibfk_2` FOREIGN KEY (`codPropiedad`) REFERENCES `propiedad` (`codPropiedad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimiento_cuenta_ibfk_3` FOREIGN KEY (`idCierreCaja`) REFERENCES `cierre_caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimiento_cuenta_ibfk_4` FOREIGN KEY (`tipoCaja`) REFERENCES `tipo_caja` (`nomTipo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`codCliente`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contrato` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `propiedad`
--
ALTER TABLE `propiedad`
  ADD CONSTRAINT `propiedad_ibfk_1` FOREIGN KEY (`codDuenio`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `propiedad_ibfk_3` FOREIGN KEY (`codInquilino`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `propiedad_ibfk_4` FOREIGN KEY (`tipo`) REFERENCES `tipo_propiedad` (`nomTipo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `relacion_reporte_cuenta`
--
ALTER TABLE `relacion_reporte_cuenta`
  ADD CONSTRAINT `relacion_reporte_cuenta_ibfk_1` FOREIGN KEY (`idMovimientoCuenta`) REFERENCES `movimiento_cuenta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relacion_reporte_cuenta_ibfk_2` FOREIGN KEY (`idReporte`) REFERENCES `reporte` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `reporte_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipo_reporte` (`nomTipo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reporte_clientes`
--
ALTER TABLE `reporte_clientes`
  ADD CONSTRAINT `reporte_clientes_ibfk_1` FOREIGN KEY (`codCliente`) REFERENCES `cliente` (`codCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_clientes_ibfk_2` FOREIGN KEY (`idReporte`) REFERENCES `reporte` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reporte_historico_propiedad`
--
ALTER TABLE `reporte_historico_propiedad`
  ADD CONSTRAINT `reporte_historico_propiedad_ibfk_1` FOREIGN KEY (`idHistoricoPropiedad`) REFERENCES `historico_propiedad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_historico_propiedad_ibfk_2` FOREIGN KEY (`idReporte`) REFERENCES `reporte` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reporte_pagos`
--
ALTER TABLE `reporte_pagos`
  ADD CONSTRAINT `reporte_pagos_ibfk_1` FOREIGN KEY (`numTransaccion`) REFERENCES `pago` (`numTransaccion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_pagos_ibfk_2` FOREIGN KEY (`numTransaccion`) REFERENCES `pago` (`numTransaccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`numTransaccion`) REFERENCES `pago` (`numTransaccion`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
