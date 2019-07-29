CREATE TABLE `photos`
( `id` INT NOT NULL AUTO_INCREMENT , 
`file_info` VARCHAR(150) NOT NULL , 
`file_main` VARCHAR(150) NOT NULL , 
`file_thumb` VARCHAR(150) NOT NULL, 
`title` TEXT NOT NULL , 
`description_p` TEXT NOT NULL, 
`height` INT NOT NULL, 
`width` INT NOT NULL, 
PRIMARY KEY (`id`)) ENGINE = InnoDB;


-- this is the sql to create the table that I use in the project.
-- I am adding the lead images, and thumb images to the table as columns. 
-- This simply means I have to write less code - i don't need to add text to a main filename to make thumbnail appear etc.
-- I also feel it prevents errors - the filenames are saved to the database after I add the files to their individual
-- folders. 