<?php

namespace Modules\UserRole\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserRoleTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('role_id', 'role', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('user_role');

        $this->db->query("
            CREATE OR REPLACE FUNCTION process_user_role_audit() RETURNS TRIGGER AS $$
            BEGIN
                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit (action, \"table\", table_id, new_content, change_date)
                    VALUES ('INSERT', 'user_role', NEW.id, 
                        jsonb_build_object(
                            'id', NEW.id,
                            'user_id', NEW.user_id,
                            'role_id', NEW.role_id
                        )::text, 
                        NOW()
                    );
                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, new_content, change_date)
                    VALUES ('UPDATE', 'user_role', NEW.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'user_id', OLD.user_id,
                            'role_id', OLD.role_id
                        )::text,
                        jsonb_build_object(
                            'id', NEW.id,
                            'user_id', NEW.user_id,
                            'role_id', NEW.role_id
                        )::text,
                        NOW()
                    );
                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, change_date)
                    VALUES ('DELETE', 'user_role', OLD.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'user_id', OLD.user_id,
                            'role_id', OLD.role_id
                        )::text,
                        NOW()
                    );
                END IF;
                RETURN NULL;
            END;
            $$ LANGUAGE plpgsql;
        ");

        $this->db->query('
            CREATE TRIGGER tr_user_roles_audit
            AFTER INSERT OR UPDATE OR DELETE ON "user_role"
            FOR EACH ROW EXECUTE FUNCTION process_user_role_audit();
        ');
    }

    public function down()
    {
        $this->db->query('DROP TRIGGER IF EXISTS tr_user_roles_audit ON "user_role";');

        $this->db->query("DROP FUNCTION IF EXISTS process_user_role_audit();");

        $this->forge->dropTable('user_role');
    }
}
