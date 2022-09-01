<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220829085127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marques ADD ordinateurs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE marques ADD CONSTRAINT FK_67884F2D9C42159C FOREIGN KEY (ordinateurs_id) REFERENCES ordinateurs (id)');
        $this->addSql('CREATE INDEX IDX_67884F2D9C42159C ON marques (ordinateurs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marques DROP FOREIGN KEY FK_67884F2D9C42159C');
        $this->addSql('DROP INDEX IDX_67884F2D9C42159C ON marques');
        $this->addSql('ALTER TABLE marques DROP ordinateurs_id');
    }
}
