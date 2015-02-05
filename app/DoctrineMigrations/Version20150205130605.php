<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150205130605 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ext_log_entries (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(8) NOT NULL, logged_at DATETIME NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', username VARCHAR(255) DEFAULT NULL, INDEX log_class_lookup_idx (object_class), INDEX log_date_lookup_idx (logged_at), INDEX log_user_lookup_idx (username), INDEX log_version_lookup_idx (object_id, object_class, version), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, full_name VARCHAR(255) NOT NULL, facebook_id VARCHAR(32) NOT NULL, facebook_access_token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1483A5E9A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(60) NOT NULL, enabled TINYINT(1) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE items (id INT AUTO_INCREMENT NOT NULL, category INT DEFAULT NULL, title VARCHAR(120) NOT NULL, latitude NUMERIC(18, 15) DEFAULT NULL, longitude NUMERIC(18, 15) DEFAULT NULL, type ENUM(\'lost\', \'found\') NOT NULL COMMENT \'(DC2Type:ItemTypeType)\', description LONGTEXT NOT NULL, area LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', areaType ENUM(\'polygon\', \'found\', \'circle\', \'marker\') NOT NULL COMMENT \'(DC2Type:ItemAreaTypeType)\', status ENUM(\'active\', \'resolved\') NOT NULL COMMENT \'(DC2Type:ItemStatusType)\', date DATE NOT NULL, moderated TINYINT(1) NOT NULL, moderated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, createdBy INT DEFAULT NULL, INDEX IDX_E11EE94D64C19C1 (category), INDEX IDX_E11EE94DD3564642 (createdBy), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D64C19C1 FOREIGN KEY (category) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DD3564642 FOREIGN KEY (createdBy) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DD3564642');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D64C19C1');
        $this->addSql('DROP TABLE ext_log_entries');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE items');
    }
}
