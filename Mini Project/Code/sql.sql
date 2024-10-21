-- Create the Customers Table
CREATE TABLE Customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15) NOT NULL,
    address VARCHAR(255),
    date_of_birth DATE,
    account_status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Insert sample data into the Customers Table
INSERT INTO Customers (first_name, last_name, email, phone_number, address, date_of_birth, account_status)
VALUES
    ('John', 'Doe', 'john.doe@example.com', '1234567890', '123 Main St', '1990-01-15', 'active'),
    ('Jane', 'Smith', 'jane.smith@example.com', '0987654321', '456 Oak St', '1985-07-22', 'active');

-- Create the Accounts Table
CREATE TABLE Accounts (
    account_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    account_type ENUM('checking', 'savings') NOT NULL,
    account_number VARCHAR(20) UNIQUE NOT NULL,
    balance DECIMAL(15,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active',
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE
);

-- Insert sample data into the Accounts Table
INSERT INTO Accounts (customer_id, account_type, account_number, balance, status)
VALUES
    (1, 'checking', 'CHK123456789', 1000.00, 'active'),
    (1, 'savings', 'SAV987654321', 2500.00, 'active'),
    (2, 'checking', 'CHK112233445', 500.00, 'active');

-- Create the Transactions Table
CREATE TABLE Transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT,
    from_account_id INT,
    to_account_id INT,
    transaction_type ENUM('debit', 'credit', 'transfer') NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(255),
    balance_before DECIMAL(15,2),
    balance_after DECIMAL(15,2),
    transfer_reference_id VARCHAR(50),
    FOREIGN KEY (account_id) REFERENCES Accounts(account_id) ON DELETE CASCADE,
    FOREIGN KEY (from_account_id) REFERENCES Accounts(account_id),
    FOREIGN KEY (to_account_id) REFERENCES Accounts(account_id)
);

-- Insert sample data into the Transactions Table
INSERT INTO Transactions (account_id, transaction_type, amount, description, balance_before, balance_after)
VALUES
    (1, 'debit', 100.00, 'ATM Withdrawal', 1000.00, 900.00),
    (1, 'credit', 200.00, 'Salary Deposit', 900.00, 1100.00),
    (2, 'debit', 50.00, 'Grocery Payment', 2500.00, 2450.00);

-- Create the User Authentication Table
CREATE TABLE UserAuth (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE
);

-- Insert sample data into the User Authentication Table
INSERT INTO UserAuth (customer_id, username, password_hash)
VALUES
    (1, 'johndoe', 'hashed_password_1'),
    (2, 'janesmith', 'hashed_password_2');
