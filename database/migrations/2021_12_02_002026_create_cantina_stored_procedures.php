<?php

use Illuminate\Database\Migrations\Migration;

class CreateCantinaStoredProcedures extends Migration
{
    public function up()
    {
        $procedure_restore_stock = "CREATE PROCEDURE restore_stock (IN in_order_id int)
        BEGIN
        DECLARE v_article_id int;
        DECLARE v_quantity int;
        DECLARE v_current_stock int;
        DECLARE v_end_loop INTEGER DEFAULT 0;

        DECLARE cursor_articles_orders CURSOR FOR

            select a.id, a.stock,ao.quantity from article_order ao, orders o, articles a
            where ao.order_id = o.id
            and ao.article_id = a.id
            and ao.order_id = in_order_id;

        DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_end_loop = 1;

        OPEN cursor_articles_orders;
          articles_orders_loop: LOOP
            FETCH cursor_articles_orders INTO v_article_id, v_quantity, v_current_stock;
            IF v_end_loop = 1 THEN
               LEAVE articles_orders_loop;
            END IF;
                UPDATE `articles` SET `stock` = (v_current_stock + v_quantity), `deleted_at` = NULL WHERE `articles`.`id` = v_article_id;
          END LOOP articles_orders_loop;

          CLOSE cursor_articles_orders;
        END";

        DB::unprepared("DROP PROCEDURE IF EXISTS restore_stock");
        DB::unprepared($procedure_restore_stock);
    }

    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS restore_stock");
    }
}
