-- Create Database if it doesn't exist
CREATE DATABASE IF NOT EXISTS admin_dashboard;
USE admin_dashboard;

-- Create `admins` table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Create `events` table with venue column
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    venue VARCHAR(255) NOT NULL,  -- Added venue column
    description TEXT
);


-- Create `users` table for students with additional columns
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255),
    last_name VARCHAR(255) NOT NULL,
    contact_no VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    confirm_password VARCHAR(255) NOT NULL
);

ALTER TABLE events ADD COLUMN status ENUM('Open', 'Close') NOT NULL DEFAULT 'Close';

-- Add registrars table to store assignments
CREATE TABLE IF NOT EXISTS registrars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    student_id INT NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(id),
    FOREIGN KEY (student_id) REFERENCES users(id)
);


CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    contact_no VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    attendance_status ENUM('Waiting', 'Present') NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);


-- Insert default admin credentials
INSERT INTO admins (username, password) 
VALUES ('rony', SHA2('rony123', 256));

-- Insert default user (student) credentials (example student)
INSERT INTO users (first_name, middle_name, last_name, contact_no, address, email, password, confirm_password)
VALUES 
('Rohan', 'Kumar', 'Sharma', '1234567890', '123 Street, City', 'rohan@gmail.com', SHA2('rohan123', 256), SHA2('rohan123', 256));
