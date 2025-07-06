<style>
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
$list = getAllSecrataries();
if(isset($_GET['key'])){
    $name = $_GET['key'];
    $list = getSecretariesByName($name);
}
?>
<div class="container">
    <div class="row">
        <!-- Form for adding a doctor -->
        <div class="col-md-8">
            <h1>Add Secretary</h1>
            <form action="../../post/secretary.php" method="post">
                <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?=$_SESSION['message'];?></div>
                <?php unset($_SESSION['message']); endif; ?>
              
                <div class="form-group">
                    <label for="firstName">Name</label>
                    <input type="text" class="form-control" id="firstName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Phone</label>
                    <input type="number" class="form-control" id="lastName" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Password</label>
                    <input type="password" class="form-control" id="lastName" name="password" required>
                </div>
                <br>
                <!-- Add more input fields for other doctor details as needed -->
                <button name="add" type="submit" class="btn btn-primary">Submit</button>
            </form>
            <br>
        </div>
        <?php 
        if(!isset($_GET['update'])):
        ?>
            <!-- Display doctors' details -->
            <div class="col-md-8">
            <?php if(isset($_SESSION['messagee'])): ?>
                        <div class="alert alert-info"><?=$_SESSION['messagee'];?></div>
                    <?php unset($_SESSION['messagee']); endif; ?>
                <h1>Secretary Details</h1>
                <div class="container">
                    <form action="./home.php" method="get">
                        <input type="text" name="key" id="" placeholder="Secretary Name">
                        <input type="hidden" name="section" value="secretary">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th></th>
                            <!-- Add more table headers for other doctor details as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Display doctors' details here -->
                        <!-- Example row -->
                        <?php
                        // Loop through each doctor and display their information
                        foreach ($list as $l) {
                            echo "<tr>";
                            echo "<td>{$l->id}</td>";
                            echo "<td>{$l->name}</td>";
                            echo "<td>{$l->phone}</td>";
                            echo "<td>";
                            echo "<a href='../../post/secretary.php?id={$l->id}' class='btn btn-danger'>Delete</a> ";
                            echo "<a href='./home.php?section=secretary&id={$l->id}&update=1' class='btn btn-primary'>Update</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        <?php else :
            $secretary  = getSecretariesById($_GET['id']);
        ?>
        <div class="col-md-6">
            <h2>Update</h2>
            <form action="../../post/secretary.php" method="post" class="container">
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?=$secretary->name?>" required>
                </div>
                <div class="mb-3">
                    <label for="name">Phone</label>
                    <input type="text" name="phone" id="name" value="<?=$secretary->phone?>" required>
                </div>
                <input type="hidden" name="id" value="<?=$secretary->id?>">
                <button type="submit" class="btn btn-primary">save</button>
            </form>
        </div>

        <?php endif; ?>
    </div>
</div>
