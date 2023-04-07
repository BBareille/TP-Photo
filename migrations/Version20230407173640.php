<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407173640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, parent_folder_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, disc VARCHAR(255) NOT NULL, INDEX IDX_63540597E3C61F9 (owner_id), INDEX IDX_6354059E76796AC (parent_folder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE folder (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta_data (id INT AUTO_INCREMENT NOT NULL, photographer_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, INDEX IDX_3E55802053EC1A21 (photographer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta_data_files (meta_data_id INT NOT NULL, files_id INT NOT NULL, INDEX IDX_E8612E6B7E8EBEDE (meta_data_id), INDEX IDX_E8612E6BA3E65B2F (files_id), PRIMARY KEY(meta_data_id, files_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT NOT NULL, source VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_tags (photo_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_EE8D26D27E9E4C8C (photo_id), INDEX IDX_EE8D26D28D7B4FB4 (tags_id), PRIMARY KEY(photo_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, disc VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_folder (user_id INT NOT NULL, folder_id INT NOT NULL, INDEX IDX_89F012F0A76ED395 (user_id), INDEX IDX_89F012F0162CB942 (folder_id), PRIMARY KEY(user_id, folder_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_63540597E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059E76796AC FOREIGN KEY (parent_folder_id) REFERENCES folder (id)');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDBF396750 FOREIGN KEY (id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meta_data ADD CONSTRAINT FK_3E55802053EC1A21 FOREIGN KEY (photographer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE meta_data_files ADD CONSTRAINT FK_E8612E6B7E8EBEDE FOREIGN KEY (meta_data_id) REFERENCES meta_data (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meta_data_files ADD CONSTRAINT FK_E8612E6BA3E65B2F FOREIGN KEY (files_id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418BF396750 FOREIGN KEY (id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_tags ADD CONSTRAINT FK_EE8D26D27E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_tags ADD CONSTRAINT FK_EE8D26D28D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_folder ADD CONSTRAINT FK_89F012F0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_folder ADD CONSTRAINT FK_89F012F0162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_63540597E3C61F9');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_6354059E76796AC');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CDBF396750');
        $this->addSql('ALTER TABLE meta_data DROP FOREIGN KEY FK_3E55802053EC1A21');
        $this->addSql('ALTER TABLE meta_data_files DROP FOREIGN KEY FK_E8612E6B7E8EBEDE');
        $this->addSql('ALTER TABLE meta_data_files DROP FOREIGN KEY FK_E8612E6BA3E65B2F');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418BF396750');
        $this->addSql('ALTER TABLE photo_tags DROP FOREIGN KEY FK_EE8D26D27E9E4C8C');
        $this->addSql('ALTER TABLE photo_tags DROP FOREIGN KEY FK_EE8D26D28D7B4FB4');
        $this->addSql('ALTER TABLE user_folder DROP FOREIGN KEY FK_89F012F0A76ED395');
        $this->addSql('ALTER TABLE user_folder DROP FOREIGN KEY FK_89F012F0162CB942');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE folder');
        $this->addSql('DROP TABLE meta_data');
        $this->addSql('DROP TABLE meta_data_files');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE photo_tags');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_folder');
    }
}
