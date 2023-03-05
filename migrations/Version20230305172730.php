<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305172730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD disponibility TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE booster ADD disponibility TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD disponibility TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE coach ADD disponibility TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD disponibility TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP disponibility');
        $this->addSql('ALTER TABLE booster DROP disponibility');
        $this->addSql('ALTER TABLE client DROP disponibility');
        $this->addSql('ALTER TABLE coach DROP disponibility');
        $this->addSql('ALTER TABLE user DROP disponibility');
    }
}
