<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310142047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_booster (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, oldrank VARCHAR(255) NOT NULL, newrank VARCHAR(255) NOT NULL, prix INT NOT NULL, INDEX IDX_88E32428A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_boosting (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, nbr_heure INT NOT NULL, prix INT NOT NULL, INDEX IDX_CD9D76EDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_booster ADD CONSTRAINT FK_88E32428A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE session_boosting ADD CONSTRAINT FK_CD9D76EDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_booster DROP FOREIGN KEY FK_88E32428A76ED395');
        $this->addSql('ALTER TABLE session_boosting DROP FOREIGN KEY FK_CD9D76EDA76ED395');
        $this->addSql('DROP TABLE reservation_booster');
        $this->addSql('DROP TABLE session_boosting');
    }
}
