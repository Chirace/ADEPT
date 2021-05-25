<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210525150759 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE charge_nfx (id INT AUTO_INCREMENT NOT NULL, poids_charge DOUBLE PRECISION NOT NULL, prise_hauteur DOUBLE PRECISION NOT NULL, prise_profondeur DOUBLE PRECISION NOT NULL, depose_hauteur DOUBLE PRECISION NOT NULL, depose_profondeur DOUBLE PRECISION NOT NULL, force_initiale DOUBLE PRECISION NOT NULL, force_maintien DOUBLE PRECISION DEFAULT NULL, distance_transport_charge DOUBLE PRECISION NOT NULL, transport_charge VARCHAR(255) NOT NULL, pt_action VARCHAR(255) DEFAULT NULL, pt_distance DOUBLE PRECISION DEFAULT NULL, pt_hauteur_poignee DOUBLE PRECISION DEFAULT NULL, nombre_charge_identique INT NOT NULL, contraintes_execution VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operateur (id INT AUTO_INCREMENT NOT NULL, age INT NOT NULL, sexe VARCHAR(10) NOT NULL, flag_enceinte VARCHAR(3) NOT NULL, flag_droitier VARCHAR(3) NOT NULL, formation VARCHAR(255) NOT NULL, anciennete_poste INT NOT NULL, anciennete_entreprise INT NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activite ADD quoi VARCHAR(255) DEFAULT NULL, ADD pourquoi VARCHAR(255) DEFAULT NULL, ADD comment VARCHAR(255) DEFAULT NULL, ADD avec_qui VARCHAR(255) DEFAULT NULL, ADD avec_quoi VARCHAR(255) DEFAULT NULL, ADD organisation_travail VARCHAR(255) DEFAULT NULL, ADD autre VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluation_nfx ADD contraintes_environnement VARCHAR(255) NOT NULL, ADD contraintes_organisation VARCHAR(255) NOT NULL, DROP poids_charge, DROP prise_hauteur, DROP prise_profondeur, DROP depose_hauteur, DROP depose_profondeur, DROP force_initiale, DROP force_maintien, DROP distance_transport_charge, DROP pt_action, DROP pt_distance, DROP pt_hauteur_poignee, CHANGE frequence_charge frequence_charge DOUBLE PRECISION DEFAULT NULL, CHANGE transport_charge type_manutention VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE charge_nfx');
        $this->addSql('DROP TABLE operateur');
        $this->addSql('ALTER TABLE activite DROP quoi, DROP pourquoi, DROP comment, DROP avec_qui, DROP avec_quoi, DROP organisation_travail, DROP autre');
        $this->addSql('ALTER TABLE evaluation_nfx ADD poids_charge DOUBLE PRECISION NOT NULL, ADD prise_hauteur DOUBLE PRECISION NOT NULL, ADD prise_profondeur DOUBLE PRECISION NOT NULL, ADD depose_hauteur DOUBLE PRECISION NOT NULL, ADD depose_profondeur DOUBLE PRECISION NOT NULL, ADD force_initiale DOUBLE PRECISION NOT NULL, ADD force_maintien DOUBLE PRECISION DEFAULT NULL, ADD distance_transport_charge DOUBLE PRECISION NOT NULL, ADD transport_charge VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD pt_action VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD pt_distance DOUBLE PRECISION DEFAULT NULL, ADD pt_hauteur_poignee DOUBLE PRECISION DEFAULT NULL, DROP type_manutention, DROP contraintes_environnement, DROP contraintes_organisation, CHANGE frequence_charge frequence_charge DOUBLE PRECISION NOT NULL');
    }
}
