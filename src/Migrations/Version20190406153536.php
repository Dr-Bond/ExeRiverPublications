<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190406153536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, agent_id INT NOT NULL, main_reviewer_id INT NOT NULL, secondary_reviewer_id INT DEFAULT NULL, editor_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, main_reviewer_comments VARCHAR(4000) DEFAULT NULL, main_reviewer_rating INT DEFAULT NULL, secondary_reviewer_comments VARCHAR(4000) DEFAULT NULL, secondary_reviewer_rating INT DEFAULT NULL, editor_comments VARCHAR(4000) DEFAULT NULL, payment_amount DOUBLE PRECISION DEFAULT NULL, paid_on DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, created_on DATETIME NOT NULL, INDEX IDX_CBE5A331F675F31B (author_id), INDEX IDX_CBE5A3313414710B (agent_id), INDEX IDX_CBE5A331A4D48E80 (main_reviewer_id), INDEX IDX_CBE5A331881CAE92 (secondary_reviewer_id), INDEX IDX_CBE5A3316995AC4C (editor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_id VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, address_line_one VARCHAR(255) DEFAULT NULL, address_line_two VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, county VARCHAR(255) DEFAULT NULL, postcode VARCHAR(8) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manuscript (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, reference VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, uploaded_on DATETIME NOT NULL, revision_number INT NOT NULL, INDEX IDX_5AF919CD16A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3313414710B FOREIGN KEY (agent_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331A4D48E80 FOREIGN KEY (main_reviewer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331881CAE92 FOREIGN KEY (secondary_reviewer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3316995AC4C FOREIGN KEY (editor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE manuscript ADD CONSTRAINT FK_5AF919CD16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE manuscript DROP FOREIGN KEY FK_5AF919CD16A2B381');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3313414710B');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331A4D48E80');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331881CAE92');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3316995AC4C');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE manuscript');
    }
}
