DELIMITER $$
CREATE PROCEDURE GetPhoneContactNull()
BEGIN
	DECLARE totalNullPhone INT DEFAULT 0;
	
    SELECT COUNT(*)  
    INTO totalNullPhone
    FROM check_phone
    WHERE check_phone.phone = 0;
    
    SELECT totalNullPhone;
END$$
DELIMITER ;