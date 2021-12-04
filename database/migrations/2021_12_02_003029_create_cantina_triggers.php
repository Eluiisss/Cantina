<?php

use Illuminate\Database\Migrations\Migration;

class CreateCantinaTriggers extends Migration
{
    public function up()
    {
        $trigger_update_articles_stock = "CREATE TRIGGER update_articles_stock AFTER INSERT ON article_order
        FOR EACH ROW
        BEGIN

        DECLARE v_order_status VARCHAR(45);
        DECLARE v_previous_stock int;

                SELECT o.order_status, a.stock
                FROM orders o, articles a
                WHERE o.id = new.order_id
                AND new.article_id = a.id
                INTO v_order_status, v_previous_stock;

            IF (v_previous_stock-new.quantity) >= 0  THEN
                IF v_order_status ='pendiente' THEN
                    UPDATE `articles` SET `stock` = (v_previous_stock-new.quantity), `deleted_at` = NULL WHERE `articles`.`id` = new.article_id;
                END IF;

            END IF;
        END";

        DB::unprepared("DROP TRIGGER IF EXISTS update_articles_stock");
        DB::unprepared($trigger_update_articles_stock);

        $trigger_restore_articles_stock = "CREATE TRIGGER restore_articles_stock AFTER UPDATE ON orders
                FOR EACH ROW
                BEGIN
                    DECLARE v_order_status VARCHAR(45);

                    SELECT o.order_status
                    FROM orders o
                    WHERE o.id = NEW.id
                    INTO v_order_status;

                    IF v_order_status = 'no_recogido' THEN
                        CALL restore_stock(NEW.id);
                        CALL report_user_order(NEW.user_id);
                    END IF;
                END";

        DB::unprepared("DROP TRIGGER IF EXISTS restore_articles_stock");
        DB::unprepared($trigger_restore_articles_stock);

    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_articles_stock');
        DB::unprepared("DROP TRIGGER IF EXISTS restore_articles_stock");
    }
}
