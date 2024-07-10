<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528221822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog ADD slug VARCHAR(255) NOT NULL DEFAULT \'\'');
        $this->addSql('ALTER TABLE blog ALTER thumbnail SET NOT NULL');
        $this->addSql('ALTER TABLE blog ALTER content DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE blog DROP slug');
        $this->addSql('ALTER TABLE blog ALTER thumbnail DROP NOT NULL');
        $this->addSql('ALTER TABLE blog ALTER content SET DEFAULT \'\'');
    }
}
