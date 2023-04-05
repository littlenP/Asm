<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230405053634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE image');
        $this->addSql('ALTER TABLE chef ADD chefimage VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE food ADD foodimage VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD restaurantimage VARCHAR(255) NOT NULL, CHANGE descriptionrestaurant description_restaurant VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, foodimage VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, chefimage VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, restaurantimage VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE chef DROP chefimage');
        $this->addSql('ALTER TABLE food DROP foodimage');
        $this->addSql('ALTER TABLE restaurant DROP restaurantimage, CHANGE description_restaurant descriptionrestaurant VARCHAR(255) DEFAULT NULL');
    }
}
