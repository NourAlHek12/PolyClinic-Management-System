<style>
        .container {
            margin-top: 20px;
        }
        .form-container, .table-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        h1, h2 {
            margin-bottom: 20px;
        }
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
$list  = getAllSpecialities();
$doctors = getAllDoctors();
if(empty($list)){
    header("location:home.php?section=speciality");
}
if(isset($_GET['key'])){
    $name = $_GET['key'];
    $doctors = getDoctorsBasedOnFirstNameOrLastName($name);
    if(isset($_GET['specialityId']) && $_GET['specialityId'] != ''){
        $doctors = getAllDoctorsBySpecialtyId($_GET['specialityId']);
    }
}
?>
<div class="container">
    <div class="row">
        <!-- Form for adding a doctor -->
        <div class="col-md-8">
            <h1>Add Doctor</h1>
            <form action="../../post/doctor.php" method="post" enctype="multipart/form-data">
                <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?=$_SESSION['message'];?></div>
                <?php unset($_SESSION['message']); endif; ?>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Gmail</label>
                    <input type="gmail" class="form-control" id="lastName" name="gmail" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Password</label>
                    <input type="password" class="form-control" id="lastName" name="password" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Profile Picture</label>
                    <input type="file" class="form-control" id="lastName" name="image" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Phone</label>
                    <input type="number" class="form-control" id="lastName" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Specialty</label>
                    <select name="specialityId" id="" class="form-control" required>
                        <?php foreach($list as $specialty): ?>
                            <option value="<?php echo $specialty->id; ?>"><?php echo $specialty->name; ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <br>
                <!-- Add more input fields for other doctor details as needed -->
                <button name="add" type="submit" class="btn btn-primary">Submit</button>
            </form>
            <br>
        </div>
        <?php if(!isset($_GET['update'])): ?>
            <!-- Display doctors' details -->
            <div class="col-md-12">
                    <?php if(isset($_SESSION['messagee'])): ?>
                        <div class="alert alert-info"><?=$_SESSION['messagee'];?></div>
                    <?php unset($_SESSION['messagee']); endif; ?>
                <h1>Doctors Details</h1>
                <div class="container">
                    <form action="./home.php" method="get" class="search-form">
                        <input type="text" name="key" id="" placeholder="Doctor Name">
                        <select name="specialityId" id="" class="select">
                        <option value="" selected>Choose</option>
                        <?php foreach($list as $specialty): ?>
                            <option value="<?php echo $specialty->id; ?>"><?php echo $specialty->name; ?></option>
                        <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="section" value="doctor">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Picture</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Gmail</th>
                            <th>Phone</th>
                            <th>Speciality</th>
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
                            echo "<a href='../../post/doctor.php?id={$doctor->id}' class='btn btn-danger mb-1'>Delete</a> ";
                            echo "<a href='./home.php?id={$doctor->id}&section=doctor&update=1' class='btn btn-primary'>Update</a>";
                            echo "</td>";
                            // Add more table data for other doctor details as needed
                            echo "</tr>";
                        }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        <?php else: 
        $doctor = getDoctorById($_GET['id']);
        ?>
            <div class="col-md-6">
            <form action="../../post/doctor.php" method="post">
                <h2>Update</h2>
                <input type="hidden" name="id" value="<?=$doctor->id;?>">
                <div class="mb-3">
                    <i class="fas fa-user"></i>
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?=$doctor->firstName?>" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required value="<?=$doctor->lastName?>">
                </div>
                <div class="mb-3">
                    <label for="gmail" class="form-label">Gmail</label>
                    <input type="email" class="form-control" id="gmail" name="gmail" required value="<?=$doctor->gmail?>">
                </div>
                <div class="mb-3">
                    <label for="gmail" class="form-label">Phone</label>
                    <input type="number" class="form-control" id="phone" name="phone" required value="<?=$doctor->phone?>">
                </div>
                <div class="mb-3">
                    <label for="gmail" class="form-label">Speciality</label>
                    <select name="specialityId" id="" class="form-control" required>
                        <?php foreach($list as $specialty): ?>
                            <option value="<?php echo $specialty->id; ?>"><?php echo $specialty->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>
        </div>

        <?php endif;?>
    </div>
</div>
