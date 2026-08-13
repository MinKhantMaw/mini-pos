<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('id');
            }
        });

        if (Schema::hasColumn('products', 'category')) {
            DB::table('products')
                ->select('category')
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->distinct()
                ->orderBy('category')
                ->pluck('category')
                ->each(function (string $name): void {
                    $name = trim($name);

                    if ($name === '') {
                        return;
                    }

                    Category::withTrashed()->firstOrCreate(
                        ['name' => $name],
                        ['description' => null],
                    );
                });

            DB::table('products')
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->orderBy('id')
                ->get(['id', 'category'])
                ->each(function (object $product): void {
                    $name = trim($product->category);

                    if ($name === '') {
                        return;
                    }

                    $category = Category::withTrashed()->where('name', $name)->first();

                    if ($category) {
                        DB::table('products')->where('id', $product->id)->update([
                            'category_id' => $category->id,
                        ]);
                    }
                });

            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        if (! Schema::hasColumn('products', 'category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('category')->nullable()->after('sku');
            });
        }

        DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->whereNotNull('products.category_id')
            ->update(['products.category' => DB::raw('categories.name')]);
    }
};
