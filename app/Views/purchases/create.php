<div class="max-w-5xl mx-auto p-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Enregistrer un achat (Stock)</h1>
        <a href="<?= url('/purchase') ?>" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
    </div>

    <form action="<?= url('/purchase/store') ?>" method="POST" id="purchase-form" class="space-y-6">
        <!-- Section Fournisseur -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <label class="block text-xs font-bold uppercase text-gray-400 dark:text-gray-500 mb-2 tracking-wider">Fournisseur</label>
            <select name="supplier_id" id="supplier_id" class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:text-white focus:border-teal-500 outline-none" required>
                <option value="">-- Sélectionner un fournisseur --</option>
                <?php foreach ($suppliers as $supplier): ?>
                    <option value="<?= $supplier->id ?>"><?= htmlspecialchars($supplier->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Section Produits -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-b dark:border-gray-600">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Médicament à acheter</th>
                        <th class="px-6 py-3 font-semibold w-32">Quantité</th>
                        <th class="px-6 py-3 font-semibold text-right w-40">Coût estimé</th>
                        <th class="px-6 py-3 text-center w-20"></th>
                    </tr>
                </thead>
                <tbody id="products-container" class="divide-y divide-gray-100 dark:divide-gray-700">
                    <!-- Les lignes seront ajoutées ici -->
                </tbody>
            </table>
            
            <div class="p-4 bg-gray-50 dark:bg-gray-700/30 border-t dark:border-gray-600">
                <button type="button" id="add-product" class="text-teal-600 dark:text-teal-400 font-semibold hover:text-teal-700 flex items-center transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter un produit
                </button>
            </div>
        </div>

        <!-- Total et Validation -->
        <div class="flex flex-col md:flex-row items-center justify-between p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="text-gray-600 dark:text-gray-400 mb-4 md:mb-0">
                Montant total estimé : <span class="text-2xl font-bold text-gray-900 dark:text-white ml-2"><span id="total-amount">0</span> FC</span>
            </div>
            <button type="submit" class="w-full md:w-auto px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg transition-all shadow-md">
                Enregistrer l'achat
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('products-container');
    const totalSpan = document.getElementById('total-amount');
    const productsData = <?= json_encode($products) ?>;
    let count = 0;

    function addLine() {
        count++;
        const tr = document.createElement('tr');
        tr.className = 'group hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors';
        tr.innerHTML = `
            <td class="px-6 py-4">
                <input type="text" list="prod-list-${count}" class="w-full p-2 bg-transparent border border-gray-200 dark:border-gray-600 rounded focus:border-teal-500 outline-none product-search" placeholder="Chercher un médicament...">
                <input type="hidden" name="products[${count}][id]" class="product-id">
                <datalist id="prod-list-${count}">
                    ${productsData.map(p => `<option value="${p.designation}" data-id="${p.id}" data-price="${p.unit_price}"></option>`).join('')}
                </datalist>
                <div class="text-[10px] text-gray-400 mt-1 stock-info hidden">Prix d'achat: <span class="price"></span> FC</div>
            </td>
            <td class="px-6 py-4">
                <input type="number" name="products[${count}][quantity]" value="1" min="1" class="w-full p-2 bg-transparent border border-gray-200 dark:border-gray-600 rounded focus:border-teal-500 outline-none qty-input">
            </td>
            <td class="px-6 py-4 text-right font-bold text-gray-700 dark:text-gray-200">
                <span class="line-total">0</span> FC
            </td>
            <td class="px-6 py-4 text-center">
                <button type="button" class="text-gray-300 hover:text-red-500 remove-line transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        `;
        container.appendChild(tr);

        const search = tr.querySelector('.product-search');
        const qty = tr.querySelector('.qty-input');
        const id = tr.querySelector('.product-id');
        const dl = document.getElementById(`prod-list-${count}`);

        function update() {
            const opt = Array.from(dl.options).find(o => o.value === search.value);
            if (opt) {
                id.value = opt.dataset.id;
                const p = parseFloat(opt.dataset.price);
                const q = parseInt(qty.value) || 0;
                
                tr.querySelector('.price').textContent = p;
                tr.querySelector('.stock-info').classList.remove('hidden');
                tr.querySelector('.line-total').textContent = (p * q).toLocaleString();
            } else {
                id.value = "";
                tr.querySelector('.stock-info').classList.add('hidden');
                tr.querySelector('.line-total').textContent = "0";
            }
            let t = 0;
            document.querySelectorAll('.line-total').forEach(s => t += parseFloat(s.textContent.replace(/\\s/g,'')) || 0);
            totalSpan.textContent = t.toLocaleString();
        }

        search.addEventListener('input', update);
        qty.addEventListener('input', update);
        tr.querySelector('.remove-line').addEventListener('click', () => {
            tr.remove();
            update();
        });
    }

    document.getElementById('add-product').addEventListener('click', addLine);
    addLine();
});
</script>