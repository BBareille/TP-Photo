<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404201346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CD4584665A');
        $this->addSql('DROP INDEX IDX_ECA209CD4584665A ON folder');
        $this->addSql('ALTER TABLE folder CHANGE product_id parentFolder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CD25D0D250 FOREIGN KEY (parentFolder_id) REFERENCES folder (id)');
        $this->addSql('CREATE INDEX IDX_ECA209CD25D0D250 ON folder (parentFolder_id)');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784184584665A');
        $this->addSql('DROP INDEX IDX_14B784184584665A ON photo');
        $this->addSql('ALTER TABLE photo CHANGE product_id parentFolder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841825D0D250 FOREIGN KEY (parentFolder_id) REFERENCES folder (id)');
        $this->addSql('CREATE INDEX IDX_14B7841825D0D250 ON photo (parentFolder_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CD25D0D250');
        $this->addSql('DROP INDEX IDX_ECA209CD25D0D250 ON folder');
        $this->addSql('ALTER TABLE folder CHANGE parentFolder_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CD4584665A FOREIGN KEY (product_id) REFERENCES folder (id)');
        $this->addSql('CREATE INDEX IDX_ECA209CD4584665A ON folder (product_id)');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841825D0D250');
        $this->addSql('DROP INDEX IDX_14B7841825D0D250 ON photo');
        $this->addSql('ALTER TABLE photo CHANGE parentFolder_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784184584665A FOREIGN KEY (product_id) REFERENCES folder (id)');
        $this->addSql('CREATE INDEX IDX_14B784184584665A ON photo (product_id)');
    }
}
