<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150205101102 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE items ADD createdBy INT DEFAULT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DD3564642 FOREIGN KEY (createdBy) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_E11EE94DD3564642 ON items (createdBy)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DD3564642');
        $this->addSql('DROP INDEX IDX_E11EE94DD3564642 ON items');
        $this->addSql('ALTER TABLE items DROP createdBy');
    }
}
