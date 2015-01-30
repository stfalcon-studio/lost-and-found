<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150130100439 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     * @author svatok13
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE items (id INT AUTO_INCREMENT NOT NULL, category INT DEFAULT NULL, title LONGTEXT NOT NULL, latitude NUMERIC(9, 6) NOT NULL, longitude NUMERIC(9, 6) NOT NULL, type ENUM(\'lost\', \'found\') NOT NULL COMMENT \'(DC2Type:ItemTypeType)\', description LONGTEXT NOT NULL, area LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', status ENUM(\'active\', \'resolved\') NOT NULL COMMENT \'(DC2Type:ItemStatusType)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E11EE94D64C19C1 (category), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D64C19C1 FOREIGN KEY (category) REFERENCES categories (id)');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     * @author svatok13
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D64C19C1');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE items');
    }
}
