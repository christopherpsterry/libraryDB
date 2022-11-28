<?php
include 'main.php';
$stmt = $pdo->prepare('SELECT * FROM MeetingRoom');
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['select'])) {
    if (strcmp($_POST['category'], "all") == 0) {
        header('Location: items.php');
    } elseif (strcmp($_POST['category'], "dvd") == 0) {
        header('Location: items-dvd.php');
    } elseif (strcmp($_POST['category'], "laptop") == 0) {
        header('Location: items-laptop.php');
    } elseif (strcmp($_POST['category'], "meetingRoom") == 0) {
        header('Location: items-room.php');
    } elseif (strcmp($_POST['category'], "book") == 0) {
        header('Location: items-book.php');
    }
    exit;
}
?>

<?=template_admin_header($page . 'Items', 'items', 'viewLaptops')?>

<h2>
    <i class="fas fa-laptop"></i> Meeting Rooms 
    <a href="add-room.php">
        <button style="background-color:green; color: white; cursor: pointer; font-size: 18px;">+</button>
    </a>
</h2>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mytable').DataTable({
            pagingType: 'full_numbers',
        });
    });
</script>

<form action="items-room.php?select" method="post">
    <label for="category">Item Category</label>
    <select id="category" name="category">
        <option value="all">All</option>
        <option value="book">Book</option>
        <option value="dvd">DVD</option>
        <option value="laptop">Laptop</option>
        <option value="meetingRoom" selected>Meeting Room</option>
    </select>
    <input type="submit" value="Show">
</from>

<div class="content-block">
    <!-- Table for displaying all items -->
    <div class="table">
        <table table id="mytable" class="display" style="width:100%">
            <thead>
                <tr>
                    <td>ItemID</td>
                    <td>Room Number</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                <?php if (!$rooms): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no rooms</td>
                </tr>
                <?php endif; ?>
                <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?=$room['ItemId']?></td>
                    <td><?=$room['RoomNumber']?></td>
                    <td>
                        <input 
                                type="button" 
                                disabled
                                style=<?php
                                    if ($room['Status']) {
                                        echo "\"color:#FCFCFC; background-color: #078E03;\"";
                                    } else {
                                        echo "\"color:#FCFCFC; background-color: #FF0000;\"";
                                    }
                                ?>
                                value= <?php
                                    if ($room['Status']) {
                                        echo "Available";
                                    } else {
                                        echo "Unavailable";
                                    }
                                ?>
                        >
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?=template_admin_footer()?>