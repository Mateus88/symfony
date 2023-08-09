<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805230647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Create Table city
        $this->addSql("CREATE TABLE `city` (
            `id` INT(10) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NULL DEFAULT NULL,
            PRIMARY KEY (`id`) USING BTREE
        )
        ENGINE=InnoDB
        ;");

        // Create Table bus_ticket
        $this->addSql("CREATE TABLE `bus_ticket` (
            `id` INT(10) NOT NULL AUTO_INCREMENT,
            `sourceCity` INT(10) NULL DEFAULT NULL,
            `destinationCity` INT(10) NULL DEFAULT NULL,
            `departureTime` DATETIME NULL DEFAULT NULL,
            `arrivalTime` DATETIME NULL DEFAULT NULL,
            `price` DECIMAL(6,2) NULL DEFAULT NULL,
            `status` TINYINT(1) NULL DEFAULT NULL,
            PRIMARY KEY (`id`) USING BTREE,
            INDEX `FK_bus_ticket_city` (`sourceCity`) USING BTREE,
            INDEX `FK_bus_ticket_city_2` (`destinationCity`) USING BTREE,
            CONSTRAINT `FK_bus_ticket_city` FOREIGN KEY (`sourceCity`) REFERENCES `city` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
            CONSTRAINT `FK_bus_ticket_city_2` FOREIGN KEY (`destinationCity`) REFERENCES `city` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
        )
        COLLATE='utf8mb4_0900_ai_ci'
        ENGINE=InnoDB
        AUTO_INCREMENT=1
        ;
        ");

        //INSERT DATA CITY
        $this->addSql("INSERT INTO `city` (`id`, `name`) VALUES
            (1, 'Lisboa'),
            (2, 'Porto'),
            (3, 'Viseu'),
            (4, 'Braga'),
            (5, 'Coimbra'),
            (6, 'Faro');");

        $date = date('Y-m-d');
        // INSERT DATA TICKET
        $this->addSql("INSERT INTO `bus_ticket` (`id`, `sourceCity`, `destinationCity`, `departureTime`, `arrivalTime`, `price`, `status`) VALUES
        (1, 1, 2, '$date 08:00:00', '$date 12:00:00', 60.00, 1),
        (2, 1, 2, '$date 10:00:00', '$date 13:00:00', 60.00, 1),
        (3, 1, 3, '$date 11:00:00', '$date 12:00:00', 40.00, 1),
        (4, 1, 3, '$date 18:00:00', '$date 20:00:00', 30.00, 1),
        (5, 1, 4, '$date 20:00:00', '$date 23:00:00', 60.00, 1),
        (6, 1, 6, '$date 21:00:00', '$date 23:30:00', 60.00, 1),
        (7, 2, 3, '$date 10:00:00', '$date 13:00:00', 20.00, 1),
        (8, 2, 4, '$date 15:00:00', '$date 18:00:00', 40.00, 1),
        (9, 2, 5, '$date 10:00:00', '$date 13:00:00', 25.00, 1),
        (10, 3, 1, '$date 10:00:00', '$date 13:00:00', 30.00, 1),
        (11, 3, 1, '$date 18:00:00', '$date 21:00:00', 30.00, 1),
        (12, 3, 2, '$date 20:00:00', '$date 22:00:00', 20.00, 1),
        (13, 4, 6, '$date 10:00:00', '$date 13:40:00', 20.00, 1),
        (14, 4, 2, '$date 20:00:00', '$date 23:30:00', 60.00, 1),
        (15, 5, 1, '$date 10:00:00', '$date 13:00:00', 50.00, 1),
        (16, 5, 2, '$date 19:00:00', '$date 21:00:00', 40.00, 1),
        (17, 6, 1, '$date 10:00:00', '$date 13:00:00', 30.00, 1),
        (18, 6, 1, '$date 20:00:00', '$date 23:00:00', 30.00, 1);");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `bus_ticket`');
        $this->addSql('DROP TABLE `city`');
    }
}
