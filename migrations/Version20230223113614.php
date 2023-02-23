<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223113614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD reclamation_id INT DEFAULT NULL, ADD date DATE NOT NULL, ADD message LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F2D6BA2D9 ON message (reclamation_id)');
        $this->addSql('ALTER TABLE reclamation ADD user_id INT DEFAULT NULL, ADD date DATE NOT NULL, ADD etat TINYINT(1) DEFAULT NULL, ADD theme VARCHAR(255) NOT NULL, ADD object VARCHAR(100) NOT NULL, ADD text LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CE606404A76ED395 ON reclamation (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2D6BA2D9');
        $this->addSql('DROP INDEX IDX_B6BD307F2D6BA2D9 ON message');
        $this->addSql('ALTER TABLE message DROP reclamation_id, DROP date, DROP message');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP INDEX IDX_CE606404A76ED395 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP user_id, DROP date, DROP etat, DROP theme, DROP object, DROP text');
    }
}
