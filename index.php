<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .total-row { font-weight: bold; background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Product Inventory Management</h1>
        
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Add Product</h5>
                <form id="productForm">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity in Stock</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price per Item</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Product List</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity in Stock</th>
                                <th>Price per Item</th>
                                <th>Datetime Submitted</th>
                                <th>Total Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editIndex" name="index">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" name="productName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editQuantity" class="form-label">Quantity in Stock</label>
                            <input type="number" class="form-control" id="editQuantity" name="quantity" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Price per Item</label>
                            <input type="number" step="0.01" class="form-control" id="editPrice" name="price" min="0" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveEdit()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
