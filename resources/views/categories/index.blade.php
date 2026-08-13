<x-pos-layout>
    <x-slot name="title">Categories</x-slot>

    <div x-data="{
        modalOpen: false,
        mode: 'create',
        action: '{{ route('categories.store') }}',
        form: { name: '', description: '' },
        openCreate() {
            this.mode = 'create';
            this.action = '{{ route('categories.store') }}';
            this.form = { name: '', description: '' };
            this.modalOpen = true;
        },
        openEdit(category) {
            this.mode = 'edit';
            this.action = category.action;
            this.form = { name: category.name, description: category.description || '' };
            this.modalOpen = true;
        }
    }" class="space-y-5">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Product Categories</h2>
                    <p class="mt-1 text-sm text-slate-500">Organize inventory and keep product forms consistent.</p>
                </div>
                <button type="button" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700" @click="openCreate()">
                    Add category
                </button>
            </div>

            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Category</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3">Products</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($categories as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-semibold text-slate-900">{{ $item->name }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $item->description ?: 'No description' }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">{{ $item->products_count }}</span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button type="button" class="font-semibold text-emerald-700 hover:text-emerald-800" @click='openEdit(@js([
                                        "name" => $item->name,
                                        "description" => $item->description,
                                        "action" => route("categories.update", $item),
                                    ]))'>Edit</button>
                                    <form action="{{ route('categories.destroy', $item) }}" method="POST" class="ml-3 inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-red-600 hover:text-red-700" onclick="return confirm('Delete this category?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-8 text-center text-slate-500" colspan="4">No categories yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $categories->links() }}</div>
        </div>

        <div x-cloak x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 p-4">
            <div class="w-full max-w-md rounded-xl bg-white p-5 shadow-xl" @click.outside="modalOpen = false">
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900" x-text="mode === 'create' ? 'Add Category' : 'Edit Category'"></h3>
                        <p class="mt-1 text-sm text-slate-500">Name and optional description only.</p>
                    </div>
                    <button type="button" class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700" @click="modalOpen = false">
                        <span class="sr-only">Close</span>
                        &times;
                    </button>
                </div>

                <form method="POST" :action="action" class="space-y-4">
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <label class="block text-sm font-medium text-slate-700">
                        <span class="mb-1 block">Name</span>
                        <input class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" name="name" x-model="form.name" required>
                    </label>

                    <label class="block text-sm font-medium text-slate-700">
                        <span class="mb-1 block">Description</span>
                        <input class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" name="description" x-model="form.description">
                    </label>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" @click="modalOpen = false">Cancel</button>
                        <button class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700" x-text="mode === 'create' ? 'Save Category' : 'Update Category'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-pos-layout>
