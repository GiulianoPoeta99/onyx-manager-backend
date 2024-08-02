<?php

namespace Modules\Task\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'activity_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('activity_id', 'activity', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('task');

        $this->db->query("
            CREATE OR REPLACE FUNCTION process_task_audit() RETURNS TRIGGER AS $$
            BEGIN
                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit (action, \"table\", table_id, new_content, change_date)
                    VALUES ('INSERT', 'task', NEW.id, 
                        jsonb_build_object(
                            'id', NEW.id,
                            'name', NEW.name,
                            'user_id', NEW.user_id,
                            'activity_id', NEW.activity_id
                        )::text, 
                        NOW()
                    );
                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, new_content, change_date)
                    VALUES ('UPDATE', 'task', NEW.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'name', OLD.name,
                            'user_id', OLD.user_id,
                            'activity_id', OLD.activity_id
                        )::text,
                        jsonb_build_object(
                            'id', NEW.id,
                            'name', NEW.name,
                            'user_id', NEW.user_id,
                            'activity_id', NEW.activity_id
                        )::text,
                        NOW()
                    );
                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, change_date)
                    VALUES ('DELETE', 'task', OLD.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'name', OLD.name,
                            'user_id', OLD.user_id,
                            'activity_id', OLD.activity_id
                        )::text,
                        NOW()
                    );
                END IF;
                RETURN NULL;
            END;
            $$ LANGUAGE plpgsql;
        ");

        $this->db->query('
            CREATE TRIGGER tr_tasks_audit
            AFTER INSERT OR UPDATE OR DELETE ON "task"
            FOR EACH ROW EXECUTE FUNCTION process_task_audit();
        ');
    }

    public function down()
    {
        $this->db->query('DROP TRIGGER IF EXISTS tr_tasks_audit ON "task";');

        $this->db->query("DROP FUNCTION IF EXISTS process_task_audit();");

        $this->forge->dropTable('task');
    }
}
