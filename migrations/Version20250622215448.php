<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250622215448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, label VARCHAR(50) NOT NULL, description VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, code VARCHAR(10) NOT NULL, designation VARCHAR(100) NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, status TINYINT(1) DEFAULT NULL, INDEX IDX_1F1B251E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE leson_module (id INT AUTO_INCREMENT NOT NULL, leson_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, status TINYINT(1) DEFAULT NULL, INDEX IDX_44B0012EEFC50A3E (leson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, code VARCHAR(10) NOT NULL, date DATETIME NOT NULL, status TINYINT(1) DEFAULT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, orders_id INT NOT NULL, quantity INT NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_9CE58EE1126F525E (item_id), INDEX IDX_9CE58EE1CFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, label VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sub_module (id INT AUTO_INCREMENT NOT NULL, module_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_BE756964AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, code VARCHAR(10) DEFAULT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_8D93D649D60322AC (role_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE item ADD CONSTRAINT FK_1F1B251E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE leson_module ADD CONSTRAINT FK_44B0012EEFC50A3E FOREIGN KEY (leson_id) REFERENCES item (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1126F525E FOREIGN KEY (item_id) REFERENCES item (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_module ADD CONSTRAINT FK_BE756964AFC2B591 FOREIGN KEY (module_id) REFERENCES leson_module (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE leson_module DROP FOREIGN KEY FK_44B0012EEFC50A3E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1126F525E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1CFFE9AD6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_module DROP FOREIGN KEY FK_BE756964AFC2B591
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE item
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE leson_module
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `order`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE order_line
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE role
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sub_module
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
