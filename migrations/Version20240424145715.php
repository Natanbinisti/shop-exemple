<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424145715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress DROP CONSTRAINT fk_5cecc7be7e3c61f9');
        $this->addSql('DROP INDEX idx_5cecc7be7e3c61f9');
        $this->addSql('ALTER TABLE adress ADD city TEXT NOT NULL');
        $this->addSql('ALTER TABLE adress ADD country VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adress DROP zip_code');
        $this->addSql('ALTER TABLE adress DROP contry');
        $this->addSql('ALTER TABLE adress ALTER street TYPE TEXT');
        $this->addSql('ALTER TABLE adress RENAME COLUMN owner_id TO zipcode');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE adress ADD contry VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adress DROP city');
        $this->addSql('ALTER TABLE adress ALTER street TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE adress RENAME COLUMN zipcode TO owner_id');
        $this->addSql('ALTER TABLE adress RENAME COLUMN country TO zip_code');
        $this->addSql('ALTER TABLE adress ADD CONSTRAINT fk_5cecc7be7e3c61f9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5cecc7be7e3c61f9 ON adress (owner_id)');
    }
}
