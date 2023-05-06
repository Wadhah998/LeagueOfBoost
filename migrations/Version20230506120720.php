<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506120720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite_favoris DROP FOREIGN KEY actualite_iddd');
        $this->addSql('ALTER TABLE actualite_favoris DROP FOREIGN KEY user_iddddddddd');
        $this->addSql('DROP TABLE actualite_favoris');
        $this->addSql('DROP TABLE session_coaching');
        $this->addSql('ALTER TABLE actualite ADD likes INT DEFAULT NULL, DROP short_description, DROP img, DROP date, DROP etiquette, DROP score, DROP nb_vues, CHANGE Description description LONGTEXT NOT NULL');
        $this->addSql('DROP INDEX id ON coach');
        $this->addSql('ALTER TABLE coach ADD username VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD voie VARCHAR(255) DEFAULT NULL, ADD lien_opgg VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD solde INT DEFAULT NULL, ADD prix INT DEFAULT NULL, ADD disponibility TINYINT(1) DEFAULT NULL, ADD reset_token VARCHAR(100) DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3F596DCCF85E0677 ON coach (username)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY useriiid');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY news___id');
        $this->addSql('DROP INDEX news_id ON commentaire');
        $this->addSql('DROP INDEX user_id ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD comments_id INT DEFAULT NULL, DROP user_id, DROP news_id, DROP date, CHANGE comment comment LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC63379586 FOREIGN KEY (comments_id) REFERENCES actualite (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC63379586 ON commentaire (comments_id)');
        $this->addSql('ALTER TABLE game MODIFY game_id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON game');
        $this->addSql('ALTER TABLE game CHANGE game_id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE game ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2D6BA2D9');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
        $this->addSql('ALTER TABLE reservation_c DROP user_id, DROP nbr_heures, DROP prix, DROP langue');
        $this->addSql('ALTER TABLE reservation_c ADD CONSTRAINT FK_608D716B3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
        $this->addSql('CREATE INDEX IDX_608D716B3C105691 ON reservation_c (coach_id)');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FE48FD905');
        $this->addSql('ALTER TABLE team DROP wins, DROP losses');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite_favoris (id INT AUTO_INCREMENT NOT NULL, actualite_id INT NOT NULL, user_id INT NOT NULL, INDEX actualite_id (actualite_id), INDEX user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE session_coaching (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, prix INT DEFAULT NULL, date DATE DEFAULT NULL, user_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE actualite_favoris ADD CONSTRAINT actualite_iddd FOREIGN KEY (actualite_id) REFERENCES actualite (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actualite_favoris ADD CONSTRAINT user_iddddddddd FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actualite ADD short_description VARCHAR(255) DEFAULT NULL, ADD img VARCHAR(255) DEFAULT NULL, ADD date DATE DEFAULT \'CURRENT_TIMESTAMP\' NOT NULL, ADD etiquette VARCHAR(255) DEFAULT NULL, ADD score DOUBLE PRECISION DEFAULT NULL, ADD nb_vues INT DEFAULT 0 NOT NULL, DROP likes, CHANGE description Description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE coach MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE coach DROP INDEX primary, ADD UNIQUE INDEX id (id)');
        $this->addSql('DROP INDEX UNIQ_3F596DCCF85E0677 ON coach');
        $this->addSql('ALTER TABLE coach DROP username, DROP roles, DROP password, DROP firstname, DROP lastname, DROP email, DROP voie, DROP lien_opgg, DROP description, DROP solde, DROP prix, DROP disponibility, DROP reset_token, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC63379586');
        $this->addSql('DROP INDEX IDX_67F068BC63379586 ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD user_id INT NOT NULL, ADD news_id INT NOT NULL, ADD date DATE DEFAULT \'CURRENT_TIMESTAMP\' NOT NULL, DROP comments_id, CHANGE comment comment VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT useriiid FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT news___id FOREIGN KEY (news_id) REFERENCES actualite (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX news_id ON commentaire (news_id)');
        $this->addSql('CREATE INDEX user_id ON commentaire (user_id)');
        $this->addSql('ALTER TABLE game MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON game');
        $this->addSql('ALTER TABLE game CHANGE id game_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE game ADD PRIMARY KEY (game_id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2D6BA2D9');
        $this->addSql('DROP INDEX IDX_B6BD307FA76ED395 ON message');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('ALTER TABLE reservation_c DROP FOREIGN KEY FK_608D716B3C105691');
        $this->addSql('DROP INDEX IDX_608D716B3C105691 ON reservation_c');
        $this->addSql('ALTER TABLE reservation_c ADD user_id INT DEFAULT NULL, ADD nbr_heures INT DEFAULT NULL, ADD prix INT DEFAULT NULL, ADD langue VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FE48FD905');
        $this->addSql('ALTER TABLE team ADD wins INT NOT NULL, ADD losses INT NOT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FE48FD905 FOREIGN KEY (game_id) REFERENCES game (game_id)');
    }
}
