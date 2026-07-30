<x-pos-layout>
    <x-slot name="title">New Sale</x-slot>
    <div x-data="saleForm({{ Js::from($products) }})" class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <form method="POST" action="{{ route('sales.store') }}"
            class="space-y-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
            @csrf
            @error('items')
                <div class="rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">{{ $message }}</div>
            @enderror
            <div class="grid gap-4 md:grid-cols-2">
                <label class="block text-sm font-medium text-slate-600">
                    <span class="mb-1 block">Customer name</span>
                    <input class="w-full rounded-lg border-slate-300" name="customer_name" required>
                </label>
                <label class="block text-sm font-medium text-slate-600">
                    <span class="mb-1 block">Phone</span>
                    <input class="w-full rounded-lg border-slate-300" name="customer_phone">
                </label>
                <label class="block text-sm font-medium text-slate-600 md:col-span-2">
                    <span class="mb-1 block">Address</span>
                    <textarea class="w-full rounded-lg border-slate-300" name="customer_address"></textarea>
                </label>
                <label class="block text-sm font-medium text-slate-600">
                    <span class="mb-1 block">Sale date</span>
                    <input class="w-full rounded-lg border-slate-300" type="date" name="sale_date"
                        value="{{ now()->toDateString() }}" required>
                </label>
                <label class="block text-sm font-medium text-slate-600">
                    <span class="mb-1 block">Payment method</span>
                    <select class="w-full rounded-lg border-slate-300" name="payment_method">
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank transfer</option>
                        <option value="cod">COD</option>
                    </select>
                </label>
                <label class="block text-sm font-medium text-slate-600">
                    <span class="mb-1 block">Payment status</span>
                    <select class="w-full rounded-lg border-slate-300" name="payment_status">
                        <option value="unpaid">Unpaid</option>
                        <option value="paid">Paid</option>
                        <option value="partial">Partial</option>
                    </select>
                </label>
                <label class="block text-sm font-medium text-slate-600">
                    <span class="mb-1 block">Discount</span>
                    <input class="w-full rounded-lg border-slate-300" type="number" step="0.01" min="0"
                        name="discount" value="0">
                </label>
                <label class="block text-sm font-medium text-slate-600">
                    <span class="mb-1 block">Delivery fee</span>
                    <input class="w-full rounded-lg border-slate-300" type="number" step="0.01" min="0"
                        name="delivery_fee" value="0">
                </label>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <div class="mb-3 flex items-center justify-between">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Products</h3>
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
                                    <option :value="product.id"
                                        x-text="`${product.name} (${product.stock_quantity} ${product.unit})`"></option>
                                </template>
                            </select>
                            <input class="rounded-lg border-slate-300" type="number" min="1"
                                :name="`items[${index}][quantity]`" x-model.number="item.quantity">
                            <input class="rounded-lg border-slate-300" type="number" step="0.01" min="0"
                                :name="`items[${index}][selling_price]`" x-model.number="item.price">
                            <button type="button"
                                class="rounded-lg border border-slate-200 px-3 text-sm font-medium text-rose-600"
                                @click="removeLine(index)">Remove</button>
                        </div>
                    </template>
                </div>
            </div>

            <button class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Record sale</button>
        </form>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
            <h3 class="text-lg font-semibold">Order summary</h3>
            <p class="mt-1 text-sm text-slate-500">Live totals update here before the server validates the order.</p>
            <div class="mt-4 space-y-3">
                <template x-if="items.length === 0">
                    <div class="rounded-lg border border-dashed border-slate-300 p-4 text-sm text-slate-500">Add items
                        to start a sale.</div>
                </template>
                <template x-for="(item, index) in items" :key="index">
                    <div class="rounded-lg border border-slate-200 p-3">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold" x-text="productName(item.product_id)"></div>
                            <div class="text-sm font-semibold" x-text="'$'+lineTotal(item).toFixed(2)"></div>
                        </div>
                        <div class="mt-2 flex items-center gap-2 text-sm text-slate-500">
                            <button type="button" class="rounded-full border border-slate-200 px-2"
                                @click="adjustQty(index, -1)">−</button>
                            <span x-text="item.quantity"></span>
                            <button type="button" class="rounded-full border border-slate-200 px-2"
                                @click="adjustQty(index, 1)">+</button>
                            <span class="ml-auto" x-text="'@'+formatCurrency(item.price)"></span>
                        </div>
                    </div>
                </template>
            </div>
            <div class="mt-6 space-y-2 border-t border-slate-200 pt-4 text-sm">
                <div class="flex justify-between"><span>Subtotal</span><span
                        x-text="formatCurrency(subtotal())"></span></div>
                <div class="flex justify-between"><span>Discount</span><span
                        x-text="formatCurrency(discountValue())"></span></div>
                <div class="flex justify-between"><span>Delivery</span><span
                        x-text="formatCurrency(deliveryValue())"></span></div>
                <div class="flex justify-between border-t border-slate-200 pt-2 text-base font-semibold"><span>Grand
                        total</span><span x-text="formatCurrency(grandTotal())"></span></div>
            </div>
        </div>
    </div>

    <script>
        function saleForm(products) {
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
                adjustQty(index, delta) {
                    const item = this.items[index];
                    if (!item) return;
                    item.quantity = Math.max(1, (item.quantity || 1) + delta);
                },
                setPrice(item) {
                    const product = this.products.find((entry) => entry.id == item.product_id);
                    if (product) {
                        item.price = Number(product.selling_price);
                    }
                },
                productName(productId) {
                    const product = this.products.find((entry) => entry.id == productId);
                    return product ? product.name : 'Select product';
                },
                lineTotal(item) {
                    return Number(item.quantity || 0) * Number(item.price || 0);
                },
                subtotal() {
                    return this.items.reduce((sum, item) => sum + this.lineTotal(item), 0);
                },
                discountValue() {
                    const input = document.querySelector('input[name="discount"]');
                    return Number(input?.value || 0);
                },
                deliveryValue() {
                    const input = document.querySelector('input[name="delivery_fee"]');
                    return Number(input?.value || 0);
                },
                grandTotal() {
                    return this.subtotal() - this.discountValue() + this.deliveryValue();
                },
                formatCurrency(value) {
                    return '$' + Number(value || 0).toFixed(2);
                }
            };
        }
    </script>
</x-pos-layout>
