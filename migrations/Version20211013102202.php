<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211013102202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bilan_evaluation (id INT AUTO_INCREMENT NOT NULL, bilan_id INT DEFAULT NULL, evaluation_id INT DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_C9D7F715705F7C57 (bilan_id), INDEX IDX_C9D7F715456C5646 (evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bilan_evaluation ADD CONSTRAINT FK_C9D7F715705F7C57 FOREIGN KEY (bilan_id) REFERENCES bilan_entreprise (id)');
        $this->addSql('ALTER TABLE bilan_evaluation ADD CONSTRAINT FK_C9D7F715456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bilan_evaluation');
    }
}
