<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration 20150211113004
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Version20150211113004 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

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

        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DDE12AB56');
        $this->addSql('ALTER TABLE items DROP activated_at, DROP deleted, DROP deleted_at');
        $this->addSql('DROP INDEX idx_e11ee94dde12ab56 ON items');
        $this->addSql('CREATE INDEX IDX_E11EE94DD3564642 ON items (created_by)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DDE12AB56 FOREIGN KEY (created_by) REFERENCES users (id)');
    }
}
