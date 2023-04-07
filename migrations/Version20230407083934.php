<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407083934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, parent_folder_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, disc VARCHAR(255) NOT NULL, INDEX IDX_63540597E3C61F9 (owner_id), INDEX IDX_6354059E76796AC (parent_folder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_63540597E3C61F9 FOREIGN KEY (owner_id) REFERENCES photographer (id)');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059E76796AC FOREIGN KEY (parent_folder_id) REFERENCES folder (id)');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CDE76796AC');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CD7E3C61F9');
        $this->addSql('DROP INDEX IDX_ECA209CD7E3C61F9 ON folder');
        $this->addSql('DROP INDEX IDX_ECA209CDE76796AC ON folder');
        $this->addSql('ALTER TABLE folder DROP parent_folder_id, DROP owner_id, DROP name, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDBF396750 FOREIGN KEY (id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meta_data ADD files_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE meta_data ADD CONSTRAINT FK_3E558020A3E65B2F FOREIGN KEY (files_id) REFERENCES files (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3E558020A3E65B2F ON meta_data (files_id)');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418E76796AC');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784187E3C61F9');
        $this->addSql('DROP INDEX IDX_14B78418E76796AC ON photo');
        $this->addSql('DROP INDEX IDX_14B784187E3C61F9 ON photo');
        $this->addSql('ALTER TABLE photo DROP owner_id, DROP parent_folder_id, DROP name, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418BF396750 FOREIGN KEY (id) REFERENCES files (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CDBF396750');
        $this->addSql('ALTER TABLE meta_data DROP FOREIGN KEY FK_3E558020A3E65B2F');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418BF396750');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_63540597E3C61F9');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_6354059E76796AC');
        $this->addSql('DROP TABLE files');
        $this->addSql('ALTER TABLE folder ADD parent_folder_id INT DEFAULT NULL, ADD owner_id INT DEFAULT NULL, ADD name VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDE76796AC FOREIGN KEY (parent_folder_id) REFERENCES folder (id)');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CD7E3C61F9 FOREIGN KEY (owner_id) REFERENCES photographer (id)');
        $this->addSql('CREATE INDEX IDX_ECA209CD7E3C61F9 ON folder (owner_id)');
        $this->addSql('CREATE INDEX IDX_ECA209CDE76796AC ON folder (parent_folder_id)');
        $this->addSql('DROP INDEX UNIQ_3E558020A3E65B2F ON meta_data');
        $this->addSql('ALTER TABLE meta_data DROP files_id');
        $this->addSql('ALTER TABLE photo ADD owner_id INT DEFAULT NULL, ADD parent_folder_id INT DEFAULT NULL, ADD name VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418E76796AC FOREIGN KEY (parent_folder_id) REFERENCES folder (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187E3C61F9 FOREIGN KEY (owner_id) REFERENCES photographer (id)');
        $this->addSql('CREATE INDEX IDX_14B78418E76796AC ON photo (parent_folder_id)');
        $this->addSql('CREATE INDEX IDX_14B784187E3C61F9 ON photo (owner_id)');
    }
}
