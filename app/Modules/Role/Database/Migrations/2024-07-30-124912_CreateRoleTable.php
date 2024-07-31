<?php

namespace Modules\Role\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoleTable extends Migration
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('role');

        $this->db->query("
            CREATE OR REPLACE FUNCTION process_role_audit() RETURNS TRIGGER AS $$
            BEGIN
                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit (action, \"table\", table_id, new_content, change_date)
                    VALUES ('INSERT', 'role', NEW.id, 
                        jsonb_build_object(
                            'id', NEW.id,
                            'name', NEW.name
                        )::text, 
                        NOW()
                    );
                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, new_content, change_date)
                    VALUES ('UPDATE', 'role', NEW.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'name', OLD.name
                        )::text,
                        jsonb_build_object(
                            'id', NEW.id,
                            'name', NEW.name
                        )::text,
                        NOW()
                    );
                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, change_date)
                    VALUES ('DELETE', 'role', OLD.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'name', OLD.name
                        )::text,
                        NOW()
                    );
                END IF;
                RETURN NULL;
            END;
            $$ LANGUAGE plpgsql;
        ");

        $this->db->query('
            CREATE TRIGGER tr_roles_audit
            AFTER INSERT OR UPDATE OR DELETE ON "role"
            FOR EACH ROW EXECUTE FUNCTION process_role_audit();
        ');
    }

    public function down()
    {
        $this->db->query('DROP TRIGGER IF EXISTS tr_roles_audit ON "role";');

        $this->db->query("DROP FUNCTION IF EXISTS process_role_audit();");

        $this->forge->dropTable('role');
    }
}
