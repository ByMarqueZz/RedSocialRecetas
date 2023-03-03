<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303085322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE foto (id INT AUTO_INCREMENT NOT NULL, receta_id INT DEFAULT NULL, foto VARCHAR(255) NOT NULL, INDEX IDX_EADC3BE554F853F8 (receta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingrediente (id INT AUTO_INCREMENT NOT NULL, ingrediente VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receta (id INT AUTO_INCREMENT NOT NULL, id_usuario_id INT NOT NULL, fecha DATE NOT NULL, tipo_receta VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion LONGTEXT NOT NULL, INDEX IDX_B093494E7EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receta_ingrediente (receta_id INT NOT NULL, ingrediente_id INT NOT NULL, INDEX IDX_F7A6A61354F853F8 (receta_id), INDEX IDX_F7A6A613769E458D (ingrediente_id), PRIMARY KEY(receta_id, ingrediente_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, telefono VARCHAR(9) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE foto ADD CONSTRAINT FK_EADC3BE554F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id)');
        $this->addSql('ALTER TABLE receta ADD CONSTRAINT FK_B093494E7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE receta_ingrediente ADD CONSTRAINT FK_F7A6A61354F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE receta_ingrediente ADD CONSTRAINT FK_F7A6A613769E458D FOREIGN KEY (ingrediente_id) REFERENCES ingrediente (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE foto DROP FOREIGN KEY FK_EADC3BE554F853F8');
        $this->addSql('ALTER TABLE receta DROP FOREIGN KEY FK_B093494E7EB2C349');
        $this->addSql('ALTER TABLE receta_ingrediente DROP FOREIGN KEY FK_F7A6A61354F853F8');
        $this->addSql('ALTER TABLE receta_ingrediente DROP FOREIGN KEY FK_F7A6A613769E458D');
        $this->addSql('DROP TABLE foto');
        $this->addSql('DROP TABLE ingrediente');
        $this->addSql('DROP TABLE receta');
        $this->addSql('DROP TABLE receta_ingrediente');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
