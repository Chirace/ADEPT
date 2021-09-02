<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210830130513 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE domaine_ed6161 (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grille1_ed6161 (id INT AUTO_INCREMENT NOT NULL, evaluation_ed6161_id INT NOT NULL, valeurs VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_5043DBDE8D3F3F20 (evaluation_ed6161_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grille2_ed6161 (id INT AUTO_INCREMENT NOT NULL, evaluation_ed6161_id INT NOT NULL, valeurs VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_DECCDC3D8D3F3F20 (evaluation_ed6161_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_ed6161 (id INT AUTO_INCREMENT NOT NULL, domaine_ed6161_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, INDEX IDX_AA3F785A49E45A64 (domaine_ed6161_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grille1_ed6161 ADD CONSTRAINT FK_5043DBDE8D3F3F20 FOREIGN KEY (evaluation_ed6161_id) REFERENCES evaluation_ed6161 (id)');
        $this->addSql('ALTER TABLE grille2_ed6161 ADD CONSTRAINT FK_DECCDC3D8D3F3F20 FOREIGN KEY (evaluation_ed6161_id) REFERENCES evaluation_ed6161 (id)');
        $this->addSql('ALTER TABLE question_ed6161 ADD CONSTRAINT FK_AA3F785A49E45A64 FOREIGN KEY (domaine_ed6161_id) REFERENCES domaine_ed6161 (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_ed6161 DROP FOREIGN KEY FK_AA3F785A49E45A64');
        $this->addSql('DROP TABLE domaine_ed6161');
        $this->addSql('DROP TABLE grille1_ed6161');
        $this->addSql('DROP TABLE grille2_ed6161');
        $this->addSql('DROP TABLE question_ed6161');
    }
}
