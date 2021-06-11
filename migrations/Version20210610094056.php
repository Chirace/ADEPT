<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610094056 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier ADD situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551F3408E8AF FOREIGN KEY (situation_id) REFERENCES situation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B76551F3408E8AF ON fichier (situation_id)');
        $this->addSql('ALTER TABLE situation ADD poste_de_travail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE situation ADD CONSTRAINT FK_EC2D9ACA17A47EE6 FOREIGN KEY (poste_de_travail_id) REFERENCES poste_de_travail (id)');
        $this->addSql('CREATE INDEX IDX_EC2D9ACA17A47EE6 ON situation (poste_de_travail_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551F3408E8AF');
        $this->addSql('DROP INDEX UNIQ_9B76551F3408E8AF ON fichier');
        $this->addSql('ALTER TABLE fichier DROP situation_id');
        $this->addSql('ALTER TABLE situation DROP FOREIGN KEY FK_EC2D9ACA17A47EE6');
        $this->addSql('DROP INDEX IDX_EC2D9ACA17A47EE6 ON situation');
        $this->addSql('ALTER TABLE situation DROP poste_de_travail_id');
    }
}
