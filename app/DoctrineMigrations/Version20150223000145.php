<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration 20150223000145. New features and fixes
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Version20150223000145 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE category_translations (
                id INT AUTO_INCREMENT NOT NULL,
                object_id INT DEFAULT NULL,
                locale VARCHAR(8) NOT NULL,
                field VARCHAR(32) NOT NULL,
                content LONGTEXT DEFAULT NULL,
                INDEX IDX_1C60F915232D562B (object_id),
                UNIQUE INDEX category_translation_unique_idx (locale, object_id, field),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE faq_translations (
                id INT AUTO_INCREMENT NOT NULL,
                object_id INT DEFAULT NULL,
                locale VARCHAR(8) NOT NULL,
                field VARCHAR(32) NOT NULL,
                content LONGTEXT DEFAULT NULL,
                INDEX IDX_99569DA2232D562B (object_id),
                UNIQUE INDEX faq_translation_unique_idx (locale, object_id, field),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE category_translations ADD CONSTRAINT FK_1C60F915232D562B FOREIGN KEY (object_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE faq_translations ADD CONSTRAINT FK_99569DA2232D562B FOREIGN KEY (object_id) REFERENCES faq (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX unique_request ON item_requests (item_id, user_id)');
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE category_translations');
        $this->addSql('DROP TABLE faq_translations');
        $this->addSql('DROP INDEX unique_request ON item_requests');
    }
}
