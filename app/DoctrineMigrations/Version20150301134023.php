<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration 20150301134023. New features
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Version20150301134023 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE messages (
                id INT AUTO_INCREMENT NOT NULL,
                sender INT DEFAULT NULL,
                receiver INT DEFAULT NULL,
                content VARCHAR(120) NOT NULL,
                active TINYINT(1) NOT NULL,
                deleted TINYINT(1) NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                INDEX IDX_DB021E965F004ACF (sender),
                INDEX IDX_DB021E963DB88C96 (receiver),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE media_gallery_media (
                id INT AUTO_INCREMENT NOT NULL,
                gallery_id INT DEFAULT NULL,
                media_id INT DEFAULT NULL,
                position INT NOT NULL,
                enabled TINYINT(1) NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                INDEX IDX_6AD64F8E4E7AF8F (gallery_id),
                INDEX IDX_6AD64F8EEA9FDD75 (media_id), PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE media_media (
                id INT AUTO_INCREMENT NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                description TEXT DEFAULT NULL,
                enabled TINYINT(1) NOT NULL,
                provider_name VARCHAR(255) NOT NULL,
                provider_status INT NOT NULL,
                provider_reference VARCHAR(255) NOT NULL,
                provider_metadata LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\',
                width INT DEFAULT NULL,
                height INT DEFAULT NULL,
                length NUMERIC(10, 0) DEFAULT NULL,
                content_type VARCHAR(255) DEFAULT NULL,
                content_size INT DEFAULT NULL,
                copyright VARCHAR(255) DEFAULT NULL,
                author_name VARCHAR(255) DEFAULT NULL,
                `context` VARCHAR(64) DEFAULT NULL,
                cdn_is_flushable TINYINT(1) DEFAULT NULL,
                cdn_flush_at DATETIME DEFAULT NULL,
                cdn_status INT DEFAULT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE media_gallery (
                id INT AUTO_INCREMENT NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `context` VARCHAR(64) NOT NULL,
                default_format VARCHAR(255) NOT NULL,
                enabled TINYINT(1) NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E965F004ACF FOREIGN KEY (sender) REFERENCES users (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E963DB88C96 FOREIGN KEY (receiver) REFERENCES users (id)');
        $this->addSql('ALTER TABLE media_gallery_media ADD CONSTRAINT FK_6AD64F8E4E7AF8F FOREIGN KEY (gallery_id) REFERENCES media_gallery (id)');
        $this->addSql('ALTER TABLE media_gallery_media ADD CONSTRAINT FK_6AD64F8EEA9FDD75 FOREIGN KEY (media_id) REFERENCES media_media (id)');
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE media_gallery_media DROP FOREIGN KEY FK_6AD64F8EEA9FDD75');
        $this->addSql('ALTER TABLE media_gallery_media DROP FOREIGN KEY FK_6AD64F8E4E7AF8F');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE media_gallery_media');
        $this->addSql('DROP TABLE media_media');
        $this->addSql('DROP TABLE media_gallery');
    }
}
