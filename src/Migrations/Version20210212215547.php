<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212215547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE stat_detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE stat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE stat_detail (id INT NOT NULL, stat_id INT NOT NULL, player VARCHAR(255) NOT NULL, key_name VARCHAR(255) NOT NULL, key_value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DABEED1F9502F0B ON stat_detail (stat_id)');
        $this->addSql('CREATE TABLE stat (id INT NOT NULL, datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE stat_detail ADD CONSTRAINT FK_DABEED1F9502F0B FOREIGN KEY (stat_id) REFERENCES stat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE stat_detail DROP CONSTRAINT FK_DABEED1F9502F0B');
        $this->addSql('DROP SEQUENCE stat_detail_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE stat_id_seq CASCADE');
        $this->addSql('DROP TABLE stat_detail');
        $this->addSql('DROP TABLE stat');
    }
}
