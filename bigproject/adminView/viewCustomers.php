<?php
include("../php/config.php");



?>

<div>
    <h2>All Customers</h2>
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">S.N.</th>
                <th class="text-center">Username</th>
                <th class="text-center">Email</th>
                <th class="text-center">Age</th>
                <th class="text-center">Tele</th>
                <th class="text-center">activity</th>
                <th class="text-center" colspan="1">Action</th>
            </tr>
        </thead>
        <?php
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $count = 1;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?php echo isset($row["Username"]) ? $row["Username"] : 'N/A'; ?></td>
                    <td><?php echo isset($row["Email"]) ? $row["Email"] : 'N/A'; ?></td>
                    <td><?php echo isset($row["Age"]) ? $row["Age"] : 'N/A'; ?></td>
                    <td><?php echo isset($row["tele"]) ? $row["tele"] : 'N/A'; ?></td>
                    <td><button class="btn <?php if ($row["active"]) {
                                 echo "btn-success";
                                                 } else {
                                  echo "btn-danger";
                        } ?>" style="height:40px" onclick="setactive(<?=$row['Id']?>)"></button></td>
                    <td><button class="btn btn-danger" style="height:40px" onclick="deletCustomers(<?=$row['Id']?>)">Delete</button></td>

                </tr>
                <?php
                $count++;
            }
        } else {
            echo "No customers found.";
        }
        ?>
    </table>
</div>
