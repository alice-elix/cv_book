<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200616120850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE projets (id INT AUTO_INCREMENT NOT NULL, structure_name VARCHAR(255) DEFAULT NULL, header_structure VARCHAR(255) DEFAULT NULL, catchy_sentence VARCHAR(255) DEFAULT NULL, presentation_paragraph LONGTEXT NOT NULL, presentation_pict VARCHAR(255) NOT NULL, context_paragraph LONGTEXT NOT NULL, context_pict VARCHAR(255) NOT NULL, explain_paragraph LONGTEXT NOT NULL, framework_name VARCHAR(255) NOT NULL, framework_pict VARCHAR(255) NOT NULL, result_picture VARCHAR(255) NOT NULL, result_paragraph LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE projets');
    }
}
