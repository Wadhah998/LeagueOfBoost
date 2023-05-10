<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510010354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE session_coaching (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prix INT NOT NULL, date DATE NOT NULL, INDEX IDX_411268A6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session_coaching ADD CONSTRAINT FK_411268A6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2D6BA2D9');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
        $this->addSql('ALTER TABLE reservation_c CHANGE nbr_heures nbr_heures INT NOT NULL, CHANGE prix prix INT NOT NULL, CHANGE langue langue VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation_c ADD CONSTRAINT FK_608D716B3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE reservation_c ADD CONSTRAINT FK_608D716BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_608D716B3C105691 ON reservation_c (coach_id)');
        $this->addSql('CREATE INDEX IDX_608D716BA76ED395 ON reservation_c (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session_coaching DROP FOREIGN KEY FK_411268A6A76ED395');
        $this->addSql('DROP TABLE session_coaching');
        $this->addSql('ALTER TABLE game CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2D6BA2D9');
        $this->addSql('DROP INDEX IDX_B6BD307FA76ED395 ON message');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_c DROP FOREIGN KEY FK_608D716B3C105691');
        $this->addSql('ALTER TABLE reservation_c DROP FOREIGN KEY FK_608D716BA76ED395');
        $this->addSql('DROP INDEX IDX_608D716B3C105691 ON reservation_c');
        $this->addSql('DROP INDEX IDX_608D716BA76ED395 ON reservation_c');
        $this->addSql('ALTER TABLE reservation_c CHANGE nbr_heures nbr_heures INT DEFAULT NULL, CHANGE prix prix INT DEFAULT NULL, CHANGE langue langue VARCHAR(255) DEFAULT NULL');
    }
}
