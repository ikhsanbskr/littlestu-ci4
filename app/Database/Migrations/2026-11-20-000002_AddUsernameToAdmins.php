<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsernameToAdmins extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('username', 'admins')) {
            $this->forge->addColumn('admins', [
                'username' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 80,
                    'unique'     => true,
                    'after'      => 'name',
                    'null'       => true,
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('username', 'admins')) {
            $this->forge->dropColumn('admins', 'username');
        }
    }
}
