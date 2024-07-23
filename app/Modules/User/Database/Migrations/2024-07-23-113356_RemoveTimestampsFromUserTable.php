<?php

namespace Modules\User\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveTimestampsFromUserTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('user', 'created_at');
        $this->forge->dropColumn('user', 'updated_at');
    }

    public function down()
    {
        $this->forge->addColumn('user', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }
}
