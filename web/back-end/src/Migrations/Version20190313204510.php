<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190313204510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pfmrule (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, application_level INT NOT NULL, tag_word VARCHAR(255) DEFAULT NULL, tag_category VARCHAR(255) DEFAULT NULL, result VARCHAR(255) NOT NULL, INDEX IDX_A997233E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_association (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, combinattion LONGTEXT NOT NULL, INDEX IDX_E14C5B2C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pfmrule ADD CONSTRAINT FK_A997233E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE tag_association ADD CONSTRAINT FK_E14C5B2C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('DROP TABLE pfmrules');
        $this->addSql('DROP TABLE tag_category');
        $this->addSql('DROP TABLE tag_word');
        $this->addSql('ALTER TABLE word ADD tags LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pfmrules (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, application_level INT NOT NULL, rule VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_DAC6458312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tag_category (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, key_tag VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, value_tag VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_307D621A12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tag_word (id INT AUTO_INCREMENT NOT NULL, word_id INT DEFAULT NULL, key_tag VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, value_tag VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_2DFECAA7E357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pfmrules ADD CONSTRAINT FK_DAC6458312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE tag_category ADD CONSTRAINT FK_307D621A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE tag_word ADD CONSTRAINT FK_2DFECAA7E357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('DROP TABLE pfmrule');
        $this->addSql('DROP TABLE tag_association');
        $this->addSql('ALTER TABLE word DROP tags');
    }
}
