<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201222744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forums (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, INDEX IDX_FE5E5AB8B3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE high_schools (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FCBC4D50A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_activities (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_skills (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_as_job_skill (job_id INT NOT NULL, job_skill_id INT NOT NULL, INDEX IDX_51F6D7B9BE04EA9 (job_id), INDEX IDX_51F6D7B932C26439 (job_skill_id), PRIMARY KEY(job_id, job_skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_as_job_activity (job_id INT NOT NULL, job_activity_id INT NOT NULL, INDEX IDX_CF98CC17BE04EA9 (job_id), INDEX IDX_CF98CC17E2AC7BDF (job_activity_id), PRIMARY KEY(job_id, job_activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resources (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, url LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename LONGTEXT DEFAULT NULL, original_name LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, floor VARCHAR(255) NOT NULL, capacity INT NOT NULL, available TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speakers (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_21C01B1E979B1AD6 (company_id), UNIQUE INDEX UNIQ_21C01B1EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, high_school_id INT DEFAULT NULL, user_id INT NOT NULL, degree VARCHAR(50) NOT NULL, INDEX IDX_A4698DB23CB84411 (high_school_id), UNIQUE INDEX UNIQ_A4698DB2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey_answers (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, survey_question_id INT DEFAULT NULL, answer LONGTEXT NOT NULL, INDEX IDX_14FCE5BDCB944F1A (student_id), INDEX IDX_14FCE5BDA6DF29BA (survey_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey_questions (id INT AUTO_INCREMENT NOT NULL, survey_id INT DEFAULT NULL, question VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, INDEX IDX_2F8A16F8B3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveys (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(80) NOT NULL, lastname VARCHAR(80) NOT NULL, telephone VARCHAR(13) NOT NULL, is_hashed TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_reservations (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, workshop_id INT NOT NULL, INDEX IDX_911491C5CB944F1A (student_id), INDEX IDX_911491C51FDCE57C (workshop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_sectors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshops (id INT AUTO_INCREMENT NOT NULL, sector_id INT NOT NULL, forum_id INT DEFAULT NULL, room_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, INDEX IDX_879CA6A0DE95C867 (sector_id), INDEX IDX_879CA6A029CCBAD0 (forum_id), INDEX IDX_879CA6A054177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_as_speaker (workshop_id INT NOT NULL, speaker_id INT NOT NULL, INDEX IDX_F99084381FDCE57C (workshop_id), INDEX IDX_F9908438D04A0F27 (speaker_id), PRIMARY KEY(workshop_id, speaker_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_as_resource (workshop_id INT NOT NULL, resource_id INT NOT NULL, INDEX IDX_AEA408191FDCE57C (workshop_id), INDEX IDX_AEA4081989329D25 (resource_id), PRIMARY KEY(workshop_id, resource_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_as_job (workshop_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_A665BA741FDCE57C (workshop_id), INDEX IDX_A665BA74BE04EA9 (job_id), PRIMARY KEY(workshop_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forums ADD CONSTRAINT FK_FE5E5AB8B3FE509D FOREIGN KEY (survey_id) REFERENCES surveys (id)');
        $this->addSql('ALTER TABLE high_schools ADD CONSTRAINT FK_FCBC4D50A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE job_as_job_skill ADD CONSTRAINT FK_51F6D7B9BE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_as_job_skill ADD CONSTRAINT FK_51F6D7B932C26439 FOREIGN KEY (job_skill_id) REFERENCES job_skills (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_as_job_activity ADD CONSTRAINT FK_CF98CC17BE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_as_job_activity ADD CONSTRAINT FK_CF98CC17E2AC7BDF FOREIGN KEY (job_activity_id) REFERENCES job_activities (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE speakers ADD CONSTRAINT FK_21C01B1E979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE speakers ADD CONSTRAINT FK_21C01B1EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB23CB84411 FOREIGN KEY (high_school_id) REFERENCES high_schools (id)');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE survey_answers ADD CONSTRAINT FK_14FCE5BDCB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE survey_answers ADD CONSTRAINT FK_14FCE5BDA6DF29BA FOREIGN KEY (survey_question_id) REFERENCES survey_questions (id)');
        $this->addSql('ALTER TABLE survey_questions ADD CONSTRAINT FK_2F8A16F8B3FE509D FOREIGN KEY (survey_id) REFERENCES surveys (id)');
        $this->addSql('ALTER TABLE workshop_reservations ADD CONSTRAINT FK_911491C5CB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE workshop_reservations ADD CONSTRAINT FK_911491C51FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshops (id)');
        $this->addSql('ALTER TABLE workshops ADD CONSTRAINT FK_879CA6A0DE95C867 FOREIGN KEY (sector_id) REFERENCES workshop_sectors (id)');
        $this->addSql('ALTER TABLE workshops ADD CONSTRAINT FK_879CA6A029CCBAD0 FOREIGN KEY (forum_id) REFERENCES forums (id)');
        $this->addSql('ALTER TABLE workshops ADD CONSTRAINT FK_879CA6A054177093 FOREIGN KEY (room_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE workshop_as_speaker ADD CONSTRAINT FK_F99084381FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshops (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workshop_as_speaker ADD CONSTRAINT FK_F9908438D04A0F27 FOREIGN KEY (speaker_id) REFERENCES speakers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workshop_as_resource ADD CONSTRAINT FK_AEA408191FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshops (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workshop_as_resource ADD CONSTRAINT FK_AEA4081989329D25 FOREIGN KEY (resource_id) REFERENCES resources (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workshop_as_job ADD CONSTRAINT FK_A665BA741FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshops (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workshop_as_job ADD CONSTRAINT FK_A665BA74BE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forums DROP FOREIGN KEY FK_FE5E5AB8B3FE509D');
        $this->addSql('ALTER TABLE high_schools DROP FOREIGN KEY FK_FCBC4D50A76ED395');
        $this->addSql('ALTER TABLE job_as_job_skill DROP FOREIGN KEY FK_51F6D7B9BE04EA9');
        $this->addSql('ALTER TABLE job_as_job_skill DROP FOREIGN KEY FK_51F6D7B932C26439');
        $this->addSql('ALTER TABLE job_as_job_activity DROP FOREIGN KEY FK_CF98CC17BE04EA9');
        $this->addSql('ALTER TABLE job_as_job_activity DROP FOREIGN KEY FK_CF98CC17E2AC7BDF');
        $this->addSql('ALTER TABLE speakers DROP FOREIGN KEY FK_21C01B1E979B1AD6');
        $this->addSql('ALTER TABLE speakers DROP FOREIGN KEY FK_21C01B1EA76ED395');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB23CB84411');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2A76ED395');
        $this->addSql('ALTER TABLE survey_answers DROP FOREIGN KEY FK_14FCE5BDCB944F1A');
        $this->addSql('ALTER TABLE survey_answers DROP FOREIGN KEY FK_14FCE5BDA6DF29BA');
        $this->addSql('ALTER TABLE survey_questions DROP FOREIGN KEY FK_2F8A16F8B3FE509D');
        $this->addSql('ALTER TABLE workshop_reservations DROP FOREIGN KEY FK_911491C5CB944F1A');
        $this->addSql('ALTER TABLE workshop_reservations DROP FOREIGN KEY FK_911491C51FDCE57C');
        $this->addSql('ALTER TABLE workshops DROP FOREIGN KEY FK_879CA6A0DE95C867');
        $this->addSql('ALTER TABLE workshops DROP FOREIGN KEY FK_879CA6A029CCBAD0');
        $this->addSql('ALTER TABLE workshops DROP FOREIGN KEY FK_879CA6A054177093');
        $this->addSql('ALTER TABLE workshop_as_speaker DROP FOREIGN KEY FK_F99084381FDCE57C');
        $this->addSql('ALTER TABLE workshop_as_speaker DROP FOREIGN KEY FK_F9908438D04A0F27');
        $this->addSql('ALTER TABLE workshop_as_resource DROP FOREIGN KEY FK_AEA408191FDCE57C');
        $this->addSql('ALTER TABLE workshop_as_resource DROP FOREIGN KEY FK_AEA4081989329D25');
        $this->addSql('ALTER TABLE workshop_as_job DROP FOREIGN KEY FK_A665BA741FDCE57C');
        $this->addSql('ALTER TABLE workshop_as_job DROP FOREIGN KEY FK_A665BA74BE04EA9');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE forums');
        $this->addSql('DROP TABLE high_schools');
        $this->addSql('DROP TABLE job_activities');
        $this->addSql('DROP TABLE job_skills');
        $this->addSql('DROP TABLE jobs');
        $this->addSql('DROP TABLE job_as_job_skill');
        $this->addSql('DROP TABLE job_as_job_activity');
        $this->addSql('DROP TABLE resources');
        $this->addSql('DROP TABLE rooms');
        $this->addSql('DROP TABLE speakers');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE survey_answers');
        $this->addSql('DROP TABLE survey_questions');
        $this->addSql('DROP TABLE surveys');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE workshop_reservations');
        $this->addSql('DROP TABLE workshop_sectors');
        $this->addSql('DROP TABLE workshops');
        $this->addSql('DROP TABLE workshop_as_speaker');
        $this->addSql('DROP TABLE workshop_as_resource');
        $this->addSql('DROP TABLE workshop_as_job');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
