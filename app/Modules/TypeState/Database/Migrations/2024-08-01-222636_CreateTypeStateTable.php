<?php

namespace Modules\TypeState\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypeStateTable extends Migration
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
            'project_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'type_activity_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('project_id', 'project', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('type_activity_id', 'type_activity', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('type_state');

        $this->db->query("
            CREATE OR REPLACE FUNCTION process_type_state_audit() RETURNS TRIGGER AS $$
            BEGIN
                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit (action, \"table\", table_id, new_content, change_date)
                    VALUES ('INSERT', 'type_state', NEW.id, 
                        jsonb_build_object(
                            'id', NEW.id,
                            'name', NEW.name,
                            'project_id', NEW.project_id,
                            'type_activity_id', NEW.type_activity_id
                        )::text, 
                        NOW()
                    );
                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, new_content, change_date)
                    VALUES ('UPDATE', 'type_state', NEW.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'name', OLD.name,
                            'project_id', OLD.project_id,
                            'type_activity_id', OLD.type_activity_id
                        )::text,
                        jsonb_build_object(
                            'id', NEW.id,
                            'name', NEW.name,
                            'project_id', NEW.project_id,
                            'type_activity_id', NEW.type_activity_id
                        )::text,
                        NOW()
                    );
                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, change_date)
                    VALUES ('DELETE', 'type_state', OLD.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'name', OLD.name,
                            'project_id', OLD.project_id,
                            'type_activity_id', OLD.type_activity_id
                        )::text,
                        NOW()
                    );
                END IF;
                RETURN NULL;
            END;
            $$ LANGUAGE plpgsql;
        ");

        $this->db->query('
            CREATE TRIGGER tr_types_states_audit
            AFTER INSERT OR UPDATE OR DELETE ON "type_state"
            FOR EACH ROW EXECUTE FUNCTION process_type_state_audit();
        ');
    }

    public function down()
    {
        $this->db->query('DROP TRIGGER IF EXISTS tr_types_states_audit ON "type_state";');

        $this->db->query("DROP FUNCTION IF EXISTS process_type_state_audit();");

        $this->forge->dropTable('type_state');
    }
}
