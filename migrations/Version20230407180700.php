<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407180700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color_folder (id INT NOT NULL, color VARCHAR(15) NOT NULL, label VARCHAR(20) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, rating INT NOT NULL, text VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE color_folder ADD CONSTRAINT FK_C9BC173FBF396750 FOREIGN KEY (id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo ADD color_folder_id INT DEFAULT NULL, ADD isValid TINYINT(1) NOT NULL, ADD isRejected TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784188E221C65 FOREIGN KEY (color_folder_id) REFERENCES color_folder (id)');
        $this->addSql('CREATE INDEX IDX_14B784188E221C65 ON photo (color_folder_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784188E221C65');
        $this->addSql('ALTER TABLE color_folder DROP FOREIGN KEY FK_C9BC173FBF396750');
        $this->addSql('DROP TABLE color_folder');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP INDEX IDX_14B784188E221C65 ON photo');
        $this->addSql('ALTER TABLE photo DROP color_folder_id, DROP isValid, DROP isRejected');
    }
}
