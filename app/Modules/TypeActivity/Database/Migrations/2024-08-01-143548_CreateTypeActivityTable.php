<?php

namespace Modules\TypeActivity\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypeActivityTable extends Migration
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('project_id', 'project', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('type_activity');

        $this->db->query("
            CREATE OR REPLACE FUNCTION process_type_activity_audit() RETURNS TRIGGER AS $$
            BEGIN
                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit (action, \"table\", table_id, new_content, change_date)
                    VALUES ('INSERT', 'type_activity', NEW.id, 
                        jsonb_build_object(
                            'id', NEW.id,
                            'name', NEW.name,
                            'project_id', NEW.project_id
                        )::text, 
                        NOW()
                    );
                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, new_content, change_date)
                    VALUES ('UPDATE', 'type_activity', NEW.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'name', OLD.name,
                            'project_id', OLD.project_id
                        )::text,
                        jsonb_build_object(
                            'id', NEW.id,
                            'name', NEW.name,
                            'project_id', NEW.project_id
                        )::text,
                        NOW()
                    );
                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, change_date)
                    VALUES ('DELETE', 'type_activity', OLD.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'name', OLD.name,
                            'project_id', OLD.project_id
                        )::text,
                        NOW()
                    );
                END IF;
                RETURN NULL;
            END;
            $$ LANGUAGE plpgsql;
        ");

        $this->db->query('
            CREATE TRIGGER tr_types_activities_audit
            AFTER INSERT OR UPDATE OR DELETE ON "type_activity"
            FOR EACH ROW EXECUTE FUNCTION process_type_activity_audit();
        ');
    }

    public function down()
    {
        $this->db->query('DROP TRIGGER IF EXISTS tr_types_activities_audit ON "type_activity";');

        $this->db->query("DROP FUNCTION IF EXISTS process_type_activity_audit();");

        $this->forge->dropTable('type_activity');
    }
}
