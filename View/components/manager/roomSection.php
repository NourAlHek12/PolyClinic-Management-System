<?php
$rooms = getRooms();
?>
<div class="container">
    <div class="row">
        <!-- Form for adding a doctor -->
        <div class="col-md-8">
            <h1>Add Room</h1>
            <form action="../../post/room.php" method="post">
                <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-info"><?=$_SESSION['message'];?></div>
                <?php unset($_SESSION['message']); endif; ?>
                <div class="form-group mb-1">
                    <label for="">Room Number</label>
                    <input type="text" class="form-control" id="firstName" name="number" required>
                </div>
                <div class="form-group mb-1">
                    <label for="">Room Description</label>
                    <input type="text" class="form-control" id="firstName" name="desc" required>
                </div>
                <div class="form-group">
                <button name="add" type="submit" class="btn btn-primary">ADD</button>
                </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        </form>
        <br>
        <br>
    <?php if(!isset($_GET['update'])): ?>
        <div class="col-md-8">
        <?php if(isset($_SESSION['messagee'])): ?>
        <div class="alert alert-info"><?=$_SESSION['messagee'];?></div>
        <?php unset($_SESSION['messagee']); endif; ?>
        <h1>Room Details</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Description</th>
                    <th></th>
                    <!-- Add more table headers for other doctor details as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Display doctors' details here -->
                <!-- Example row -->
                <?php
                    // Loop through each doctor and display their information
                    foreach ($rooms as $room) {
                        echo "<tr>";
                        echo "<td>{$room->number}</td>";
                        echo "<td>{$room->desc}</td>";
                        echo "<td>";
                        echo "<a href='../../post/room.php?id={$room->id}' class='btn btn-danger'>Delete</a> ";
                        echo "<a href='./home.php?section=room&id={$room->id}&update=1' class='btn btn-primary'>Update</a>";
                        echo "</td>";
                        // Add more table data for other doctor details as needed
                        echo "</tr>";
                    }
                    
                    ?>
            </tbody>
        </table>
        </div>
        <br>
        <br>
    <?php else: 
    $room = getRoomById($_GET['id']);
    
    ?>
        <div class="col-md-8">
            <form action="../../post/room.php" method="post">
                <div class="form-control">
                    Number :
                    <input type="number" name="number"  value="<?=$room->number?>"id="">
                    <br>
                    <br>
                    Description :
                    <input type="text" name="desc" id="" value="<?=$room->desc?>">
                    <input type="hidden" name="idToUpdate" value="<?=$room->id?>">
                    <br>
                    <br>
                    <button type="submit" name="update" class="btn btn-info">Save</button>
                </div>
            </form>
        </div>
        <br>
        <br>
        <br>
    <?php endif;?>
</div>
</div>