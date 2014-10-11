INSERT INTO Order_t
VALUES (1, '2014-09-20', 'Yuen', 'WehSing', 'singsing@tinker.com', 09170000001, 'Mocha-frosted cake and with mint sprinkles', 0, 'Rejected');

INSERT INTO Order_t
VALUES (2, '2014-09-21', 'Sundstein', 'Johan', 'n0tail@secret.com', 09170000002, 'Tofu cake, bitter', 2000, 'Finished');

INSERT INTO Order_t
VALUES (3, '2014-09-22', 'Ivanov', 'Clement', 'puppey@secret.com', 09170000003, 'One dozen banana-nut muffins with chocolate fudge', 1500, 'Processing');

INSERT INTO Order_t
VALUES (4, '2014-09-23', 'Taksahomi', 'Kuro', 'kuroky@secret.com', 09170000004, 'Extra large carrot cake, sugarfree', 3000, 'Priced');

INSERT INTO Order_t
VALUES (5, '2014-09-24', 'Lille', 'Anders', 'pajkatt@tinker.com', 09170000005, 'Lemon squares with extra lemon seeds', 0, 'Placed');

INSERT INTO Order_t
VALUES (6, '2014-09-25', 'Ling', 'Kurtis', 'aui2000@cloud9.com', 09170000006, 'Half dozen red velvet cupcake with extra cream cheese frosting', 0, 'Cancelled');

-- -------------------------------------------------------------------------

INSERT INTO Report_t
VALUES (1, '2014-09-20', '2014-09-25', 6500 );

-- -------------------------------------------------------------------------

INSERT INTO Employee_t
VALUES (1, 'Dawson', 'Toby', 'Administrator', 'Deploys the banhammer mercilessly unto unruly subjects', 50.00, 'crazy' );

INSERT INTO Employee_t
VALUES (2, 'Possible', 'Kim', 'Employee', 'Cashier and all that shizz', 20.00, 'hello' );

-- -------------------------------------------------------------------------

INSERT INTO SalaryExpense_t
VALUES (1, '2014-09-16', '2014-09-30', 2700);

-- -------------------------------------------------------------------------

INSERT INTO Expense_t
VALUES (1, '2014-09-25', 2300, 'Rent');

-- -------------------------------------------------------------------------

INSERT INTO Payment_t
VALUES (1, '2014-09-21', 20.00, 2);

INSERT INTO Payment_t
VALUES (2, '2014-09-22', 15.00, 3);

INSERT INTO Payment_t
VALUES (3, '2014-09-23', 30.00, 4);

-- -------------------------------------------------------------------------

INSERT INTO Attendance_t
VALUES (1, '2014-09-20', '9:00', '18:00', 1);

INSERT INTO Attendance_t
VALUES (2, '2014-09-21', '9:00', '18:00', 1);

INSERT INTO Attendance_t
VALUES (3, '2014-09-22', '9:00', '18:00', 1);

INSERT INTO Attendance_t
VALUES (4, '2014-09-23', '9:00', '18:00', 1);

INSERT INTO Attendance_t
VALUES (5, '2014-09-24', '9:00', '18:00', 1);

INSERT INTO Attendance_t
VALUES (6, '2014-09-25', '9:00', '18:00', 1);

