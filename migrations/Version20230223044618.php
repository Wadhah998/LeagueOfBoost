<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223044618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_C4E0A61FE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE admin DROP activated');
        $this->addSql('ALTER TABLE booster ADD type_user VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client DROP activated');
        $this->addSql('ALTER TABLE coach ADD type_user VARCHAR(255) NOT NULL, DROP activated');
        $this->addSql('ALTER TABLE user DROP activated');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FE48FD905');
        $this->addSql('DROP TABLE team');
        $this->addSql('ALTER TABLE admin ADD activated TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE booster DROP type_user');
        $this->addSql('ALTER TABLE client ADD activated TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE coach ADD activated TINYINT(1) NOT NULL, DROP type_user');
        $this->addSql('ALTER TABLE user ADD activated TINYINT(1) NOT NULL');
    }
}
