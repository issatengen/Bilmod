<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250525073601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_code VARCHAR(10) NOT NULL, category_label VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, course_code VARCHAR(10) NOT NULL, course_title VARCHAR(50) NOT NULL, price INT NOT NULL, INDEX IDX_169E6FB9A76ED395 (user_id), INDEX IDX_169E6FB912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE leson (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, course_id INT DEFAULT NULL, leson_code VARCHAR(10) NOT NULL, leson_title VARCHAR(50) NOT NULL, time_allocated INT NOT NULL, INDEX IDX_88C0875EA76ED395 (user_id), INDEX IDX_88C0875E591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role_code VARCHAR(10) NOT NULL, role_label VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, student_code VARCHAR(10) NOT NULL, student_first_name VARCHAR(10) NOT NULL, student_name VARCHAR(100) NOT NULL, student_email VARCHAR(100) NOT NULL, student_photo VARCHAR(150) DEFAULT NULL, student_password VARCHAR(100) NOT NULL, INDEX IDX_B723AF33A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE student_course (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, course_id INT NOT NULL, nber_courses INT NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_98A8B739CB944F1A (student_id), INDEX IDX_98A8B739591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, user_code VARCHAR(10) NOT NULL, user_first_name VARCHAR(100) NOT NULL, user_name VARCHAR(100) NOT NULL, user_email VARCHAR(100) NOT NULL, userphoto VARCHAR(150) DEFAULT NULL, user_password VARCHAR(100) NOT NULL, INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course ADD CONSTRAINT FK_169E6FB9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course ADD CONSTRAINT FK_169E6FB912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE leson ADD CONSTRAINT FK_88C0875EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE leson ADD CONSTRAINT FK_88C0875E591CC992 FOREIGN KEY (course_id) REFERENCES course (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student ADD CONSTRAINT FK_B723AF33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739591CC992 FOREIGN KEY (course_id) REFERENCES course (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course DROP FOREIGN KEY FK_169E6FB912469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE leson DROP FOREIGN KEY FK_88C0875EA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE leson DROP FOREIGN KEY FK_88C0875E591CC992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student DROP FOREIGN KEY FK_B723AF33A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course DROP FOREIGN KEY FK_98A8B739CB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course DROP FOREIGN KEY FK_98A8B739591CC992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE leson
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE role
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE student
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE student_course
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
