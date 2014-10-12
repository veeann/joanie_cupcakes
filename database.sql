drop database joanie;

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `Joanie` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `Joanie` ;

-- -----------------------------------------------------
-- Table `Joanie`.`Order_t`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Order_t` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `order_date` DATETIME NOT NULL,
  `customer_last_name` VARCHAR(255) NOT NULL,
  `customer_first_name` VARCHAR(255) NOT NULL,
  `customer_email` VARCHAR(255) NOT NULL,
  `customer_contact_number` VARCHAR(13) NOT NULL,
  `details` VARCHAR(255) NOT NULL,
  `price` DOUBLE NOT NULL DEFAULT 0.0,
  `status` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE INDEX `OrderID_UNIQUE` (`order_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`Report_t`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Report_t` (
  `report_id` INT NOT NULL AUTO_INCREMENT,
  `date_from` DATE NOT NULL,
  `date_to` DATE NOT NULL,
  `gross_income` DOUBLE NOT NULL,
  `total_expenses` DOUBLE NOT NULL,
  `net_income` DOUBLE NOT NULL,
  PRIMARY KEY (`report_id`),
  UNIQUE INDEX `report_id_UNIQUE` (`report_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`Payment_t`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Payment_t` (
  `payment_id` INT NOT NULL AUTO_INCREMENT,
  `pay_date` DATE NOT NULL,
  `price` DOUBLE NOT NULL,
  `order_id` INT NOT NULL,
  PRIMARY KEY (`payment_id`, `order_id`),
  UNIQUE INDEX `payment_id_UNIQUE` (`payment_id` ASC),
  INDEX `fk_Payment_Order_idx` (`order_id` ASC),
  CONSTRAINT `fk_Payment_Order`
    FOREIGN KEY (`order_id`)
    REFERENCES `Joanie`.`Order_t` (`order_id`)
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`Employee_t`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Employee_t` (
  `employee_id` INT NOT NULL AUTO_INCREMENT,
  `last_name` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  `job_title` VARCHAR(255) NOT NULL,
  `job_description` VARCHAR(255) NOT NULL,
  `salary` DOUBLE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE INDEX `employee_id_UNIQUE` (`employee_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`SalaryExpense_t`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`SalaryExpense_t` (
  `salary_expense_id` INT NOT NULL AUTO_INCREMENT,
  `date_from` DATE NOT NULL,
  `date_to` DATE NOT NULL,
  `total_salary` DOUBLE NOT NULL,
  PRIMARY KEY (`salary_expense_id`),
  UNIQUE INDEX `salary_expense_id_UNIQUE` (`salary_expense_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`Attendance_t`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Attendance_t` (
  `attendance_id` INT NOT NULL AUTO_INCREMENT,
  `signed_date` DATE NOT NULL,
  `time_in` TIME NOT NULL,
  `time_out` TIME NOT NULL,
  `employee_id` INT NOT NULL,
  PRIMARY KEY (`attendance_id`, `employee_id`),
  INDEX `fk_Attendance_Employee1_idx` (`employee_id` ASC),
  CONSTRAINT `fk_Attendance_Employee1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `Joanie`.`Employee_t` (`employee_id`)
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`Expense_t`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Expense_t` (
  `expense_id` INT NOT NULL AUTO_INCREMENT,
  `expense_date` DATE NOT NULL,
  `price` DOUBLE NOT NULL,
  `details` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`expense_id`),
  UNIQUE INDEX `expense_id_UNIQUE` (`expense_id` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
