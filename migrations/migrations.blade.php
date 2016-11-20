
asdf
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LarauserTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ config('larauser.table')}}', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->string('username');
            $table->boolean('avatar')->default(false);
            $table->string('timezone')->default('{{ config('app.timezone') }}');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{ config('larauser.table')}}');
    }
}