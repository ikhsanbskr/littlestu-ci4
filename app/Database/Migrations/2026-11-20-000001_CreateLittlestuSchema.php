<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLittlestuSchema extends Migration
{
    public function up()
    {
        // 1. Admins
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('admins', true);

        // 2. Site Settings
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'setting_key'   => ['type' => 'VARCHAR', 'constraint' => 80, 'unique' => true],
            'setting_value' => ['type' => 'TEXT', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('site_settings', true);

        // 3. Products
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'slug'            => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'name'            => ['type' => 'VARCHAR', 'constraint' => 150],
            'category'        => ['type' => 'VARCHAR', 'constraint' => 120],
            'category_label'  => ['type' => 'VARCHAR', 'constraint' => 60],
            'badge'           => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'badge_style'     => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'default'],
            'price_label'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'price_min'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'sizes_available' => ['type' => 'VARCHAR', 'constraint' => 80, 'default' => 'S,M,L,2L,3L,4L'],
            'size_note'       => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'Tersedia dalam ukuran S–4L'],
            'description'     => ['type' => 'TEXT', 'null' => true],
            'primary_image'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'secondary_image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'gallery_images'  => ['type' => 'TEXT', 'null' => true],
            'colors'          => ['type' => 'TEXT', 'null' => true],
            'pair_slugs'      => ['type' => 'TEXT', 'null' => true],
            'shopee_url'      => ['type' => 'TEXT', 'null' => true],
            'tiktok_url'      => ['type' => 'TEXT', 'null' => true],
            'is_active'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order'      => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'views_count'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'clicks_shopee'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'clicks_tiktok'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'clicks_wa'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products', true);

        // 4. Lookbook Slides
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pill_label'  => ['type' => 'VARCHAR', 'constraint' => 80],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'description' => ['type' => 'TEXT', 'null' => true],
            'image'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'hotspots'    => ['type' => 'TEXT', 'null' => true],
            'sort_order'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('lookbook_slides', true);

        // 5. Reviews
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'author_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'city'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'product_tag' => ['type' => 'VARCHAR', 'constraint' => 120],
            'rating'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 5],
            'quote'       => ['type' => 'TEXT'],
            'sort_order'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('reviews', true);

        // 6. FAQs
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'question'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'answer'     => ['type' => 'TEXT'],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('faqs', true);

        // 7. Size Guides
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'size_code'    => ['type' => 'VARCHAR', 'constraint' => 30],
            'age_range'    => ['type' => 'VARCHAR', 'constraint' => 50],
            'height_range' => ['type' => 'VARCHAR', 'constraint' => 50],
            'weight_range' => ['type' => 'VARCHAR', 'constraint' => 50],
            'max_height'   => ['type' => 'INT', 'constraint' => 11, 'default' => 999],
            'max_weight'   => ['type' => 'INT', 'constraint' => 11, 'default' => 999],
            'max_age'      => ['type' => 'INT', 'constraint' => 11, 'default' => 99],
            'sort_order'   => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('size_guides', true);

        // 8. Newsletter Subscribers
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 180, 'unique' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('newsletter_subscribers', true);

        // 9. Analytics Events
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'event_type' => ['type' => 'VARCHAR', 'constraint' => 40],
            'product_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'meta'       => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('event_type');
        $this->forge->createTable('analytics_events', true);
    }

    public function down()
    {
        $this->forge->dropTable('analytics_events', true);
        $this->forge->dropTable('newsletter_subscribers', true);
        $this->forge->dropTable('size_guides', true);
        $this->forge->dropTable('faqs', true);
        $this->forge->dropTable('reviews', true);
        $this->forge->dropTable('lookbook_slides', true);
        $this->forge->dropTable('products', true);
        $this->forge->dropTable('site_settings', true);
        $this->forge->dropTable('admins', true);
    }
}
