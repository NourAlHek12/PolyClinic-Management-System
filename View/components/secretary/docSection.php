<style>
    .form-control {
            display: flex;
            gap: 10px;
        }

        input[type="text"], select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff; /* Dark color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #007bfe; /* Darker color on hover */
        }
</style>
<?php
$doctors = getAllDoctors();
$rooms  = getRooms();
$list  = getAllSpecialities();
$doctors = getAllDoctors();
if(isset($_GET['key'])){
    $name = $_GET['key'];
    $doctors = getDoctorsBasedOnFirstNameOrLastName($name);
    if(isset($_GET['specialityId']) && $_GET['specialityId'] != ''){
        $doctors = getAllDoctorsBySpecialtyId($_GET['specialityId']);
    }
}
?>
<div class="container mt-5 mb-5">
    <div class="row gap-1">
        <div class="col-md-12 mr-2">
            <?php if(isset($_SESSION['messagee'])): ?>
            <div class="alert alert-info"><?=$_SESSION['messagee'];?></div>
            <?php unset($_SESSION['messagee']); endif; ?>
            <h1>Doctors Details</h1>
            <br>
            <div class="container">
                <form action="./home.php" class="search-form">
                    <input type="text" name="key" id=""  placeholder="doctor name">
                    <input type="hidden" name="section" value="doctor">
                    <select name="specialityId" id="">
                        <option value="" selected>Choose</option>
                        <?php foreach($list as $specialty): ?>
                            <option value="<?php echo $specialty->id; ?>"><?php echo $specialty->name; ?></option>
                        <?php endforeach; ?>
                        </select>
                    <button type="submit">Search</button>
                </form>
                <br>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Picture</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gmail</th>
                        <th>Phone</th>
                        <th>Specialty</th>
                        <th></th>
                        <!-- Add more table headers for other doctor details as needed -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Display doctors' details here -->
                    <!-- Example row -->
                    <?php
                    // Loop through each doctor and display their information
                    foreach ($doctors as $doctor) {
                        echo "<tr>";
                        echo "<td><img src='../images/{$doctor->picture}' alt='Doctor Picture' width='90'></td>";
                        echo "<td>{$doctor->firstName}</td>";
                        echo "<td>{$doctor->lastName}</td>";
                        echo "<td>{$doctor->gmail}</td>";
                        echo "<td>{$doctor->phone}</td>";
                        echo "<td>{$doctor->speciality->name}</td>";
                        echo "<td>";
                        if(isset($_GET['id']) && $doctor->id == $_GET['id']){
                            echo "<a href='home.php?id={$doctor->id}&&section=doctor' class='btn btn-primary'>Schedule</a>";
                        }else{
                            echo "<a href='home.php?id={$doctor->id}&&section=doctor' class='btn btn-dark' style='background-color:darkgreen;'>Schedule</a>";
                        }
                        echo "</td>";
                        // Add more table data for other doctor details as needed
                        echo "</tr>";
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
        <?php if(isset($_GET['id'])):
        $schedule = getSchedule($_GET['id']);
        $doctor = getDoctorInfo($_GET['id']);
        ?>
        <div class="col-md-6 ml-1">
        <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?=$_SESSION['message'];?></div>
                <?php unset($_SESSION['message']); endif; ?>
            <div class="form">
                <form action="../../post/weekSchedule.php" method="post">
                    <h2>Schedule of Dr. <?=$doctor->firstName . " ".$doctor->lastName;?></h2>
                    <div class="form-group">
                        <label for="day">Day:</label>
                        <select class="form-control" name="day" id="day">
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                            <option value="sunday">Sunday</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="shift">
                            shift :
                        </label>
                        <select class="form-control" name="shift" id="">
                            <option value="before">Morning Shift</option>
                            <option value="after">Night Shift</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="<?=$_GET['id']?>">
                    <div class="form-group">
                        <label for="start">Start Time:</label>
                        <input type="time" class="form-control" name="start" id="start" required>
                    </div>
                    <div class="form-group">
                        <label for="end">End Time:</label>
                        <input type="time" class="form-control" name="end" id="end" required>
                    </div>
                    <div class="form-group">
                        <label for="end">Room</label>
                        <select class="form-control" name="roomId" id="" required>
                            <option value="" disabled selected>Room Number</option>
                        <?php foreach($rooms as $room): ?>
                            <option value="<?=$room->id?>"><?=$room->number?><?=$room->desc?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <br>
                    <button name="add" type="submit" class="btn btn-primary">Submit</button>
                    <br>
                </form>
            </div>
            
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Day</th>
                        <th scope="col">Shift</th>
                        <th scope="col">Start</th>
                        <th scope="col">End</th>
                        <th scope="col">Room</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedule as $s): ?>
                        <tr>
                            <td>
                                <?=$s->day?>
                            </td>
                            <td>
                                <?php
                                if($s->shift === 'before') echo 'morning shift';
                                else echo 'night shift';
                                ?>
                            </td>
                            <td>
                                <?=$s->start?>
                            </td>
                            <td>
                                <?=$s->end?>
                            </td>
                            <td>
                                <?=$s->room->number?>
                            </td>
                            <td>
                                <a href="../../post/weekSchedule.php?id=<?=$s->id;?>&&idDoc=<?=$s->doctor->id;?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
        <?php endif; ?>
    </div>
</div>