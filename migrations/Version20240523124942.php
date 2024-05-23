<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523124942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reader (id INT NOT NULL, favorite_category_id INT DEFAULT NULL, INDEX IDX_CC3F893CD154D8A1 (favorite_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE author ADD CONSTRAINT FK_BDAFD8C8BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reader ADD CONSTRAINT FK_CC3F893CD154D8A1 FOREIGN KEY (favorite_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE reader ADD CONSTRAINT FK_CC3F893CBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('ALTER TABLE user ADD discr VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F675F31B');
        $this->addSql('ALTER TABLE author DROP FOREIGN KEY FK_BDAFD8C8BF396750');
        $this->addSql('ALTER TABLE reader DROP FOREIGN KEY FK_CC3F893CD154D8A1');
        $this->addSql('ALTER TABLE reader DROP FOREIGN KEY FK_CC3F893CBF396750');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE reader');
        $this->addSql('DROP INDEX IDX_23A0E66F675F31B ON article');
        $this->addSql('ALTER TABLE article DROP author_id');
        $this->addSql('ALTER TABLE user DROP discr');
    }
}
