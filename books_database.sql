DROP DATABASE books;
CREATE DATABASE books;
USE books;
DROP TABLE IF EXISTS main;
CREATE TABLE main (
    ISBN10 VARCHAR(10) NOT NULL,
    ISBN13 VARCHAR(13) NOT NULL,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    cover VARCHAR(255),
    publisher VARCHAR(255),
    pages INT(4),
    PRIMARY KEY (ISBN10)
);

LOAD DATA LOCAL INFILE 'F:\\college masters\\database design\\prog assgn-1\\book.csv' 
INTO TABLE main 
FIELDS TERMINATED BY '\t'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

DROP table IF EXISTS book;
create table book as (select ISBN10,ISBN13,title from main);

ALTER TABLE book
  ADD CONSTRAINT isbn_pk 
    PRIMARY KEY (ISBN13);
    ALTER TABLE




DROP TABLE IF EXISTS borrower;
CREATE TABLE borrower (
    borrow_id INT(6) NOT NULL,
    ssn VARCHAR(11) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255),
    email VARCHAR(255),
    address VARCHAR(255),
    city VARCHAR(255),
    state VARCHAR(255),
    phone VARCHAR(255),
    PRIMARY KEY (borrow_id)
);

LOAD DATA LOCAL INFILE 'F:\\college masters\\database design\\prog assgn-1\\borrowers.csv' 
INTO TABLE borrower 
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

DROP TABLE IF EXISTS author1;
CREATE TABLE author1  as (select ISBN10,ISBN13,author from main);

DROP TABLE IF EXISTS author;
create table author as (SELECT
  author1.ISBN10,author1.ISBN13,
  SUBSTRING_INDEX(SUBSTRING_INDEX(author1.author, ',', numbers.n), ',', -1) name
FROM
  (SELECT 1 n UNION ALL SELECT 2
   UNION ALL SELECT 3 UNION ALL SELECT 4) numbers INNER JOIN author1
  ON CHAR_LENGTH(author1.author)
     -CHAR_LENGTH(REPLACE(author1.author, ',', ''))>=numbers.n-1
ORDER BY
  ISBN10, n);


  ALTER TABLE author ADD author_id MEDIUMINT NOT NULL AUTO_INCREMENT KEY;
DROP TABLE IF EXISTS author1;

DROP TABLE IF EXISTS book_authors;
  CREATE TABLE book_authors as (select author_id,ISBN10,ISBN13 from author); 

    DROP TABLE IF EXISTS authors;
  CREATE TABLE authors as (select author_id,name from author); 

  ALTER TABLE authors
  ADD CONSTRAINT author_pk 
    PRIMARY KEY (author_id);


  ALTER TABLE book_authors
ADD CONSTRAINT author_fk
FOREIGN KEY (author_id) REFERENCES authors(author_id);

  ALTER TABLE book_authors
ADD CONSTRAINT isbn_fk
FOREIGN KEY (ISBN13) REFERENCES book(ISBN13);

DROP TABLE IF EXISTS book_loans;
CREATE TABLE book_loans(
	loan_id INT(4) NOT NULL AUTO_INCREMENT,
	 ISBN13 VARCHAR(13) NOT NULL,
	 borrow_id INT(6) NOT NULL,
	date_out date,
	due_date date,
	date_in date,
	PRIMARY KEY (loan_id),
	FOREIGN KEY (ISBN13) REFERENCES book(ISBN13),
	FOREIGN KEY (borrow_id) REFERENCES borrower(borrow_id)
	);

DROP TABLE IF EXISTS fines;
CREATE TABLE fines(
loan_id INT(4) NOT NULL PRIMARY KEY,
fine_amt FLOAT(4),
paid varchar(1),
FOREIGN KEY (loan_id) REFERENCES book_loans(loan_id));

ALTER TABLE book
ADD available bit;


update book set available=1;



CREATE VIEW BOOKS_VIEW as 
SELECT book.ISBN13 as ISBN13,book.ISBN10 as ISBN10, book.title as title, GROUP_CONCAT(authors.name separator ', ') as authors, book.available as available
FROM book 
JOIN book_authors ON book.ISBN13=book_authors.ISBN13
JOIN authors ON book_authors.Author_ID=authors.Author_ID
LEFT JOIN book_loans ON book.ISBN13=book_loans.ISBN13
GROUP BY book.ISBN13;
