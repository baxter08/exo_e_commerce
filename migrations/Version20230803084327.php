<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230803084327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD sous_categorie LONGTEXT NOT NULL, CHANGE nom nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE commande ADD numero VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE devis CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE description_travaux description_travaux VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE image CHANGE image image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE pseudo pseudo VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP sous_categorie, CHANGE nom nom VARCHAR(80) DEFAULT NULL');
        $this->addSql('ALTER TABLE devis CHANGE nom nom VARCHAR(80) DEFAULT NULL, CHANGE prenom prenom VARCHAR(80) DEFAULT NULL, CHANGE description_travaux description_travaux VARCHAR(1000) DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(80) NOT NULL');
        $this->addSql('ALTER TABLE image CHANGE image image VARCHAR(2000) NOT NULL');
        $this->addSql('ALTER TABLE commande DROP numero');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(80) NOT NULL, CHANGE prenom prenom VARCHAR(80) NOT NULL, CHANGE pseudo pseudo VARCHAR(80) NOT NULL');
    }
}
