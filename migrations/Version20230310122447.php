<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310122447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booster DROP username, DROP password, DROP firstname, DROP lastname, DROP email, DROP roles, DROP voie, DROP lien_opgg, DROP description, DROP solde, DROP prix, DROP disponibility, DROP reset_token');
        $this->addSql('ALTER TABLE game CHANGE price price INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD reclamation_id INT DEFAULT NULL, ADD date DATE NOT NULL, ADD message LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F2D6BA2D9 ON message (reclamation_id)');
        $this->addSql('ALTER TABLE reclamation ADD user_id INT DEFAULT NULL, ADD date DATE NOT NULL, ADD etat TINYINT(1) DEFAULT NULL, ADD theme VARCHAR(255) NOT NULL, ADD object VARCHAR(100) NOT NULL, ADD text LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CE606404A76ED395 ON reclamation (user_id)');
        $this->addSql('ALTER TABLE reservation_b ADD oldrank VARCHAR(255) NOT NULL, ADD newrank VARCHAR(255) NOT NULL, ADD newprice VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE team ADD player1 VARCHAR(255) NOT NULL, ADD player2 VARCHAR(255) NOT NULL, ADD player3 VARCHAR(255) NOT NULL, ADD player4 VARCHAR(255) NOT NULL, ADD player5 VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booster ADD username VARCHAR(180) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD voie VARCHAR(255) DEFAULT NULL, ADD lien_opgg VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD solde INT DEFAULT NULL, ADD prix INT DEFAULT NULL, ADD disponibility TINYINT(1) DEFAULT NULL, ADD reset_token VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE game CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2D6BA2D9');
        $this->addSql('DROP INDEX IDX_B6BD307F2D6BA2D9 ON message');
        $this->addSql('ALTER TABLE message DROP reclamation_id, DROP date, DROP message');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP INDEX IDX_CE606404A76ED395 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP user_id, DROP date, DROP etat, DROP theme, DROP object, DROP text');
        $this->addSql('ALTER TABLE reservation_b DROP oldrank, DROP newrank, DROP newprice');
        $this->addSql('ALTER TABLE team DROP player1, DROP player2, DROP player3, DROP player4, DROP player5');
    }
}
