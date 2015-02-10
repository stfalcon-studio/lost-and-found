<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150210233542 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DD3564642');
        $this->addSql('ALTER TABLE items ADD activatedAt DATETIME DEFAULT NULL, ADD deletedAt DATETIME DEFAULT NULL, ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX idx_e11ee94dd3564642 ON items');
        $this->addSql('CREATE INDEX IDX_E11EE94DDE12AB56 ON items (created_by)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DD3564642 FOREIGN KEY (created_by) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DDE12AB56');
        $this->addSql('ALTER TABLE items DROP activatedAt, DROP deletedAt, DROP deleted');
        $this->addSql('DROP INDEX idx_e11ee94dde12ab56 ON items');
        $this->addSql('CREATE INDEX IDX_E11EE94DD3564642 ON items (created_by)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DDE12AB56 FOREIGN KEY (created_by) REFERENCES users (id)');
    }
}
