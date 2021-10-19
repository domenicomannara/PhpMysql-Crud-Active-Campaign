CREATE TRIGGER `after_contact_insert` 
AFTER INSERT ON `check_phone`
FOR EACH ROW 
BEGIN
    IF NEW.email is NOT NULL THEN
        INSERT INTO wellcome_gift(email)
        VALUES(NEW.email);
    END IF;
END