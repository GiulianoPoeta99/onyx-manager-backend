<?php

namespace Modules\User\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTriggersForAuditInUserTable extends Migration
{
    public function up()
    {
        // Crear función para el trigger
        $this->db->query("
            CREATE OR REPLACE FUNCTION process_user_audit() RETURNS TRIGGER AS $$
            BEGIN
                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit (action, \"table\", table_id, new_content, change_date)
                    VALUES ('INSERT', 'user', NEW.id, 
                        jsonb_build_object(
                            'id', NEW.id,
                            'email', NEW.email,
                            'first_name', NEW.first_name,
                            'last_name', NEW.last_name
                            -- No incluimos la contraseña por razones de seguridad
                        )::text, 
                        NOW()
                    );
                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, new_content, change_date)
                    VALUES ('UPDATE', 'user', NEW.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'email', OLD.email,
                            'first_name', OLD.first_name,
                            'last_name', OLD.last_name
                        )::text,
                        jsonb_build_object(
                            'id', NEW.id,
                            'email', NEW.email,
                            'first_name', NEW.first_name,
                            'last_name', NEW.last_name
                        )::text,
                        NOW()
                    );
                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit (action, \"table\", table_id, old_content, change_date)
                    VALUES ('DELETE', 'user', OLD.id, 
                        jsonb_build_object(
                            'id', OLD.id,
                            'email', OLD.email,
                            'first_name', OLD.first_name,
                            'last_name', OLD.last_name
                        )::text,
                        NOW()
                    );
                END IF;
                RETURN NULL;
            END;
            $$ LANGUAGE plpgsql;
        ");

        // Crear triggers
        $this->db->query('
            CREATE TRIGGER tr_users_audit
            AFTER INSERT OR UPDATE OR DELETE ON "user"
            FOR EACH ROW EXECUTE FUNCTION process_user_audit();
        ');
    }

    public function down()
    {
        // Eliminar el trigger
        $this->db->query('DROP TRIGGER IF EXISTS tr_users_audit ON "user";');
        
        // Eliminar la función
        $this->db->query("DROP FUNCTION IF EXISTS process_user_audit();");
    }
}