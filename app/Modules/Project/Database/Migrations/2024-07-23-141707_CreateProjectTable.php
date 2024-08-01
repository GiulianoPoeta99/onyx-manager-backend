<?php

namespace Modules\Project\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectTable extends Migration
{
    public function up()
    {
        // Crear la tabla project
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('project');

        // Crear función para el trigger
        $this->db->query("
            CREATE OR REPLACE FUNCTION process_project_audit() RETURNS TRIGGER AS $$
            BEGIN
                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit (action, \"table\", table_id, new_content, change_date)
                    VALUES ('INSERT', 'project', NEW.id, 
                        jsonb_build_object(
                            'id', NEW.id,
                            'name', NEW.name,
                            'user_id', NEW.user_id
                        )::text, 
                        NOW()
                    );
                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, new_content, change_date)
                    VALUES ('UPDATE', 'project', NEW.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'name', OLD.name,
                            'user_id', OLD.user_id
                        )::text,
                        jsonb_build_object(
                            'id', NEW.id,
                            'name', NEW.name,
                            'user_id', NEW.user_id
                        )::text,
                        NOW()
                    );
                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, change_date)
                    VALUES ('DELETE', 'project', OLD.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'name', OLD.name,
                            'user_id', OLD.user_id
                        )::text,
                        NOW()
                    );
                END IF;
                RETURN NULL;
            END;
            $$ LANGUAGE plpgsql;
        ");

        // Crear trigger
        $this->db->query('
            CREATE TRIGGER tr_projects_audit
            AFTER INSERT OR UPDATE OR DELETE ON "project"
            FOR EACH ROW EXECUTE FUNCTION process_project_audit();
        ');
    }

    public function down()
    {
        // Eliminar el trigger
        $this->db->query('DROP TRIGGER IF EXISTS tr_projects_audit ON "project";');

        // Eliminar la función
        $this->db->query("DROP FUNCTION IF EXISTS process_project_audit();");

        // Eliminar la tabla
        $this->forge->dropTable('project');
    }
}
