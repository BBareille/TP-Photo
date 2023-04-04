<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403123013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE folder ADD parent_folder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDE76796AC FOREIGN KEY (parent_folder_id) REFERENCES folder (id)');
        $this->addSql('CREATE INDEX IDX_ECA209CDE76796AC ON folder (parent_folder_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CDE76796AC');
        $this->addSql('DROP INDEX IDX_ECA209CDE76796AC ON folder');
        $this->addSql('ALTER TABLE folder DROP parent_folder_id');
    }
}
