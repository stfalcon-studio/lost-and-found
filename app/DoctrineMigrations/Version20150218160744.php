<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150218160744 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE user_item_requests');
        $this->addSql('ALTER TABLE faq_translations DROP FOREIGN KEY FK_99569DA2232D562B');
        $this->addSql('DROP INDEX lookup_unique_idx ON faq_translations');
        $this->addSql('CREATE UNIQUE INDEX faq_translation_unique_idx ON faq_translations (locale, object_id, field)');
        $this->addSql('ALTER TABLE faq_translations ADD CONSTRAINT FK_99569DA2232D562B FOREIGN KEY (object_id) REFERENCES faq (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL COLLATE utf8_unicode_ci, object_class VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, field VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci, foreign_key VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci, content LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), INDEX translations_lookup_idx (locale, object_class, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_item_requests (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, item_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F906B3CAA76ED395 (user_id), INDEX IDX_F906B3CA126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE faq_translations DROP FOREIGN KEY FK_99569DA2232D562B');
        $this->addSql('DROP INDEX faq_translation_unique_idx ON faq_translations');
        $this->addSql('CREATE UNIQUE INDEX lookup_unique_idx ON faq_translations (locale, object_id, field)');
        $this->addSql('ALTER TABLE faq_translations ADD CONSTRAINT FK_99569DA2232D562B FOREIGN KEY (object_id) REFERENCES faq (id) ON DELETE CASCADE');
    }
}
