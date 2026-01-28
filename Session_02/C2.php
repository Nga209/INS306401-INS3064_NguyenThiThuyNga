<table border="1" cellpadding="5">
    <?php
    for ($i = 2; $i <= 9; $i++) {
        echo "<tr>";
        for ($j = 1; $j <= 10; $j++) {
            echo "<td>$i x $j = " . ($i * $j) . "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>
