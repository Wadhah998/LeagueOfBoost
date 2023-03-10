<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310104031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, titre VARCHAR(255) NOT NULL, likes INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, comments_id INT DEFAULT NULL, comment LONGTEXT NOT NULL, INDEX IDX_67F068BC63379586 (comments_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC63379586 FOREIGN KEY (comments_id) REFERENCES actualite (id)');
        $this->addSql('DROP INDEX UNIQ_EF769FADF85E0677 ON booster');
        $this->addSql('ALTER TABLE booster ADD rang VARCHAR(255) NOT NULL, ADD lane VARCHAR(255) NOT NULL, ADD op_gg VARCHAR(255) NOT NULL, ADD language VARCHAR(255) NOT NULL, ADD period INT NOT NULL, ADD wallet DOUBLE PRECISION NOT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD availability TINYINT(1) NOT NULL, DROP username, DROP password, DROP firstname, DROP lastname, DROP email, DROP roles, DROP voie, DROP lien_opgg, DROP solde, DROP prix, DROP disponibility, DROP reset_token, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE message ADD reclamation_id INT DEFAULT NULL, ADD date DATE NOT NULL, ADD message LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F2D6BA2D9 ON message (reclamation_id)');
        $this->addSql('ALTER TABLE reclamation ADD user_id INT DEFAULT NULL, ADD date DATE NOT NULL, ADD etat TINYINT(1) DEFAULT NULL, ADD theme VARCHAR(255) NOT NULL, ADD object VARCHAR(100) NOT NULL, ADD text LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CE606404A76ED395 ON reclamation (user_id)');
        $this->addSql('ALTER TABLE reservation_b ADD oldrank VARCHAR(255) NOT NULL, ADD newrank VARCHAR(255) NOT NULL, ADD newprice VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC63379586');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('ALTER TABLE booster ADD username VARCHAR(180) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD voie VARCHAR(255) DEFAULT NULL, ADD lien_opgg VARCHAR(255) DEFAULT NULL, ADD solde INT DEFAULT NULL, ADD prix INT DEFAULT NULL, ADD disponibility TINYINT(1) DEFAULT NULL, ADD reset_token VARCHAR(100) DEFAULT NULL, DROP rang, DROP lane, DROP op_gg, DROP language, DROP period, DROP wallet, DROP price, DROP availability, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EF769FADF85E0677 ON booster (username)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2D6BA2D9');
        $this->addSql('DROP INDEX IDX_B6BD307F2D6BA2D9 ON message');
        $this->addSql('ALTER TABLE message DROP reclamation_id, DROP date, DROP message');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP INDEX IDX_CE606404A76ED395 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP user_id, DROP date, DROP etat, DROP theme, DROP object, DROP text');
        $this->addSql('ALTER TABLE reservation_b DROP oldrank, DROP newrank, DROP newprice');
    }
}
