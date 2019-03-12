<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312172220 extends AbstractMigration
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
        $this->addSql('CREATE TABLE pfmrules (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, application_level INT NOT NULL, rule VARCHAR(255) NOT NULL, INDEX IDX_DAC6458312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_category (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, key_tag VARCHAR(255) DEFAULT NULL, value_tag VARCHAR(255) NOT NULL, INDEX IDX_307D621A12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_word (id INT AUTO_INCREMENT NOT NULL, word_id INT DEFAULT NULL, key_tag VARCHAR(255) DEFAULT NULL, value_tag VARCHAR(255) NOT NULL, INDEX IDX_2DFECAA7E357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, value VARCHAR(50) NOT NULL, INDEX IDX_C3F1751112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pfmrules ADD CONSTRAINT FK_DAC6458312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE tag_category ADD CONSTRAINT FK_307D621A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE tag_word ADD CONSTRAINT FK_2DFECAA7E357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F1751112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pfmrules DROP FOREIGN KEY FK_DAC6458312469DE2');
        $this->addSql('ALTER TABLE tag_category DROP FOREIGN KEY FK_307D621A12469DE2');
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F1751112469DE2');
        $this->addSql('ALTER TABLE tag_word DROP FOREIGN KEY FK_2DFECAA7E357438D');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE pfmrules');
        $this->addSql('DROP TABLE tag_category');
        $this->addSql('DROP TABLE tag_word');
        $this->addSql('DROP TABLE word');
    }
}
