<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407082217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meta_data (id INT AUTO_INCREMENT NOT NULL, photographer_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, INDEX IDX_3E55802053EC1A21 (photographer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meta_data ADD CONSTRAINT FK_3E55802053EC1A21 FOREIGN KEY (photographer_id) REFERENCES photographer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meta_data DROP FOREIGN KEY FK_3E55802053EC1A21');
        $this->addSql('DROP TABLE meta_data');
    }
}
