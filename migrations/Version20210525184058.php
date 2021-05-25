<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210525184058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrainte ADD categorie_contrainte_id INT NOT NULL');
        $this->addSql('ALTER TABLE contrainte ADD CONSTRAINT FK_17925A706F2A0B8B FOREIGN KEY (categorie_contrainte_id) REFERENCES categorie_contrainte (id)');
        $this->addSql('CREATE INDEX IDX_17925A706F2A0B8B ON contrainte (categorie_contrainte_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrainte DROP FOREIGN KEY FK_17925A706F2A0B8B');
        $this->addSql('DROP INDEX IDX_17925A706F2A0B8B ON contrainte');
        $this->addSql('ALTER TABLE contrainte DROP categorie_contrainte_id');
    }
}
