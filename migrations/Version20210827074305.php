<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210827074305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation_ed6161 (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, secteur_id INT DEFAULT NULL, poste_de_travail_id INT DEFAULT NULL, q1_non INT DEFAULT NULL, q1_oui INT DEFAULT NULL, q2_non INT DEFAULT NULL, q2_oui_non_critique INT DEFAULT NULL, q2_oui_critique INT DEFAULT NULL, INDEX IDX_671D62A5456C5646 (evaluation_id), INDEX IDX_671D62A59F7E4405 (secteur_id), INDEX IDX_671D62A517A47EE6 (poste_de_travail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluation_ed6161 ADD CONSTRAINT FK_671D62A5456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE evaluation_ed6161 ADD CONSTRAINT FK_671D62A59F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE evaluation_ed6161 ADD CONSTRAINT FK_671D62A517A47EE6 FOREIGN KEY (poste_de_travail_id) REFERENCES poste_de_travail (id)');
        $this->addSql('ALTER TABLE evaluation ADD evaluation_ed6161_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5758D3F3F20 FOREIGN KEY (evaluation_ed6161_id) REFERENCES evaluation_ed6161 (id)');
        $this->addSql('CREATE INDEX IDX_1323A5758D3F3F20 ON evaluation (evaluation_ed6161_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5758D3F3F20');
        $this->addSql('DROP TABLE evaluation_ed6161');
        $this->addSql('DROP INDEX IDX_1323A5758D3F3F20 ON evaluation');
        $this->addSql('ALTER TABLE evaluation DROP evaluation_ed6161_id');
    }
}
