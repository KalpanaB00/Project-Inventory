let editModal;

document.addEventListener('DOMContentLoaded', function() {
    editModal = new bootstrap.Modal(document.getElementById('editModal'));
    loadProducts();
    
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();
        addProduct();
    });
});

function addProduct() {
    const formData = new FormData(document.getElementById('productForm'));
    
    fetch('api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            document.getElementById('productForm').reset();
            loadProducts();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function loadProducts() {
    fetch('api.php?action=list')
    .then(response => response.json())
    .then(data => {
        displayProducts(data.products);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function displayProducts(products) {
    const tbody = document.getElementById('productTableBody');
    tbody.innerHTML = '';
    
    let grandTotal = 0;
    
    products.forEach((product, index) => {
        const totalValue = product.quantity * product.price;
        grandTotal += totalValue;
        
        const row = tbody.insertRow();
        row.innerHTML = `
            <td>${escapeHtml(product.productName)}</td>
            <td>${product.quantity}</td>
            <td>$${parseFloat(product.price).toFixed(2)}</td>
            <td>${product.datetime}</td>
            <td>$${totalValue.toFixed(2)}</td>
            <td>
                <button class="btn btn-sm btn-warning" onclick="editProduct(${index})">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${index})">Delete</button>
            </td>
        `;
    });
    
    const totalRow = tbody.insertRow();
    totalRow.className = 'total-row';
    totalRow.innerHTML = `
        <td colspan="4" class="text-end">Grand Total:</td>
        <td>$${grandTotal.toFixed(2)}</td>
        <td></td>
    `;
}

function editProduct(index) {
    fetch('api.php?action=get&index=' + index)
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            document.getElementById('editIndex').value = index;
            document.getElementById('editProductName').value = data.product.productName;
            document.getElementById('editQuantity').value = data.product.quantity;
            document.getElementById('editPrice').value = data.product.price;
            editModal.show();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function saveEdit() {
    const formData = new FormData(document.getElementById('editForm'));
    formData.append('action', 'edit');
    
    fetch('api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            editModal.hide();
            loadProducts();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function deleteProduct(index) {
    if(confirm('Are you sure you want to delete this product?')) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('index', index);
        
        fetch('api.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                loadProducts();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}
