<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150205153309 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DD3564642');
        $this->addSql('ALTER TABLE items CHANGE createdBy createdBy INT NOT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DD3564642 FOREIGN KEY (createdBy) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DD3564642');
        $this->addSql('ALTER TABLE items CHANGE createdBy createdBy INT DEFAULT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DD3564642 FOREIGN KEY (createdBy) REFERENCES users (id)');
    }
}
