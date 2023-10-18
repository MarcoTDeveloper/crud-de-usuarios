CREATE DATABASE IF NOT EXISTS `u524077001_demo_sharp`;
USE `u524077001_demo_sharp`;

CREATE TABLE `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `avatar` varchar(255) DEFAULT '/default.png',
    `email` varchar(255) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    `position` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `status` varchar(5) NOT NULL DEFAULT 'true',
    PRIMARY KEY (id)
);

DELIMITER $$
CREATE TRIGGER `insert_users_permissions` AFTER INSERT ON `users` FOR EACH ROW
BEGIN
    INSERT INTO `users_permissions` (`user_id`, `permission`) VALUES (NEW.id, 'users.create');
    INSERT INTO `users_permissions` (`user_id`, `permission`) VALUES (NEW.id, 'users.read');
    INSERT INTO `users_permissions` (`user_id`, `permission`) VALUES (NEW.id, 'users.update');
    INSERT INTO `users_permissions` (`user_id`, `permission`) VALUES (NEW.id, 'users.delete');
END$$
DELIMITER ;

CREATE TABLE `users_permissions` (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `permission` varchar(255) NOT NULL,
    `status` varchar(5) NOT NULL DEFAULT 'false',
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `api_sessions` (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `token` varchar(255) NOT NULL,
    `expires` datetime NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `users_logs` (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `date` datetime NOT NULL,
    `action` varchar(82) NOT NULL,
    `description` JSON NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `users` (`name`, `email`, `password`, `position`, `slug`) VALUES ("Sharp Soluções", "teste@sharpsolucoes.com", "$2y$12$4EF0zEKbVB4ZXWGLquI2T.Q0mtK2DGPuQoY93A1HXl5eX.HtKu6l2", "Suporte", "1-sharp-solucoes");