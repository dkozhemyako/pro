<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('books_with_new_column_and_index', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('name', 100)->index(); //new index
                $table->year('year');
                $table->unsignedSmallInteger('pages');
                $table->smallInteger('category_id');
                $table->enum('lang', ['en', 'ua', 'pl', 'de']);
                $table->integer('user_id')->nullable(); //new column
        });

            DB::unprepared(
                '
                CREATE OR REPLACE FUNCTION after_insert_book()
                RETURNS TRIGGER AS $$
                BEGIN
                INSERT INTO books_with_new_column_and_index
                (id, created_at, name, year, pages, category_id, lang, user_id)
                VALUES (new.id, new.created_at, new.name, new.year, new.pages, new.category_id, new.lang, null);
                RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;

                CREATE TRIGGER insert_replace
                    AFTER INSERT ON books
                    FOR EACH ROW
                    EXECUTE FUNCTION after_insert_book();

                CREATE OR REPLACE FUNCTION after_update_book()
                RETURNS TRIGGER AS $$
                BEGIN
                UPDATE books_with_new_column_and_index
                SET name = new.name,
                    year = new.year,
                    lang = new.lang,
                    pages = new.pages
                WHERE id = new.id;
                RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;

                CREATE TRIGGER update_replace
                    AFTER UPDATE ON books
                    FOR EACH ROW
                    EXECUTE FUNCTION after_update_book();

                CREATE OR REPLACE FUNCTION after_delete_book()
                    RETURNS TRIGGER AS $$
                BEGIN
                DELETE FROM books_with_new_column_and_index
                WHERE id = new.id;
                return new;
                END;
                $$ LANGUAGE plpgsql;

                CREATE TRIGGER delete_replace
                    AFTER DELETE ON books
                    FOR EACH ROW
                    EXECUTE FUNCTION after_delete_book();
                '
            );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_book_with_new_columm_and_index');
    }
};
