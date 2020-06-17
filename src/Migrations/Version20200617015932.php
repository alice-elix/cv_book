<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617015932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projets CHANGE structure_name structure_name VARCHAR(255) DEFAULT NULL, CHANGE header_structure header_structure VARCHAR(255) DEFAULT NULL, CHANGE catchy_sentence catchy_sentence VARCHAR(255) DEFAULT NULL, CHANGE presentation_paragraph presentation_paragraph LONGTEXT DEFAULT NULL, CHANGE presentation_pict presentation_pict VARCHAR(255) DEFAULT NULL, CHANGE context_paragraph context_paragraph LONGTEXT DEFAULT NULL, CHANGE context_pict context_pict VARCHAR(255) DEFAULT NULL, CHANGE explain_paragraph explain_paragraph LONGTEXT DEFAULT NULL, CHANGE framework_name framework_name VARCHAR(255) DEFAULT NULL, CHANGE framework_pict framework_pict LONGTEXT DEFAULT NULL, CHANGE result_picture result_picture LONGTEXT DEFAULT NULL, CHANGE result_paragraph result_paragraph LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projets CHANGE structure_name structure_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE header_structure header_structure VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE catchy_sentence catchy_sentence VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE presentation_paragraph presentation_paragraph LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE presentation_pict presentation_pict VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE context_paragraph context_paragraph LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE context_pict context_pict VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE explain_paragraph explain_paragraph LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE framework_name framework_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE framework_pict framework_pict VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE result_picture result_picture VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE result_paragraph result_paragraph LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
