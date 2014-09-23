SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `Joanie` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `Joanie` ;

-- -----------------------------------------------------
-- Table `Joanie`.`Order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Order` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `customer_last_name` VARCHAR(255) NOT NULL,
  `customer_first_name` VARCHAR(255) NOT NULL,
  `customer_email` VARCHAR(255) NOT NULL,
  `customer_contact_number` INT NOT NULL,
  `details` VARCHAR(255) NOT NULL,
  `price` DOUBLE NOT NULL DEFAULT 0.0,
  `status` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE INDEX `OrderID_UNIQUE` (`order_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`Report`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Report` (
  `report_id` INT NOT NULL AUTO_INCREMENT,
  `date_from` DATE NOT NULL,
  `date_to` DATE NOT NULL,
  `net_profit` DOUBLE NOT NULL,
  PRIMARY KEY (`report_id`),
  UNIQUE INDEX `report_id_UNIQUE` (`report_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`Payment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Payment` (
  `payment_id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `price` DOUBLE NOT NULL,
  `order_id` INT NOT NULL,
  `report_id` INT NOT NULL,
  `Order_order_id` INT NOT NULL,
  `Report_report_id` INT NOT NULL,
  PRIMARY KEY (`payment_id`, `Order_order_id`, `Report_report_id`),
  UNIQUE INDEX `payment_id_UNIQUE` (`payment_id` ASC),
  INDEX `fk_Payment_Order_idx` (`Order_order_id` ASC),
  INDEX `fk_Payment_Report1_idx` (`Report_report_id` ASC),
  CONSTRAINT `fk_Payment_Order`
    FOREIGN KEY (`Order_order_id`)
    REFERENCES `Joanie`.`Order` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Payment_Report1`
    FOREIGN KEY (`Report_report_id`)
    REFERENCES `Joanie`.`Report` (`report_id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`Employee`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Employee` (
  `employee_id` INT NOT NULL AUTO_INCREMENT,
  `last_name` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  `job_title` VARCHAR(255) NOT NULL,
  `job_description` VARCHAR(255) NOT NULL,
  `salary` DOUBLE NOT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE INDEX `employee_id_UNIQUE` (`employee_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`SalaryExpense`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`SalaryExpense` (
  `salary_expense_id` INT NOT NULL AUTO_INCREMENT,
  `date_from` DATE NOT NULL,
  `date_to` DATE NOT NULL,
  `total_salary` DOUBLE NOT NULL,
  `employee_id` INT NOT NULL,
  `Report_report_id` INT NOT NULL,
  PRIMARY KEY (`salary_expense_id`, `Report_report_id`),
  UNIQUE INDEX `salary_expense_id_UNIQUE` (`salary_expense_id` ASC),
  INDEX `fk_SalaryExpense_Report1_idx` (`Report_report_id` ASC),
  CONSTRAINT `fk_SalaryExpense_Report1`
    FOREIGN KEY (`Report_report_id`)
    REFERENCES `Joanie`.`Report` (`report_id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`Attendance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Attendance` (
  `attendance_id` INT NOT NULL,
  `date` DATE NOT NULL,
  `time_in` TIME NOT NULL,
  `time_out` TIME NOT NULL,
  `employee_id` INT NOT NULL,
  `salary_expense_id` INT NOT NULL,
  `SalaryExpense_salary_expense_id` INT NOT NULL,
  `SalaryExpense_Report_report_id` INT NOT NULL,
  `Employee_employee_id` INT NOT NULL,
  PRIMARY KEY (`attendance_id`, `SalaryExpense_salary_expense_id`, `SalaryExpense_Report_report_id`, `Employee_employee_id`),
  INDEX `fk_Attendance_SalaryExpense1_idx` (`SalaryExpense_salary_expense_id` ASC, `SalaryExpense_Report_report_id` ASC),
  INDEX `fk_Attendance_Employee1_idx` (`Employee_employee_id` ASC),
  CONSTRAINT `fk_Attendance_SalaryExpense1`
    FOREIGN KEY (`SalaryExpense_salary_expense_id` , `SalaryExpense_Report_report_id`)
    REFERENCES `Joanie`.`SalaryExpense` (`salary_expense_id` , `Report_report_id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Attendance_Employee1`
    FOREIGN KEY (`Employee_employee_id`)
    REFERENCES `Joanie`.`Employee` (`employee_id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Joanie`.`Expense`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Joanie`.`Expense` (
  `expense_id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `price` DOUBLE NOT NULL,
  `details` VARCHAR(255) NOT NULL,
  `report_id` INT NOT NULL,
  `Report_report_id` INT NOT NULL,
  PRIMARY KEY (`expense_id`, `Report_report_id`),
  UNIQUE INDEX `expense_id_UNIQUE` (`expense_id` ASC),
  INDEX `fk_Expense_Report1_idx` (`Report_report_id` ASC),
  CONSTRAINT `fk_Expense_Report1`
    FOREIGN KEY (`Report_report_id`)
    REFERENCES `Joanie`.`Report` (`report_id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
