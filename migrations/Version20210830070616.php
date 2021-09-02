<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210830070616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE division_naf (id INT AUTO_INCREMENT NOT NULL, section_naf_id INT NOT NULL, code VARCHAR(2) NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_9ACE7736EA6BD7AF (section_naf_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_naf (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(1) NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE division_naf ADD CONSTRAINT FK_9ACE7736EA6BD7AF FOREIGN KEY (section_naf_id) REFERENCES section_naf (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE division_naf DROP FOREIGN KEY FK_9ACE7736EA6BD7AF');
        $this->addSql('DROP TABLE division_naf');
        $this->addSql('DROP TABLE section_naf');
    }
}
