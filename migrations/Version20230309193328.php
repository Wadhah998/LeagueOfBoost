<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309193328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD reset_token VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE booster ADD reset_token VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE client ADD reset_token VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE coach ADD reset_token VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE user ADD reset_token VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP reset_token');
        $this->addSql('ALTER TABLE booster DROP reset_token');
        $this->addSql('ALTER TABLE client DROP reset_token');
        $this->addSql('ALTER TABLE coach DROP reset_token');
        $this->addSql('ALTER TABLE user DROP reset_token');
    }
}
