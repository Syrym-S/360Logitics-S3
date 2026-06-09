<?php

namespace App\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class FileMigration
{
    public function up()
    {
        if (!Capsule::schema()->hasTable('remote_services')) {
            Capsule::schema()->create('remote_services', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->timestamps();
            });
        }

        if (!Capsule::schema()->hasTable('files')) {
            Capsule::schema()->create('files', function (Blueprint $table) {
                $table->id();
                $table->string('key', 24)->unique();
                $table->unsignedBigInteger('remote_service_id')->nullable();
                $table->string('path');
                $table->string('mime_type')->nullable();
                $table->string('source');
                $table->boolean('is_deleted')->default(false);
                $table->boolean('auth')->default(false);
                $table->unsignedBigInteger('creator')->nullable();
                $table->timestamps();

                $table->foreign('remote_service_id')->references('id')->on('remote_services')->onDelete('set null');
                $table->index(['key']);
            });
        }
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('remote_services');
        Capsule::schema()->dropIfExists('files');
    }
}
