<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200729094553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participates DROP FOREIGN KEY FK_33017524BF396750');
        $this->addSql('ALTER TABLE participates CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participates CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE participates ADD CONSTRAINT FK_33017524BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
