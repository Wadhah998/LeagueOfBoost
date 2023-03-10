<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308115754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session_coaching ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session_coaching ADD CONSTRAINT FK_411268A6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_411268A6A76ED395 ON session_coaching (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session_coaching DROP FOREIGN KEY FK_411268A6A76ED395');
        $this->addSql('DROP INDEX IDX_411268A6A76ED395 ON session_coaching');
        $this->addSql('ALTER TABLE session_coaching DROP user_id');
    }
}
