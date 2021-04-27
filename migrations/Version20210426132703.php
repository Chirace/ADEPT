<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210426132703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bilan_entreprise (id INT AUTO_INCREMENT NOT NULL, date_creation DATETIME NOT NULL, date_bilan DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_contrainte (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrainte (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, type_evaluation VARCHAR(255) NOT NULL, date_evaluation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_nfx (id INT AUTO_INCREMENT NOT NULL, date_evaluation DATETIME NOT NULL, poids_charge DOUBLE PRECISION NOT NULL, prise_hauteur DOUBLE PRECISION NOT NULL, prise_profondeur DOUBLE PRECISION NOT NULL, depose_hauteur DOUBLE PRECISION NOT NULL, depose_profondeur DOUBLE PRECISION NOT NULL, force_initiale DOUBLE PRECISION NOT NULL, force_maintien DOUBLE PRECISION DEFAULT NULL, distance_transport_charge DOUBLE PRECISION NOT NULL, temps_tonnage DOUBLE PRECISION NOT NULL, tonnage DOUBLE PRECISION NOT NULL, transport_charge VARCHAR(255) NOT NULL, frequence_charge DOUBLE PRECISION NOT NULL, pt_action VARCHAR(255) DEFAULT NULL, pt_distance DOUBLE PRECISION DEFAULT NULL, pt_hauteur_poignee DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier (id INT AUTO_INCREMENT NOT NULL, nom_fichier VARCHAR(255) NOT NULL, type_fichier VARCHAR(255) NOT NULL, date_fichier DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_de_travail (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE bilan_entreprise');
        $this->addSql('DROP TABLE categorie_contrainte');
        $this->addSql('DROP TABLE contrainte');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE evaluation_nfx');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('DROP TABLE poste_de_travail');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE site');
    }
}
