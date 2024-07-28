<?php

namespace Modules\UserProject\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserProjectTable extends Migration
{
    public function up()
    {
        // Crear la tabla user_project
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'project_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('project_id', 'project', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_project');

        // Crear función para el trigger
        $this->db->query("
            CREATE OR REPLACE FUNCTION process_user_project_audit() RETURNS TRIGGER AS $$
            BEGIN
                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit (action, \"table\", table_id, new_content, change_date)
                    VALUES ('INSERT', 'user_project', NEW.id, 
                        jsonb_build_object(
                            'id', NEW.id,
                            'user_id', NEW.user_id,
                            'project_id', NEW.project_id
                        )::text, 
                        NOW()
                    );
                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, new_content, change_date)
                    VALUES ('UPDATE', 'user_project', NEW.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'user_id', OLD.user_id,
                            'project_id', OLD.project_id
                        )::text,
                        jsonb_build_object(
                            'id', NEW.id,
                            'user_id', NEW.user_id,
                            'project_id', NEW.project_id
                        )::text,
                        NOW()
                    );
                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, change_date)
                    VALUES ('DELETE', 'user_project', OLD.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'user_id', OLD.user_id,
                            'project_id', OLD.project_id
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
            CREATE TRIGGER tr_user_projects_audit
            AFTER INSERT OR UPDATE OR DELETE ON "user_project"
            FOR EACH ROW EXECUTE FUNCTION process_user_project_audit();
        ');
    }

    public function down()
    {
        // Eliminar el trigger
        $this->db->query('DROP TRIGGER IF EXISTS tr_user_projects_audit ON "user_project";');

        // Eliminar la función
        $this->db->query("DROP FUNCTION IF EXISTS process_user_project_audit();");

        // Eliminar la tabla
        $this->forge->dropTable('user_project');
    }
}
