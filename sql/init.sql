
DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `users`(
 `id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 `name` VARCHAR(100) NOT NULL,
 `surname` VARCHAR(100) NOT NULL,
 `phone` INT(9) NOT NULL,
 `email` VARCHAR(100) NOT NULL,
 PRIMARY KEY(`id`)
) engine = InnoDB default charset=UTF8;


INSERT INTO `users` (`id`, `name`, `surname`, `phone`, `email`) VALUES
(NULL, 'Giannis', 'Kotsiras', '735095091', 'kostu@gmail.com'),
(NULL, 'Daniel', 'Mancini', '873004621', 'danielx4@gmail.com'),
(NULL, 'Romualdas', 'Jansonas', '119836134', 'damunidbee@gmail.com'),
(NULL, 'Simon', 'Olsson', '008342038', 'olssonadk@gmail.com'),
(NULL, 'Camil', 'Jebara', '796359556', 'camilter89@gmail.com'),
(NULL, 'Patrick', 'Hoban', '885937168', 'patricxxw@gmail.com'),
(NULL, 'Tiago', 'Gouveia', '998234283', 'tiagomago@gmail.com'),
(NULL, 'Jan', 'Kuchta', '524371928', 'jankuchpz91@gmail.com'),
(NULL, 'Jordan', 'Veretout', '083625514', 'mjordangv34@gmail.com'),
(NULL, 'Maximilian', 'Eggestein', '762193707', 'maximilianqwv4@gmail.com');

