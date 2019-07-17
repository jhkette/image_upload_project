CREATE TABLE `photos3`
( `id` INT NOT NULL AUTO_INCREMENT , 
`file_info` VARCHAR(100) NOT NULL , 
`file_main` VARCHAR(100) NOT NULL , 
`file_thumb` VARCHAR(100) NOT NULL, 
`title` TEXT NOT NULL , 
`description_p` TEXT NOT NULL, 
PRIMARY KEY (`id`)) ENGINE = InnoDB;