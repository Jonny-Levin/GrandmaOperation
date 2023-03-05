--@block
CREATE TABLE results (
    id INT PRIMARY KEY AUTO_INCREMENT,
    Result INT NOT NULL,
    Date DATETIME NOT NULL
);

--@block
DROP TABLE results;

--@block
DELETE FROM results Where id=4
--@block
INSERT INTO results (Result, Date) 
VALUES (10000, '2000-01-01 12:12:12');

--@block
SELECT * FROM results;

--@block
SELECT database();

--@block
SELECT @hostname;

--@block
SELECT Result, Date FROM results ORDER BY Date ASC