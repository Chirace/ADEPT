<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716132232 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE situation ADD operateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE situation ADD CONSTRAINT FK_EC2D9ACA3F192FC FOREIGN KEY (operateur_id) REFERENCES operateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EC2D9ACA3F192FC ON situation (operateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE situation DROP FOREIGN KEY FK_EC2D9ACA3F192FC');
        $this->addSql('DROP INDEX UNIQ_EC2D9ACA3F192FC ON situation');
        $this->addSql('ALTER TABLE situation DROP operateur_id');
    }
}
