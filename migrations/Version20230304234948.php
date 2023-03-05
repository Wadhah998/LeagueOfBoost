<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304234948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD username VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD voie VARCHAR(255) DEFAULT NULL, ADD lien_opgg VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD solde INT DEFAULT NULL, ADD prix INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76F85E0677 ON admin (username)');
        $this->addSql('ALTER TABLE booster ADD voie VARCHAR(255) DEFAULT NULL, ADD lien_opgg VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD solde INT DEFAULT NULL, ADD prix INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD voie VARCHAR(255) DEFAULT NULL, ADD lien_opgg VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD solde INT DEFAULT NULL, ADD prix INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coach ADD voie VARCHAR(255) DEFAULT NULL, ADD lien_opgg VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD solde INT DEFAULT NULL, ADD prix INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2D6BA2D9');
        $this->addSql('DROP INDEX IDX_B6BD307F2D6BA2D9 ON message');
        $this->addSql('ALTER TABLE message DROP reclamation_id, DROP date, DROP message');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP INDEX IDX_CE606404A76ED395 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP user_id, DROP date, DROP etat, DROP theme, DROP object, DROP text');
        $this->addSql('ALTER TABLE reservation_b DROP oldrank, DROP newrank, DROP newprice');
        $this->addSql('ALTER TABLE user ADD voie VARCHAR(255) DEFAULT NULL, ADD lien_opgg VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD solde INT DEFAULT NULL, ADD prix INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_880E0D76F85E0677 ON admin');
        $this->addSql('ALTER TABLE admin DROP username, DROP roles, DROP password, DROP firstname, DROP lastname, DROP email, DROP voie, DROP lien_opgg, DROP description, DROP solde, DROP prix');
        $this->addSql('ALTER TABLE booster DROP voie, DROP lien_opgg, DROP description, DROP solde, DROP prix');
        $this->addSql('ALTER TABLE client DROP voie, DROP lien_opgg, DROP description, DROP solde, DROP prix');
        $this->addSql('ALTER TABLE coach DROP voie, DROP lien_opgg, DROP description, DROP solde, DROP prix');
        $this->addSql('ALTER TABLE message ADD reclamation_id INT DEFAULT NULL, ADD date DATE NOT NULL, ADD message LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F2D6BA2D9 ON message (reclamation_id)');
        $this->addSql('ALTER TABLE reclamation ADD user_id INT DEFAULT NULL, ADD date DATE NOT NULL, ADD etat TINYINT(1) DEFAULT NULL, ADD theme VARCHAR(255) NOT NULL, ADD object VARCHAR(100) NOT NULL, ADD text LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CE606404A76ED395 ON reclamation (user_id)');
        $this->addSql('ALTER TABLE reservation_b ADD oldrank VARCHAR(255) NOT NULL, ADD newrank VARCHAR(255) NOT NULL, ADD newprice VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP voie, DROP lien_opgg, DROP description, DROP solde, DROP prix');
    }
}
