<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406221340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, disc VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_folder (user_id INT NOT NULL, folder_id INT NOT NULL, INDEX IDX_89F012F0A76ED395 (user_id), INDEX IDX_89F012F0162CB942 (folder_id), PRIMARY KEY(user_id, folder_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_folder ADD CONSTRAINT FK_89F012F0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_folder ADD CONSTRAINT FK_89F012F0162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_folder DROP FOREIGN KEY FK_B904427E162CB942');
        $this->addSql('ALTER TABLE client_folder DROP FOREIGN KEY FK_B904427E19EB6921');
        $this->addSql('ALTER TABLE photographer_folder DROP FOREIGN KEY FK_36FBAA3E162CB942');
        $this->addSql('ALTER TABLE photographer_folder DROP FOREIGN KEY FK_36FBAA3E53EC1A21');
        $this->addSql('DROP TABLE client_folder');
        $this->addSql('DROP TABLE photographer_folder');
        $this->addSql('DROP INDEX UNIQ_C7440455E7927C74 ON client');
        $this->addSql('ALTER TABLE client DROP email, DROP roles, DROP password, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_16337A7FE7927C74 ON photographer');
        $this->addSql('ALTER TABLE photographer DROP email, DROP roles, DROP password, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE photographer ADD CONSTRAINT FK_16337A7FBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE photographer DROP FOREIGN KEY FK_16337A7FBF396750');
        $this->addSql('CREATE TABLE client_folder (client_id INT NOT NULL, folder_id INT NOT NULL, INDEX IDX_B904427E162CB942 (folder_id), INDEX IDX_B904427E19EB6921 (client_id), PRIMARY KEY(client_id, folder_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE photographer_folder (photographer_id INT NOT NULL, folder_id INT NOT NULL, INDEX IDX_36FBAA3E162CB942 (folder_id), INDEX IDX_36FBAA3E53EC1A21 (photographer_id), PRIMARY KEY(photographer_id, folder_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE client_folder ADD CONSTRAINT FK_B904427E162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_folder ADD CONSTRAINT FK_B904427E19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photographer_folder ADD CONSTRAINT FK_36FBAA3E162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photographer_folder ADD CONSTRAINT FK_36FBAA3E53EC1A21 FOREIGN KEY (photographer_id) REFERENCES photographer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_folder DROP FOREIGN KEY FK_89F012F0A76ED395');
        $this->addSql('ALTER TABLE user_folder DROP FOREIGN KEY FK_89F012F0162CB942');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_folder');
        $this->addSql('ALTER TABLE client ADD email VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('ALTER TABLE photographer ADD email VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_16337A7FE7927C74 ON photographer (email)');
    }
}
