<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20230223135129.php
final class Version20230223135129 extends AbstractMigration
========
final class Version20230222163037 extends AbstractMigration
>>>>>>>> main:migrations/Version20230222163037.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20230223135129.php
        $this->addSql('DROP TABLE test');
========
        $this->addSql('ALTER TABLE booster ADD availability TINYINT(1) NOT NULL');
>>>>>>>> main:migrations/Version20230222163037.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20230223135129.php
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, test VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
========
        $this->addSql('ALTER TABLE booster DROP availability');
>>>>>>>> main:migrations/Version20230222163037.php
    }
}
