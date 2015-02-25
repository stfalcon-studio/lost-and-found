<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150224103149 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E968D93D649');
        $this->addSql('DROP INDEX IDX_DB021E968D93D649 ON messages');
        $this->addSql('ALTER TABLE messages ADD receiver INT DEFAULT NULL, CHANGE user sender INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E965F004ACF FOREIGN KEY (sender) REFERENCES users (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E963DB88C96 FOREIGN KEY (receiver) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_DB021E965F004ACF ON messages (sender)');
        $this->addSql('CREATE INDEX IDX_DB021E963DB88C96 ON messages (receiver)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E965F004ACF');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E963DB88C96');
        $this->addSql('DROP INDEX IDX_DB021E965F004ACF ON messages');
        $this->addSql('DROP INDEX IDX_DB021E963DB88C96 ON messages');
        $this->addSql('ALTER TABLE messages ADD user INT DEFAULT NULL, DROP sender, DROP receiver');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E968D93D649 FOREIGN KEY (user) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_DB021E968D93D649 ON messages (user)');
    }
}
