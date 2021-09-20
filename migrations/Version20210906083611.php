<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210906083611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise ADD secteur_activite_id INT DEFAULT NULL, ADD effectif INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA605233A7FC FOREIGN KEY (secteur_activite_id) REFERENCES division_naf (id)');
        $this->addSql('CREATE INDEX IDX_D19FA605233A7FC ON entreprise (secteur_activite_id)');
        $this->addSql('ALTER TABLE evaluateur DROP FOREIGN KEY FK_BE15FA855233A7FC');
        $this->addSql('ALTER TABLE evaluateur DROP FOREIGN KEY FK_BE15FA856C7F08C3');
        $this->addSql('ALTER TABLE evaluateur DROP FOREIGN KEY FK_BE15FA859BC85B17');
        $this->addSql('DROP INDEX IDX_BE15FA856C7F08C3 ON evaluateur');
        $this->addSql('DROP INDEX IDX_BE15FA855233A7FC ON evaluateur');
        $this->addSql('DROP INDEX IDX_BE15FA859BC85B17 ON evaluateur');
        $this->addSql('ALTER TABLE evaluateur DROP entreprise_exterieure_id, DROP site_exterieur_id, DROP secteur_activite_id, DROP effectif');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA605233A7FC');
        $this->addSql('DROP INDEX IDX_D19FA605233A7FC ON entreprise');
        $this->addSql('ALTER TABLE entreprise DROP secteur_activite_id, DROP effectif');
        $this->addSql('ALTER TABLE evaluateur ADD entreprise_exterieure_id INT DEFAULT NULL, ADD site_exterieur_id INT DEFAULT NULL, ADD secteur_activite_id INT DEFAULT NULL, ADD effectif INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluateur ADD CONSTRAINT FK_BE15FA855233A7FC FOREIGN KEY (secteur_activite_id) REFERENCES division_naf (id)');
        $this->addSql('ALTER TABLE evaluateur ADD CONSTRAINT FK_BE15FA856C7F08C3 FOREIGN KEY (site_exterieur_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE evaluateur ADD CONSTRAINT FK_BE15FA859BC85B17 FOREIGN KEY (entreprise_exterieure_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_BE15FA856C7F08C3 ON evaluateur (site_exterieur_id)');
        $this->addSql('CREATE INDEX IDX_BE15FA855233A7FC ON evaluateur (secteur_activite_id)');
        $this->addSql('CREATE INDEX IDX_BE15FA859BC85B17 ON evaluateur (entreprise_exterieure_id)');
    }
}
