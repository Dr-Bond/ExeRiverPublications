<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190414150944 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, added_by_id INT DEFAULT NULL, content VARCHAR(4000) NOT NULL, note_type VARCHAR(255) NOT NULL, INDEX IDX_CFBDFA1416A2B381 (book_id), INDEX IDX_CFBDFA1455B127A4 (added_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1416A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1455B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book DROP main_reviewer_comments, DROP secondary_reviewer_comments, DROP editor_comments');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE note');
        $this->addSql('ALTER TABLE book ADD main_reviewer_comments VARCHAR(4000) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD secondary_reviewer_comments VARCHAR(4000) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD editor_comments VARCHAR(4000) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
