<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404181215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_folder (user_id INT NOT NULL, folder_id INT NOT NULL, INDEX IDX_89F012F0A76ED395 (user_id), INDEX IDX_89F012F0162CB942 (folder_id), PRIMARY KEY(user_id, folder_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_folder ADD CONSTRAINT FK_89F012F0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_folder ADD CONSTRAINT FK_89F012F0162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CD162CB942');
        $this->addSql('DROP INDEX IDX_ECA209CD162CB942 ON folder');
        $this->addSql('DROP INDEX UNIQ_ECA209CD5E237E06 ON folder');
        $this->addSql('ALTER TABLE folder CHANGE name name VARCHAR(255) NOT NULL, CHANGE folder_id parent_folder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDE76796AC FOREIGN KEY (parent_folder_id) REFERENCES folder (id)');
        $this->addSql('CREATE INDEX IDX_ECA209CDE76796AC ON folder (parent_folder_id)');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418162CB942');
        $this->addSql('DROP INDEX IDX_14B78418162CB942 ON photo');
        $this->addSql('ALTER TABLE photo ADD parent_folder_id INT DEFAULT NULL, ADD source VARCHAR(255) NOT NULL, DROP label, CHANGE description description VARCHAR(255) NOT NULL, CHANGE folder_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418E76796AC FOREIGN KEY (parent_folder_id) REFERENCES folder (id)');
        $this->addSql('CREATE INDEX IDX_14B784187E3C61F9 ON photo (owner_id)');
        $this->addSql('CREATE INDEX IDX_14B78418E76796AC ON photo (parent_folder_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_folder DROP FOREIGN KEY FK_89F012F0A76ED395');
        $this->addSql('ALTER TABLE user_folder DROP FOREIGN KEY FK_89F012F0162CB942');
        $this->addSql('DROP TABLE user_folder');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CDE76796AC');
        $this->addSql('DROP INDEX IDX_ECA209CDE76796AC ON folder');
        $this->addSql('ALTER TABLE folder CHANGE name name VARCHAR(30) NOT NULL, CHANGE parent_folder_id folder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CD162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id)');
        $this->addSql('CREATE INDEX IDX_ECA209CD162CB942 ON folder (folder_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ECA209CD5E237E06 ON folder (name)');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784187E3C61F9');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418E76796AC');
        $this->addSql('DROP INDEX IDX_14B784187E3C61F9 ON photo');
        $this->addSql('DROP INDEX IDX_14B78418E76796AC ON photo');
        $this->addSql('ALTER TABLE photo ADD folder_id INT DEFAULT NULL, ADD label VARCHAR(255) DEFAULT NULL, DROP owner_id, DROP parent_folder_id, DROP source, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id)');
        $this->addSql('CREATE INDEX IDX_14B78418162CB942 ON photo (folder_id)');
    }
}
