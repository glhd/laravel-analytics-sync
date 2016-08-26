<?php echo '<?php' ?>

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GoogleAnalyticsAddClientId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string('{{ $column }}')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('{{ $table }}', function(Blueprint $table) {
            $table->removeColumn('{{ $column }}');
        });
    }
}