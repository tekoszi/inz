<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191119101930 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shelfs (id INT AUTO_INCREMENT NOT NULL, rack_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, barcode INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, warehouse_id INT NOT NULL, row_id INT NOT NULL, rack_id INT NOT NULL, shelf_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rows (id INT AUTO_INCREMENT NOT NULL, warehouse_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_items (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warehouses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE racks (id INT AUTO_INCREMENT NOT NULL, row_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
//        $this->addSql('ALTER TABLE shelfs ADD FOREIGN KEY (rack_id) REFERENCES racks(id)');
//        $this->addSql('ALTER TABLE racks ADD FOREIGN KEY (row_id) REFERENCES rows(id)');
//        $this->addSql('ALTER TABLE rows ADD FOREIGN KEY (warehouse_id) REFERENCES warehouses(id)');
//        $this->addSql('ALTER TABLE products ADD FOREIGN KEY (warehouse_id) REFERENCES warehouses(id)');
//        $this->addSql('ALTER TABLE products ADD FOREIGN KEY (rack_id) REFERENCES racks(id)');
//        $this->addSql('ALTER TABLE products ADD FOREIGN KEY (row_id) REFERENCES rows(id)');
//        $this->addSql('ALTER TABLE products ADD FOREIGN KEY (shelf_id) REFERENCES shelfs(id)');
//        $this->addSql('ALTER TABLE order_items ADD FOREIGN KEY (product_id) REFERENCES products(id)');
//        $this->addSql('ALTER TABLE order_items ADD FOREIGN KEY (order_id) REFERENCES orders(id)');
//        $this->addSql('ALTER TABLE orders ADD FOREIGN KEY (user_id) REFERENCES users(id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE shelfs');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE rows');
        $this->addSql('DROP TABLE order_items');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE warehouses');
        $this->addSql('DROP TABLE racks');
    }
}
