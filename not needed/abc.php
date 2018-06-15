<?php


 echo"jhasdjhadshgasd";



 INSERT INTO borrower (borrow_id, ssn, first_name,last_name,email,address,city,state,phone)
VALUES ('1002'
,'12345678912'
,'asdasd'
,'asdasd'
,'asdasd'
,'asdasd'
,'dallas'
,'tx'
,'123456789');

?>
select * from borrower where borrow_id=(select max(borrow_id) from borrower);


 select ssn from borrower where ssn='ss';//  $sql="INSERT INTO borrower (borrow_id, ssn, first_name,last_name,email,address,city,state,phone)
// VALUES ('1005'
// ,'12345678913'
// ,'nffff'
// ,'asdasd'
// ,'asdasd'
// ,'asdasd'
// ,'dallas'
// ,'tx'
// ,'123456789');";



$sql="insert into book_loans (ISBN13,borrow_id,date_out,due_date,date_in) values (9780060154561,1,'2018-02-02','2018-02-16','2018-02-20');


UPDATE book_loans
SET date_in ='2018-01-01'
WHERE isbn13 = 9780002215817;


insert into fines (fine_amt)
select datediff(day,day_in,due_date)
from book_loans;


SELECT
    *,
    DATEDIFF(date_in, due_date) as diff
FROM book_loans;


ALTER TABLE book_loans
ADD DATE_DIFFS AS DATEDIFF(DAY, date_in , due_date);