<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasColumn('categories', 'description')) {
                $table->string('description')->nullable()->after('name');
            }

            if (! Schema::hasColumn('categories', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        if (! $this->hasNameUniqueIndex()) {
            Schema::table('categories', function (Blueprint $table) {
                $table->unique('name');
            });
        }
    }

    public function down(): void
    {
        if ($this->hasNameUniqueIndex()) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropUnique(['name']);
            });
        }

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('categories', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }

    private function hasNameUniqueIndex(): bool
    {
        if (! method_exists(Schema::getFacadeRoot(), 'getIndexes')) {
            return false;
        }

        return collect(Schema::getIndexes('categories'))->contains(function (array $index): bool {
            return ($index['unique'] ?? false) && ($index['columns'] ?? []) === ['name'];
        });
    }
};
