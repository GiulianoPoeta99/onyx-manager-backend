<?php

namespace Modules\State\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStateTable extends Migration
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
            'type_state_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'task_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('type_state_id', 'type_state', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('task_id', 'task', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('state');

        $this->db->query("
            CREATE OR REPLACE FUNCTION process_state_audit() RETURNS TRIGGER AS $$
            BEGIN
                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit (action, \"table\", table_id, new_content, change_date)
                    VALUES ('INSERT', 'state', NEW.id, 
                        jsonb_build_object(
                            'id', NEW.id,
                            'type_state_id', NEW.type_state_id,
                            'task_id', NEW.task_id,
                            'user_id', NEW.user_id
                        )::text, 
                        NOW()
                    );
                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, new_content, change_date)
                    VALUES ('UPDATE', 'state', NEW.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'type_state_id', OLD.type_state_id,
                            'task_id', OLD.task_id,
                            'user_id', OLD.user_id
                        )::text,
                        jsonb_build_object(
                            'id', NEW.id,
                            'type_state_id', NEW.type_state_id,
                            'task_id', NEW.task_id,
                            'user_id', NEW.user_id
                        )::text,
                        NOW()
                    );
                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, change_date)
                    VALUES ('DELETE', 'state', OLD.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'type_state_id', OLD.type_state_id,
                            'task_id', OLD.task_id,
                            'user_id', OLD.user_id
                        )::text,
                        NOW()
                    );
                END IF;
                RETURN NULL;
            END;
            $$ LANGUAGE plpgsql;
        ");

        $this->db->query('
            CREATE TRIGGER tr_states_audit
            AFTER INSERT OR UPDATE OR DELETE ON "state"
            FOR EACH ROW EXECUTE FUNCTION process_state_audit();
        ');
    }

    public function down()
    {
        $this->db->query('DROP TRIGGER IF EXISTS tr_states_audit ON "state";');

        $this->db->query("DROP FUNCTION IF EXISTS process_state_audit();");

        $this->forge->dropTable('state');
    }
}
