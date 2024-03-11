<?php

use App\Models\Organizationtype;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationtypeTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_organization_type', function (Blueprint $table) {
            $table->id('organization_type_id');
            $table->string('name');
            $table->timestamps();
        });

        $types = [
            'Persona juridica', 'Persona natural'
        ];

        foreach ($types as $type) {
            Organizationtype::create(['name' => $type]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_organization_type');
    }
};
