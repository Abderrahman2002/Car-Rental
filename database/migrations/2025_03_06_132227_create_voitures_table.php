    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up()
        {
            Schema::create('voitures', function (Blueprint $table) {
                $table->id();
                $table->string('matricule', 50)->unique();
                $table->string('modele', 100);
                $table->enum('carburant', ['essence', 'diesel', 'électrique', 'hybride']);
                $table->decimal('prix', 8, 2); // Removed ->after('carburant')
                $table->string('photo', 255)->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('voitures');
            
        }
    };
