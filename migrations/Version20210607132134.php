<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210607132134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bilan_entreprise (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, entreprise_id INT DEFAULT NULL, date_creation DATETIME NOT NULL, date_bilan DATETIME NOT NULL, INDEX IDX_D7EDA800FB88E14F (utilisateur_id), INDEX IDX_D7EDA800A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_contrainte (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE charge_nfx (id INT AUTO_INCREMENT NOT NULL, poids_charge DOUBLE PRECISION NOT NULL, prise_hauteur DOUBLE PRECISION NOT NULL, prise_profondeur DOUBLE PRECISION NOT NULL, depose_hauteur DOUBLE PRECISION NOT NULL, depose_profondeur DOUBLE PRECISION NOT NULL, force_initiale DOUBLE PRECISION NOT NULL, force_maintien DOUBLE PRECISION DEFAULT NULL, distance_transport_charge DOUBLE PRECISION NOT NULL, transport_charge VARCHAR(255) NOT NULL, pt_action VARCHAR(255) DEFAULT NULL, pt_distance DOUBLE PRECISION DEFAULT NULL, pt_hauteur_poignee DOUBLE PRECISION DEFAULT NULL, nombre_charge_identique INT NOT NULL, contraintes_execution VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrainte (id INT AUTO_INCREMENT NOT NULL, categorie_contrainte_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, INDEX IDX_17925A706F2A0B8B (categorie_contrainte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, evaluateur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_D19FA60231F139 (evaluateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluateur (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, entreprise_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, INDEX IDX_BE15FA85FB88E14F (utilisateur_id), INDEX IDX_BE15FA85A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, evaluateur_id INT DEFAULT NULL, type_evaluation VARCHAR(255) NOT NULL, date_evaluation DATETIME NOT NULL, INDEX IDX_1323A575231F139 (evaluateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_nfx (id INT AUTO_INCREMENT NOT NULL, date_evaluation DATETIME NOT NULL, type_manutention VARCHAR(255) NOT NULL, temps_tonnage DOUBLE PRECISION NOT NULL, tonnage DOUBLE PRECISION NOT NULL, frequence_charge DOUBLE PRECISION DEFAULT NULL, contraintes_environnement VARCHAR(255) NOT NULL, contraintes_organisation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier (id INT AUTO_INCREMENT NOT NULL, nom_fichier VARCHAR(255) NOT NULL, type_fichier VARCHAR(255) NOT NULL, date_fichier DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operateur (id INT AUTO_INCREMENT NOT NULL, age INT NOT NULL, sexe VARCHAR(10) NOT NULL, flag_enceinte VARCHAR(3) NOT NULL, flag_droitier VARCHAR(3) NOT NULL, formation VARCHAR(255) NOT NULL, anciennete_poste INT NOT NULL, anciennete_entreprise INT NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_de_travail (id INT AUTO_INCREMENT NOT NULL, secteur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_DD84E80A9F7E4405 (secteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_8045251FF6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_694309E4A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE situation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, quoi VARCHAR(255) DEFAULT NULL, pourquoi VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, avec_qui VARCHAR(255) DEFAULT NULL, avec_quoi VARCHAR(255) DEFAULT NULL, organisation_travail VARCHAR(255) DEFAULT NULL, autre VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, mail VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bilan_entreprise ADD CONSTRAINT FK_D7EDA800FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE bilan_entreprise ADD CONSTRAINT FK_D7EDA800A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE contrainte ADD CONSTRAINT FK_17925A706F2A0B8B FOREIGN KEY (categorie_contrainte_id) REFERENCES categorie_contrainte (id)');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA60231F139 FOREIGN KEY (evaluateur_id) REFERENCES evaluateur (id)');
        $this->addSql('ALTER TABLE evaluateur ADD CONSTRAINT FK_BE15FA85FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE evaluateur ADD CONSTRAINT FK_BE15FA85A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575231F139 FOREIGN KEY (evaluateur_id) REFERENCES evaluateur (id)');
        $this->addSql('ALTER TABLE poste_de_travail ADD CONSTRAINT FK_DD84E80A9F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE secteur ADD CONSTRAINT FK_8045251FF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT FK_694309E4A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrainte DROP FOREIGN KEY FK_17925A706F2A0B8B');
        $this->addSql('ALTER TABLE bilan_entreprise DROP FOREIGN KEY FK_D7EDA800A4AEAFEA');
        $this->addSql('ALTER TABLE evaluateur DROP FOREIGN KEY FK_BE15FA85A4AEAFEA');
        $this->addSql('ALTER TABLE site DROP FOREIGN KEY FK_694309E4A4AEAFEA');
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA60231F139');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575231F139');
        $this->addSql('ALTER TABLE poste_de_travail DROP FOREIGN KEY FK_DD84E80A9F7E4405');
        $this->addSql('ALTER TABLE secteur DROP FOREIGN KEY FK_8045251FF6BD1646');
        $this->addSql('ALTER TABLE bilan_entreprise DROP FOREIGN KEY FK_D7EDA800FB88E14F');
        $this->addSql('ALTER TABLE evaluateur DROP FOREIGN KEY FK_BE15FA85FB88E14F');
        $this->addSql('DROP TABLE bilan_entreprise');
        $this->addSql('DROP TABLE categorie_contrainte');
        $this->addSql('DROP TABLE charge_nfx');
        $this->addSql('DROP TABLE contrainte');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE evaluateur');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE evaluation_nfx');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('DROP TABLE operateur');
        $this->addSql('DROP TABLE poste_de_travail');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE situation');
        $this->addSql('DROP TABLE utilisateur');
    }
}
