<div x-cloak x-show="categoryModalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 p-4">
    <div class="w-full max-w-md rounded-xl bg-white p-5 shadow-xl" @click.outside="categoryModalOpen = false">
        <div class="mb-4 flex items-start justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">New Category</h3>
                <p class="mt-1 text-sm text-slate-500">Create a category without leaving this product.</p>
            </div>
            <button type="button" class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700" @click="categoryModalOpen = false">
                <span class="sr-only">Close</span>
                &times;
            </button>
        </div>

        <div class="space-y-4">
            <label class="block text-sm font-medium text-slate-700">
                <span class="mb-1 block">Name</span>
                <input class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" x-model="newCategory.name">
            </label>
            <label class="block text-sm font-medium text-slate-700">
                <span class="mb-1 block">Description</span>
                <input class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" x-model="newCategory.description">
            </label>
            <p class="text-sm text-red-600" x-show="categoryError" x-text="categoryError"></p>
        </div>

        <div class="mt-5 flex justify-end gap-2">
            <button type="button" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" @click="categoryModalOpen = false">Cancel</button>
            <button type="button" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 disabled:opacity-60" :disabled="categorySaving" @click="createCategory()">
                <span x-show="! categorySaving">Save Category</span>
                <span x-show="categorySaving">Saving...</span>
            </button>
        </div>
    </div>
</div>
