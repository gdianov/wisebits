<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607083857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (
                            id INT AUTO_INCREMENT NOT NULL,
                            name VARCHAR(64) NOT NULL,
                            email VARCHAR(255) NOT NULL,
                            created DATETIME NOT NULL,
                            deleted DATETIME DEFAULT NULL,
                            notes TEXT DEFAULT NULL, 
                            PRIMARY KEY(id)
                  ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE UNIQUE INDEX users_email_uindex on users (email)');
        $this->addSql('CREATE UNIQUE INDEX users_name_uindex on users (name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users');
    }
}
