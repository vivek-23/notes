ALTER TABLE table_name AUTO_INCREMENT = 1 allows the database to reset the AUTO_INCREMENT to:

MAX(auto_increment_column)+1

It does not reset it to 1.

This prevents any duplication of AUTO_INCREMENT values. Also, since AUTO_INCREMENT values are either primary/unique, 
duplication would never happen anyway. The method to do this is available for a reason. It will not alter any database records; 
simply the internal counter so that it points to the max value available. As stated earlier by someone, don't try to outsmart the database... 
just let it handle it. It handles the resetting of AUTO_INCREMENT very well.

Source: https://stackoverflow.com/a/8693617/4964822
