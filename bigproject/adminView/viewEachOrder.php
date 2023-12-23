<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>S.N.</th>
                
                <th>Quantity</th>
                <th>Unit Price</th>
            </tr>
        </thead>
        <?php
        include("../php/config.php");
        $orderID = $_GET['orderID'];

        $sql = "SELECT * FROM order_details WHERE order_id = $orderID";
        $result = $conn->query($sql);
        $count = 1;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $row["quantity"] ?></td>
                    <td><?= $row["price"] ?></td>
                </tr>
                <?php
                $count = $count + 1;
            }
        } else {
            echo "No records found";
        }
        ?>
    </table>
</div>
