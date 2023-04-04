<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404115402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photo_tags (photo_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_EE8D26D27E9E4C8C (photo_id), INDEX IDX_EE8D26D28D7B4FB4 (tags_id), PRIMARY KEY(photo_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo_tags ADD CONSTRAINT FK_EE8D26D27E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_tags ADD CONSTRAINT FK_EE8D26D28D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags DROP FOREIGN KEY FK_6FBC94267E9E4C8C');
        $this->addSql('DROP INDEX IDX_6FBC94267E9E4C8C ON tags');
        $this->addSql('ALTER TABLE tags DROP photo_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo_tags DROP FOREIGN KEY FK_EE8D26D27E9E4C8C');
        $this->addSql('ALTER TABLE photo_tags DROP FOREIGN KEY FK_EE8D26D28D7B4FB4');
        $this->addSql('DROP TABLE photo_tags');
        $this->addSql('ALTER TABLE tags ADD photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tags ADD CONSTRAINT FK_6FBC94267E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('CREATE INDEX IDX_6FBC94267E9E4C8C ON tags (photo_id)');
    }
}
