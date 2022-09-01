<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220829085625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordinateurs ADD marques_fk_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ordinateurs ADD CONSTRAINT FK_A88D6BF2BAB6F4D FOREIGN KEY (marques_fk_id) REFERENCES marques (id)');
        $this->addSql('CREATE INDEX IDX_A88D6BF2BAB6F4D ON ordinateurs (marques_fk_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordinateurs DROP FOREIGN KEY FK_A88D6BF2BAB6F4D');
        $this->addSql('DROP INDEX IDX_A88D6BF2BAB6F4D ON ordinateurs');
        $this->addSql('ALTER TABLE ordinateurs DROP marques_fk_id');
    }
}
