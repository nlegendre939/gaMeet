<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221163711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED587E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_77E0ED587E3C61F9 ON ad (owner_id)');
        $this->addSql('ALTER TABLE contact ADD question LONGTEXT NOT NULL, ADD date DATETIME DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE message message LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad DROP FOREIGN KEY FK_77E0ED587E3C61F9');
        $this->addSql('DROP INDEX IDX_77E0ED587E3C61F9 ON ad');
        $this->addSql('ALTER TABLE ad DROP owner_id');
        $this->addSql('ALTER TABLE contact DROP question, DROP date, CHANGE id id INT NOT NULL, CHANGE name name VARCHAR(40) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE message message INT NOT NULL');
    }
}
