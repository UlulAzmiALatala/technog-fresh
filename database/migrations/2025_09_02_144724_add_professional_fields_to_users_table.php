    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->string('company_name')->nullable()->after('email');
                $table->string('position')->nullable()->after('company_name');
                $table->string('id_card_type')->nullable()->after('position'); // e.g., KTP, Passport, KITAS
                $table->string('id_card_number')->nullable()->after('id_card_type');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['company_name', 'position', 'id_card_type', 'id_card_number']);
            });
        }
    };
