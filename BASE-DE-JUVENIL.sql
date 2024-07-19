-- MySQL Workbench Synchronization
-- Generated: 2024-07-18 20:31
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: v3ct0r

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `juvenil2024` DEFAULT CHARACTER SET utf8mb4 ;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`cargo` (
  `id_cargo` INT(11) NOT NULL AUTO_INCREMENT,
  `cargo` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_cargo`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`cliente` (
  `id_cliente` INT(11) NOT NULL AUTO_INCREMENT,
  `razonsocial` VARCHAR(255) NOT NULL,
  `documento` VARCHAR(31) NOT NULL,
  `documento_tipo` ENUM('CI', 'NIT') NOT NULL,
  `estado` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_cliente`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`compra` (
  `id_compra` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `id_empleado` INT(11) NOT NULL,
  PRIMARY KEY (`id_compra`),
  INDEX `id_empleado` (`id_empleado` ASC),
  CONSTRAINT `compra_ibfk_1`
    FOREIGN KEY (`id_empleado`)
    REFERENCES `juvenil2024`.`empleado` (`id_empleado`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`detalle_compra` (
  `cantidadcompra` INT(11) NOT NULL,
  `costocompra` DECIMAL(12,0) NOT NULL,
  `id_producto` INT(11) NOT NULL,
  `id_compra` INT(11) NOT NULL,
  INDEX `id_producto` (`id_producto` ASC),
  INDEX `fk_detalle_compra_compra1_idx` (`id_compra` ASC),
  CONSTRAINT `detalle_compra_ibfk_1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `juvenil2024`.`producto` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_detalle_compra_compra1`
    FOREIGN KEY (`id_compra`)
    REFERENCES `juvenil2024`.`compra` (`id_compra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`detalle_venta` (
  `cantidadcompra` INT(11) NOT NULL,
  `costocompra` DECIMAL(12,0) NOT NULL,
  `id_venta` INT(11) NOT NULL,
  `id_producto` INT(11) NOT NULL,
  INDEX `id_venta` (`id_venta` ASC),
  INDEX `id_producto` (`id_producto` ASC),
  CONSTRAINT `detalle_venta_ibfk_1`
    FOREIGN KEY (`id_venta`)
    REFERENCES `juvenil2024`.`venta` (`id_venta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `detalle_venta_ibfk_2`
    FOREIGN KEY (`id_producto`)
    REFERENCES `juvenil2024`.`producto` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`empleado` (
  `id_empleado` INT(11) NOT NULL AUTO_INCREMENT,
  `ci` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `paterno` VARCHAR(255) NOT NULL,
  `materno` VARCHAR(255) NOT NULL,
  `direccion` VARCHAR(255) NOT NULL,
  `telefono` INT(11) NOT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `genero` CHAR(2) NOT NULL,
  `intereses` VARCHAR(120) NOT NULL,
  `id_cargo` INT(11) NOT NULL,
  PRIMARY KEY (`id_empleado`),
  INDEX `id_cargo` (`id_cargo` ASC),
  CONSTRAINT `empleado_ibfk_1`
    FOREIGN KEY (`id_cargo`)
    REFERENCES `juvenil2024`.`cargo` (`id_cargo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`producto` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombreproducto` VARCHAR(255) NOT NULL,
  `descripcion` VARCHAR(255) NOT NULL,
  `estado` VARCHAR(255) NOT NULL,
  `precio` DECIMAL(12,0) NOT NULL,
  `stock` INT(11) NOT NULL,
  `tipo` VARCHAR(255) NOT NULL,
  `imagen` VARCHAR(255) NOT NULL,
  `id_proveedor` INT(11) NOT NULL,
  `caracteristicas` JSON NULL,
  `id_categorias` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `id_proveedor` (`id_proveedor` ASC),
  INDEX `fk_producto_categorias1_idx` (`id_categorias` ASC),
  CONSTRAINT `producto_ibfk_1`
    FOREIGN KEY (`id_proveedor`)
    REFERENCES `juvenil2024`.`proveedor` (`id_proveedor`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_producto_categorias1`
    FOREIGN KEY (`id_categorias`)
    REFERENCES `juvenil2024`.`categorias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`proveedor` (
  `id_proveedor` INT(11) NOT NULL AUTO_INCREMENT,
  `empresa` VARCHAR(255) NOT NULL,
  `contacto` VARCHAR(255) NOT NULL,
  `correo` VARCHAR(255) NOT NULL,
  `telefono` INT(11) NOT NULL,
  `direccion` VARCHAR(255) NOT NULL,
  `logo` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_proveedor`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`usuario` (
  `id_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `id_empleado` INT(11) NOT NULL,
  `pasword` VARCHAR(255) NOT NULL,
  `nivel` VARCHAR(255) NOT NULL,
  `estado` VARCHAR(255) NOT NULL,
  `usuario` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`venta` (
  `id_venta` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `id_empleado` INT(11) NOT NULL,
  `id_cliente` INT(11) NOT NULL,
  PRIMARY KEY (`id_venta`),
  INDEX `id_empleado` (`id_empleado` ASC),
  INDEX `id_cliente` (`id_cliente` ASC),
  CONSTRAINT `venta_ibfk_1`
    FOREIGN KEY (`id_empleado`)
    REFERENCES `juvenil2024`.`empleado` (`id_empleado`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `venta_ibfk_2`
    FOREIGN KEY (`id_cliente`)
    REFERENCES `juvenil2024`.`cliente` (`id_cliente`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `juvenil2024`.`categorias` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(31) NOT NULL,
  `plantilla_caracteristicas` JSON NOT NULL,
  `html_card` TEXT NULL DEFAULT NULL,
  `html_body` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `titulo_UNIQUE` (`titulo` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
