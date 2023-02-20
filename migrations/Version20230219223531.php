<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219223531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_b ADD booster_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation_b ADD CONSTRAINT FK_178A41FDF85E4930 FOREIGN KEY (booster_id) REFERENCES booster (id)');
        $this->addSql('CREATE INDEX IDX_178A41FDF85E4930 ON reservation_b (booster_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_b DROP FOREIGN KEY FK_178A41FDF85E4930');
        $this->addSql('DROP INDEX IDX_178A41FDF85E4930 ON reservation_b');
        $this->addSql('ALTER TABLE reservation_b DROP booster_id');
    }
}
