<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240614074201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_attendance DROP FOREIGN KEY FK_803CE070163DDA15');
        $this->addSql('ALTER TABLE student_attendance DROP FOREIGN KEY FK_803CE070CB944F1A');
        $this->addSql('DROP TABLE attendance');
        $this->addSql('DROP TABLE student_attendance');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attendance (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE student_attendance (student_id INT NOT NULL, attendance_id INT NOT NULL, INDEX IDX_803CE070CB944F1A (student_id), INDEX IDX_803CE070163DDA15 (attendance_id), PRIMARY KEY(student_id, attendance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE student_attendance ADD CONSTRAINT FK_803CE070163DDA15 FOREIGN KEY (attendance_id) REFERENCES attendance (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_attendance ADD CONSTRAINT FK_803CE070CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
