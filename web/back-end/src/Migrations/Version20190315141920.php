<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315141920 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pfmrule (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, application_level INT NOT NULL, tag_word VARCHAR(255) DEFAULT NULL, tag_category VARCHAR(255) DEFAULT NULL, result VARCHAR(255) NOT NULL, INDEX IDX_A997233E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_association (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, combination LONGTEXT NOT NULL, INDEX IDX_E14C5B2C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, value VARCHAR(50) NOT NULL, tags LONGTEXT DEFAULT NULL, INDEX IDX_C3F1751112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pfmrule ADD CONSTRAINT FK_A997233E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE tag_association ADD CONSTRAINT FK_E14C5B2C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F1751112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pfmrule DROP FOREIGN KEY FK_A997233E12469DE2');
        $this->addSql('ALTER TABLE tag_association DROP FOREIGN KEY FK_E14C5B2C12469DE2');
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F1751112469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE pfmrule');
        $this->addSql('DROP TABLE tag_association');
        $this->addSql('DROP TABLE word');
    }
}
