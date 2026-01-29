<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng cửu chương theo cột</title>

    <style>
        table {
            border-collapse: collapse;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px 12px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) td {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<table>
    <!-- Hàng tiêu đề: Bảng 2 → 9 -->
    <tr>
        <?php
        for ($i = 2; $i <= 9; $i++) {
            echo "<th>Bảng $i</th>";
        }
        ?>
    </tr>

    <!-- Các hàng từ 1 → 10 -->
    <?php
    for ($j = 1; $j <= 10; $j++) {
        echo "<tr>";
        for ($i = 2; $i <= 9; $i++) {
            echo "<td>$i × $j = " . ($i * $j) . "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
