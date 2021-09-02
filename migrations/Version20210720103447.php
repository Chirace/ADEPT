<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720103447 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation ADD poste_de_travail_id INT DEFAULT NULL, ADD secteur_id INT DEFAULT NULL, ADD site_id INT DEFAULT NULL, ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57517A47EE6 FOREIGN KEY (poste_de_travail_id) REFERENCES poste_de_travail (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5759F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_1323A57517A47EE6 ON evaluation (poste_de_travail_id)');
        $this->addSql('CREATE INDEX IDX_1323A5759F7E4405 ON evaluation (secteur_id)');
        $this->addSql('CREATE INDEX IDX_1323A575F6BD1646 ON evaluation (site_id)');
        $this->addSql('CREATE INDEX IDX_1323A575A4AEAFEA ON evaluation (entreprise_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A57517A47EE6');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5759F7E4405');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575F6BD1646');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575A4AEAFEA');
        $this->addSql('DROP INDEX IDX_1323A57517A47EE6 ON evaluation');
        $this->addSql('DROP INDEX IDX_1323A5759F7E4405 ON evaluation');
        $this->addSql('DROP INDEX IDX_1323A575F6BD1646 ON evaluation');
        $this->addSql('DROP INDEX IDX_1323A575A4AEAFEA ON evaluation');
        $this->addSql('ALTER TABLE evaluation DROP poste_de_travail_id, DROP secteur_id, DROP site_id, DROP entreprise_id');
    }
}
