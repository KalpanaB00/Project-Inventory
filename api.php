<?php
header('Content-Type: application/json');

$dataFile = 'products.json';

function loadProducts() {
    global $dataFile;
    if (!file_exists($dataFile)) {
        return [];
    }
    $json = file_get_contents($dataFile);
    $data = json_decode($json, true);
    return $data ? $data : [];
}

function saveProducts($products) {
    global $dataFile;
    $json = json_encode($products, JSON_PRETTY_PRINT);
    file_put_contents($dataFile, $json);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'add';
    
    if ($action === 'add') {
        $productName = $_POST['productName'] ?? '';
        $quantity = floatval($_POST['quantity'] ?? 0);
        $price = floatval($_POST['price'] ?? 0);
        
        if (empty($productName)) {
            echo json_encode(['success' => false, 'message' => 'Product name is required']);
            exit;
        }
        
        $products = loadProducts();
        $products[] = [
            'productName' => $productName,
            'quantity' => $quantity,
            'price' => $price,
            'datetime' => date('Y-m-d H:i:s')
        ];
        
        saveProducts($products);
        echo json_encode(['success' => true]);
        
    } elseif ($action === 'edit') {
        $index = intval($_POST['index'] ?? -1);
        $productName = $_POST['productName'] ?? '';
        $quantity = floatval($_POST['quantity'] ?? 0);
        $price = floatval($_POST['price'] ?? 0);
        
        $products = loadProducts();
        
        if ($index >= 0 && $index < count($products)) {
            $products[$index]['productName'] = $productName;
            $products[$index]['quantity'] = $quantity;
            $products[$index]['price'] = $price;
            
            saveProducts($products);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid index']);
        }
        
    } elseif ($action === 'delete') {
        $index = intval($_POST['index'] ?? -1);
        $products = loadProducts();
        
        if ($index >= 0 && $index < count($products)) {
            array_splice($products, $index, 1);
            saveProducts($products);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid index']);
        }
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? 'list';
    
    if ($action === 'list') {
        $products = loadProducts();
        echo json_encode(['products' => $products]);
        
    } elseif ($action === 'get') {
        $index = intval($_GET['index'] ?? -1);
        $products = loadProducts();
        
        if ($index >= 0 && $index < count($products)) {
            echo json_encode(['success' => true, 'product' => $products[$index]]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid index']);
        }
    }
}
?>
