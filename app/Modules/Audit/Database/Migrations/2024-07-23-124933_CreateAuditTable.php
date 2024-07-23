<?php

namespace Modules\Audit\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuditTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'action' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'table' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'table_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'old_content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'new_content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'change_date' => [
                'type' => 'DATETIME',
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('audit');
    }

    public function down()
    {
        $this->forge->dropTable('audit');
    }
}
