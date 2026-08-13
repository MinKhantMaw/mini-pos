<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('categories.index', [
            'categories' => Category::withCount('products')->orderBy('name')->paginate(15),
            'category' => new Category,
        ]);
    }

    public function create(): RedirectResponse
    {
        return to_route('categories.index');
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $category = Category::create($data);

        if ($request->expectsJson()) {
            return response()->json(['category' => $category], 201);
        }

        return to_route('categories.index')->with('success', 'Category created.');
    }

    public function show(Category $category): RedirectResponse
    {
        return to_route('categories.index');
    }

    public function edit(Category $category): RedirectResponse
    {
        return to_route('categories.index', ['edit' => $category->id]);
    }

    public function update(Request $request, Category $category): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category)],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $category->update($data);

        if ($request->expectsJson()) {
            return response()->json(['category' => $category]);
        }

        return to_route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->withErrors([
                'category' => 'This category still has products attached. Move those products before deleting it.',
            ])->withInput();
        }

        $category->delete();

        return to_route('categories.index')->with('success', 'Category archived.');
    }
}
