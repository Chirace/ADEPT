<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825130210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charge_nfx ADD pt_frequence VARCHAR(255) DEFAULT NULL, CHANGE prise_hauteur prise_hauteur DOUBLE PRECISION DEFAULT NULL, CHANGE prise_profondeur prise_profondeur DOUBLE PRECISION DEFAULT NULL, CHANGE depose_hauteur depose_hauteur DOUBLE PRECISION DEFAULT NULL, CHANGE depose_profondeur depose_profondeur DOUBLE PRECISION DEFAULT NULL, CHANGE force_initiale force_initiale DOUBLE PRECISION DEFAULT NULL, CHANGE distance_transport_charge distance_transport_charge DOUBLE PRECISION DEFAULT NULL, CHANGE transport_charge transport_charge VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charge_nfx DROP pt_frequence, CHANGE prise_hauteur prise_hauteur DOUBLE PRECISION NOT NULL, CHANGE prise_profondeur prise_profondeur DOUBLE PRECISION NOT NULL, CHANGE depose_hauteur depose_hauteur DOUBLE PRECISION NOT NULL, CHANGE depose_profondeur depose_profondeur DOUBLE PRECISION NOT NULL, CHANGE force_initiale force_initiale DOUBLE PRECISION NOT NULL, CHANGE distance_transport_charge distance_transport_charge DOUBLE PRECISION NOT NULL, CHANGE transport_charge transport_charge VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
