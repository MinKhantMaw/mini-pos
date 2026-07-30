<x-pos-layout>
    <x-slot name="title">New Purchase</x-slot>
    <div x-data="purchaseForm({{ Js::from($products) }})" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <form method="POST" action="{{ route('purchases.store') }}" class="space-y-4">
            @csrf
            <div class="grid gap-4 md:grid-cols-3">
                <label class="block text-sm font-medium text-slate-600">
                    <span class="mb-1 block">Supplier name</span>
                    <input class="w-full rounded-lg border-slate-300" name="supplier_name" required>
                </label>
                <label class="block text-sm font-medium text-slate-600">
                    <span class="mb-1 block">Purchase date</span>
                    <input class="w-full rounded-lg border-slate-300" type="date" name="purchase_date"
                        value="{{ now()->toDateString() }}" required>
                </label>
                <label class="block text-sm font-medium text-slate-600">
                    <span class="mb-1 block">Payment status</span>
                    <select class="w-full rounded-lg border-slate-300" name="payment_status">
                        <option value="unpaid">Unpaid</option>
                        <option value="paid">Paid</option>
                        <option value="partial">Partial</option>
                    </select>
                </label>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <div class="mb-3 flex items-center justify-between">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Items</h3>
                    <button type="button"
                        class="rounded-full bg-emerald-600 px-3 py-1.5 text-sm font-semibold text-white"
                        @click="addLine()">+ Add item</button>
                </div>
                <div class="grid gap-2">
                    <template x-for="(item, index) in items" :key="index">
                        <div
                            class="grid gap-2 rounded-lg border border-slate-200 bg-white p-3 md:grid-cols-[1.4fr_0.8fr_0.8fr_auto]">
                            <select class="rounded-lg border-slate-300" :name="`items[${index}][product_id]`"
                                x-model="item.product_id" @change="setPrice(item)">
                                <option value="">Choose product</option>
                                <template x-for="product in products" :key="product.id">
                                    <option :value="product.id" x-text="product.name"></option>
                                </template>
                            </select>
                            <input class="rounded-lg border-slate-300" type="number" min="1"
                                :name="`items[${index}][quantity]`" x-model.number="item.quantity">
                            <input class="rounded-lg border-slate-300" type="number" step="0.01" min="0"
                                :name="`items[${index}][cost_price]`" x-model.number="item.price">
                            <button type="button"
                                class="rounded-lg border border-slate-200 px-3 text-sm font-medium text-rose-600"
                                @click="removeLine(index)">Remove</button>
                        </div>
                    </template>
                </div>
            </div>
            <label class="block text-sm font-medium text-slate-600">
                <span class="mb-1 block">Notes</span>
                <textarea class="w-full rounded-lg border-slate-300" name="notes"></textarea>
            </label>
            <div class="rounded-lg border border-slate-200 p-4 text-sm text-slate-600">
                <div class="flex justify-between"><span>Estimated total</span><span class="font-semibold"
                        x-text="formatCurrency(total())"></span></div>
            </div>
            <button class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Record
                purchase</button>
        </form>
    </div>

    <script>
        function purchaseForm(products) {
            return {
                products,
                items: [{
                    product_id: '',
                    quantity: 1,
                    price: 0
                }],
                addLine() {
                    this.items.push({
                        product_id: '',
                        quantity: 1,
                        price: 0
                    });
                },
                removeLine(index) {
                    this.items.splice(index, 1);
                },
                setPrice(item) {
                    const product = this.products.find((entry) => entry.id == item.product_id);
                    if (product) {
                        item.price = Number(product.cost_price);
                    }
                },
                total() {
                    return this.items.reduce((sum, item) => sum + (Number(item.quantity || 0) * Number(item.price || 0)),
                    0);
                },
                formatCurrency(value) {
                    return '$' + Number(value || 0).toFixed(2);
                }
            };
        }
    </script>
</x-pos-layout>
