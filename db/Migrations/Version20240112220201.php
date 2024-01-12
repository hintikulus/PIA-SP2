<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112220201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Vytvoření default admin uživatele';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
            INSERT INTO `user` (id, name, email_address, password_hash, role) VALUES ('+,p7rFeT', 'admin', 'admin@hintik.cz', '$2y$10\$UucFQhgWtHStUafp.MpmyuMuTsVZB9e1goiPVOHYct1jwfifYw1ou', 'admin')
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
