DROP TABLE Address;
DROP TABLE Rep;
DROP TABLE Manager;
DROP TABLE Inventory;
DROP TABLE CustomerAccount;

CREATE TABLE CustomerAccount( 
AccountNumber INTEGER AUTO_INCREMENT NOT NULL, 
CompanyName VARCHAR(99) NOT NULL, 
QuoteType VARCHAR(20) NOT NULL, 
PRIMARY KEY(AccountNumber));

CREATE TABLE Address( 
AddressID INTEGER NOT NULL AUTO_INCREMENT,
AccountNumber INTEGER NOT NULL,
Street VARCHAR(50) NOT NULL, 
City VARCHAR(20) NOT NULL, 
State VARCHAR(3) NOT NULL, 
Zip INTEGER NOT NULL, 
PRIMARY KEY(AddressID),
FOREIGN KEY(AccountNumber) REFERENCES CustomerAccount(AccountNumber));

CREATE TABLE Rep( 
RepID INTEGER NOT NULL AUTO_INCREMENT, 
FirstName VARCHAR(20) NOT NULL, 
LastName VARCHAR(20) NOT NULL, 
Email VARCHAR(30) NOT NULL,  
Phone VARCHAR(14) NOT NULL, 
AccountNumber INTEGER NOT NULL, 
PRIMARY KEY(RepID), 
FOREIGN KEY(AccountNumber) REFERENCES CustomerAccount(AccountNumber));

CREATE TABLE Manager( 
ManagerID INTEGER NOT NULL AUTO_INCREMENT, 
FirstName VARCHAR(90) NOT NULL, 
LastName VARCHAR(90) NOT NULL,  
Email VARCHAR(40) NOT NULL, 
Phone VARCHAR(14) NOT NULL, 
PRIMARY KEY(ManagerID));

CREATE TABLE Inventory( 
PartID INTEGER AUTO_INCREMENT NOT NULL, 
Name VARCHAR(90) NOT NULL, 
Price FLOAT(6,2) NOT NULL, 
Quantity INTEGER NOT NULL, 
Description TEXT, 
Manufacturer VARCHAR(90) NOT NULL, 
Comments TEXT, 
PRIMARY KEY(PartID));



