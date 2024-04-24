<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424144642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress ADD zipcode INT NOT NULL');
        $this->addSql('ALTER TABLE adress ADD city TEXT NOT NULL');
        $this->addSql('ALTER TABLE adress ADD country VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adress DROP zip_code');
        $this->addSql('ALTER TABLE adress DROP contry');
        $this->addSql('ALTER TABLE adress ALTER street TYPE TEXT');
        $this->addSql('ALTER TABLE adress ALTER phone TYPE INT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE adress ADD contry VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adress DROP zipcode');
        $this->addSql('ALTER TABLE adress DROP city');
        $this->addSql('ALTER TABLE adress ALTER street TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE adress ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE adress RENAME COLUMN country TO zip_code');
    }
}
