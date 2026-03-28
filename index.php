<?php
declare(strict_types=1);

$transactions = [
    [
        "id" => 1,
        "date" => "2023-01-01",
        "amount" => 100.00,
        "description" => "Groceries",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2023-02-15",
        "amount" => 75.50,
        "description" => "Dinner",
        "merchant" => "Restaurant",
    ],
    [
        "id" => 3,
        "date" => "2023-03-10",
        "amount" => 200.00,
        "description" => "Electronics",
        "merchant" => "TechStore",
    ],
    [
        "id" => 4,
        "date" => "2023-04-05",
        "amount" => 50.00,
        "description" => "Taxi",
        "merchant" => "CityTaxi",
    ],
    [
        "id" => 5,
        "date" => "2023-05-20",
        "amount" => 120.00,
        "description" => "Clothes",
        "merchant" => "FashionShop",
    ],
];

function calculateTotalAmount(array $transactions): float {
    $sum = 0;
    foreach ($transactions as $t) {
        $sum += $t['amount'];
    }
    return $sum;
}

function findTransactionByDescription(array $transactions, string $search): array {
    return array_values(array_filter($transactions, function($t) use ($search) {
        return stripos($t['description'], $search) !== false;
    }));
}

function findTransactionById(array $transactions, int $id): ?array {
    foreach ($transactions as $t) {
        if ($t['id'] === $id) {
            return $t;
        }
    }
    return null;
}

function findTransactionByIdFilter(array $transactions, int $id): array {
    return array_values(array_filter($transactions, fn($t) => $t['id'] === $id));
}

function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $now = new DateTime();
    return $now->diff($transactionDate)->days;
}

function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;

    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
}

addTransaction(6, "2023-06-01", 300.00, "Laptop", "TechStore");

usort($transactions, function($a, $b) {
    return strtotime($a['date']) <=> strtotime($b['date']);
});

usort($transactions, function($a, $b) {
    return $b['amount'] <=> $a['amount'];
});
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lab 4</title>
</head>
<body>

<header>
    <h1>Bank Transactions</h1>
</header>

<nav>
    <p>Menu</p>
</nav>

<main>

    <h2>Transactions</h2>

    <table border="1" cellpadding="5">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Merchant</th>
            <th>Days Ago</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($transactions as $t): ?>
            <tr>
                <td><?= $t['id'] ?></td>
                <td><?= $t['date'] ?></td>
                <td><?= $t['amount'] ?></td>
                <td><?= $t['description'] ?></td>
                <td><?= $t['merchant'] ?></td>
                <td><?= daysSinceTransaction($t['date']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p><strong>Total:</strong> <?= calculateTotalAmount($transactions) ?></p>

    <h2>Image Gallery</h2>

    <?php
    $dir = 'image/';
    $files = scandir($dir);

    if ($files !== false) {
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                $path = $dir . $file;
                echo "<img src='$path' width='150' style='margin:5px'>";
            }
        }
    }
    ?>

</main>

<footer>
    <p>© 2026</p>
</footer>

</body>
</html>