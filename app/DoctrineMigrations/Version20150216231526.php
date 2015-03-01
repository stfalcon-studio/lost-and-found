<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration 20150216231526. New features and fixes
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Version20150216231526 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE item_requests (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT NOT NULL,
                item_id INT NOT NULL,
                created_at DATETIME NOT NULL,
                INDEX IDX_17881E9AA76ED395 (user_id),
                INDEX IDX_17881E9A126F525E (item_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE user_log_actions (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT NOT NULL,
                `action` ENUM(\'connect\', \'login\', \'deauthorize\') NOT NULL COMMENT \'(DC2Type:UserActionType)\',
                created_at DATETIME NOT NULL,
                INDEX IDX_949E00EDA76ED395 (user_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE item_photos (
                id INT AUTO_INCREMENT NOT NULL,
                item INT DEFAULT NULL,
                image_name VARCHAR(255) DEFAULT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                INDEX IDX_8E8F95161F1B251E (item),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE faq (
                id INT AUTO_INCREMENT NOT NULL,
                question VARCHAR(200) NOT NULL,
                answer LONGTEXT NOT NULL,
                enabled TINYINT(1) NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE item_requests ADD CONSTRAINT FK_17881E9AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE item_requests ADD CONSTRAINT FK_17881E9A126F525E FOREIGN KEY (item_id) REFERENCES items (id)');
        $this->addSql('ALTER TABLE user_log_actions ADD CONSTRAINT FK_949E00EDA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE item_photos ADD CONSTRAINT FK_8E8F95161F1B251E FOREIGN KEY (item) REFERENCES items (id)');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DD3564642');
        $this->addSql('ALTER TABLE items ADD activated_at DATETIME DEFAULT NULL, ADD deleted TINYINT(1) NOT NULL, ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX idx_e11ee94dd3564642 ON items');
        $this->addSql('CREATE INDEX IDX_E11EE94DDE12AB56 ON items (created_by)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DD3564642 FOREIGN KEY (created_by) REFERENCES users (id)');
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE item_requests');
        $this->addSql('DROP TABLE user_log_actions');
        $this->addSql('DROP TABLE item_photos');
        $this->addSql('DROP TABLE faq');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DDE12AB56');
        $this->addSql('ALTER TABLE items DROP activated_at, DROP deleted, DROP deleted_at');
        $this->addSql('DROP INDEX idx_e11ee94dde12ab56 ON items');
        $this->addSql('CREATE INDEX IDX_E11EE94DD3564642 ON items (created_by)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DDE12AB56 FOREIGN KEY (created_by) REFERENCES users (id)');
    }
}
