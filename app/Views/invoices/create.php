<div class="max-w-4xl p-6 mx-auto mt-8 bg-white rounded-lg shadow dark:bg-gray-800">
    <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-white">Créer une facture</h1>
    
    <form action="<?= PUBLIC_URL?>invoice/store" method="POST" id="invoice-form">
        <div class="mb-6">
            <label class="block mb-2 text-gray-700 dark:text-gray-300">Client</label>
            <select name="customer_id" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="">Sélectionner un client</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= $customer->id ?>"><?= htmlspecialchars($customer->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-6">
            <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Produits</h3>
            
            <div id="products-container">
                <!-- Les lignes de produits seront ajoutées ici dynamiquement -->
            </div>
            
            <button type="button" id="add-product" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
                Ajouter un produit
            </button>
        </div>

        <div class="flex items-center justify-between">
            <div class="text-xl font-bold">
                Total: <span id="total-amount">0.00</span> FC
            </div>
            
            <button type="submit" class="px-4 py-2 text-white bg-teal-500 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700">
                Enregistrer la facture
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productsContainer = document.getElementById('products-container');
    const addProductBtn = document.getElementById('add-product');
    const totalAmountSpan = document.getElementById('total-amount');
    let productCount = 0;
    
    // Données des produits disponibles
    const productsData = <?= json_encode($products) ?>;
    
    // Ajouter une ligne de produit
    function addProductLine(product = null) {
        productCount++;
        
        const div = document.createElement('div');
        div.className = 'product-line mb-4 p-4 border rounded dark:border-gray-600';
        div.dataset.index = productCount;
        
        div.innerHTML = `
            <div class="flex flex-wrap -mx-2">
                <div class="w-full px-2 mb-4 md:w-1/2">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Produit</label>
                    <select name="products[${productCount}][id]" class="w-full p-2 border rounded product-select dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="">Sélectionner un produit</option>
                        ${productsData.map(p => 
                            `<option value="${p.id}" ${product && product.id === p.id ? 'selected' : ''}
                             data-price="${p.unit_price}">${p.designation} (${p.unit_price} FC)</option>`
                        ).join('')}
                    </select>
                </div>
                <div class="w-full px-2 mb-4 md:w-1/4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Quantité</label>
                    <input type="number" name="products[${productCount}][quantity]" min="1" value="${product ? product.quantity : 1}" 
                           class="w-full p-2 border rounded quantity-input dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>
                <div class="flex items-end w-full px-2 mb-4 md:w-1/4">
                    <button type="button" class="px-3 py-2 text-white bg-red-500 rounded remove-product hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700">
                        Supprimer
                    </button>
                </div>
            </div>
            <div class="font-semibold text-right price-display">
                Total ligne: <span class="line-total">${product ? (product.unit_price * product.quantity).toFixed(2) : '0.00'}</span> FC
            </div>
        `;
        
        productsContainer.appendChild(div);
        
        // Écouteurs d'événements
        const select = div.querySelector('.product-select');
        const quantityInput = div.querySelector('.quantity-input');
        const removeBtn = div.querySelector('.remove-product');
        
        function updateLineTotal() {
            const price = select.options[select.selectedIndex]?.dataset.price || 0;
            const quantity = quantityInput.value || 0;
            const lineTotal = (price * quantity).toFixed(2);
            
            div.querySelector('.line-total').textContent = lineTotal;
            updateTotalAmount();
        }
        
        select.addEventListener('change', updateLineTotal);
        quantityInput.addEventListener('input', updateLineTotal);
        removeBtn.addEventListener('click', () => {
            div.remove();
            updateTotalAmount();
        });
        
        if (product) {
            updateLineTotal();
        }
    }
    
    // Calculer le montant total
    function updateTotalAmount() {
        let total = 0;
        
        document.querySelectorAll('.product-line').forEach(line => {
            const lineTotal = parseFloat(line.querySelector('.line-total').textContent) || 0;
            total += lineTotal;
        });
        
        totalAmountSpan.textContent = total.toFixed(2);
    }
    
    // Ajouter un produit au clic
    addProductBtn.addEventListener('click', () => addProductLine());
    
    // Ajouter une première ligne vide
    addProductLine();
});
</script>