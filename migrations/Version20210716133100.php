<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716133100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operateur CHANGE age age INT DEFAULT NULL, CHANGE sexe sexe VARCHAR(10) DEFAULT NULL, CHANGE flag_enceinte flag_enceinte VARCHAR(3) DEFAULT NULL, CHANGE formation formation VARCHAR(255) DEFAULT NULL, CHANGE anciennete_poste anciennete_poste INT DEFAULT NULL, CHANGE anciennete_entreprise anciennete_entreprise INT DEFAULT NULL, CHANGE lateralite lateralite VARCHAR(10) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operateur CHANGE age age INT NOT NULL, CHANGE sexe sexe VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE flag_enceinte flag_enceinte VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lateralite lateralite VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE formation formation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE anciennete_poste anciennete_poste INT NOT NULL, CHANGE anciennete_entreprise anciennete_entreprise INT NOT NULL');
    }
}
