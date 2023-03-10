<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308195141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_c (id INT AUTO_INCREMENT NOT NULL, coach_id INT DEFAULT NULL, user_id INT DEFAULT NULL, nbr_heures INT NOT NULL, prix INT NOT NULL, langue VARCHAR(255) NOT NULL, relation VARCHAR(255) NOT NULL, INDEX IDX_608D716B3C105691 (coach_id), INDEX IDX_608D716BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_c ADD CONSTRAINT FK_608D716B3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE reservation_c ADD CONSTRAINT FK_608D716BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_c DROP FOREIGN KEY FK_608D716B3C105691');
        $this->addSql('ALTER TABLE reservation_c DROP FOREIGN KEY FK_608D716BA76ED395');
        $this->addSql('DROP TABLE reservation_c');
    }
}
