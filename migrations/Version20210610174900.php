<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610174900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charge_nfx ADD evaluation_nfx_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE charge_nfx ADD CONSTRAINT FK_A12A9EB068BAECC2 FOREIGN KEY (evaluation_nfx_id) REFERENCES evaluation_nfx (id)');
        $this->addSql('CREATE INDEX IDX_A12A9EB068BAECC2 ON charge_nfx (evaluation_nfx_id)');
        $this->addSql('ALTER TABLE evaluation ADD situation_id INT DEFAULT NULL, ADD evaluation_nfx_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5753408E8AF FOREIGN KEY (situation_id) REFERENCES situation (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57568BAECC2 FOREIGN KEY (evaluation_nfx_id) REFERENCES evaluation_nfx (id)');
        $this->addSql('CREATE INDEX IDX_1323A5753408E8AF ON evaluation (situation_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1323A57568BAECC2 ON evaluation (evaluation_nfx_id)');
        $this->addSql('ALTER TABLE evaluation_nfx CHANGE temps_tonnage temps_tonnage DOUBLE PRECISION DEFAULT NULL, CHANGE tonnage tonnage DOUBLE PRECISION DEFAULT NULL, CHANGE contraintes_environnement contraintes_environnement VARCHAR(255) DEFAULT NULL, CHANGE contraintes_organisation contraintes_organisation VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charge_nfx DROP FOREIGN KEY FK_A12A9EB068BAECC2');
        $this->addSql('DROP INDEX IDX_A12A9EB068BAECC2 ON charge_nfx');
        $this->addSql('ALTER TABLE charge_nfx DROP evaluation_nfx_id');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5753408E8AF');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A57568BAECC2');
        $this->addSql('DROP INDEX IDX_1323A5753408E8AF ON evaluation');
        $this->addSql('DROP INDEX UNIQ_1323A57568BAECC2 ON evaluation');
        $this->addSql('ALTER TABLE evaluation DROP situation_id, DROP evaluation_nfx_id');
        $this->addSql('ALTER TABLE evaluation_nfx CHANGE temps_tonnage temps_tonnage DOUBLE PRECISION NOT NULL, CHANGE tonnage tonnage DOUBLE PRECISION NOT NULL, CHANGE contraintes_environnement contraintes_environnement VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contraintes_organisation contraintes_organisation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
