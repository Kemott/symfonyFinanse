<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201006122023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id VARCHAR(255) NOT NULL, description VARCHAR(30) NOT NULL, bank VARCHAR(30) DEFAULT NULL, account_number BIGINT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id VARCHAR(255) NOT NULL, parent_id VARCHAR(255) DEFAULT NULL, name VARCHAR(30) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE income (id VARCHAR(255) NOT NULL, category_id VARCHAR(255) NOT NULL, account_id VARCHAR(255) NOT NULL, income_date DATE NOT NULL, description VARCHAR(30) NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_3FA862D012469DE2 (category_id), INDEX IDX_3FA862D09B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outcome (id VARCHAR(255) NOT NULL, category_id VARCHAR(255) NOT NULL, account_id VARCHAR(255) NOT NULL, outcome_date DATE NOT NULL, description LONGTEXT NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_30BC6DC212469DE2 (category_id), INDEX IDX_30BC6DC29B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D012469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D09B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE outcome ADD CONSTRAINT FK_30BC6DC212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE outcome ADD CONSTRAINT FK_30BC6DC29B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_3FA862D09B6B5FBA');
        $this->addSql('ALTER TABLE outcome DROP FOREIGN KEY FK_30BC6DC29B6B5FBA');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_3FA862D012469DE2');
        $this->addSql('ALTER TABLE outcome DROP FOREIGN KEY FK_30BC6DC212469DE2');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE income');
        $this->addSql('DROP TABLE outcome');
    }
}
