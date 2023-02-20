<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220104431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_c ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation_c ADD CONSTRAINT FK_608D716B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_608D716B19EB6921 ON reservation_c (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_c DROP FOREIGN KEY FK_608D716B19EB6921');
        $this->addSql('DROP INDEX IDX_608D716B19EB6921 ON reservation_c');
        $this->addSql('ALTER TABLE reservation_c DROP client_id');
    }
}
