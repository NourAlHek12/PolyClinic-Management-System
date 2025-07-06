<?php
$list  = getAllSpecialities();
?>
<div class="container">
    <div class="row">
        <!-- Form for adding a specialty -->
        <div class="col-md-8">
            <h2>Add Specialty</h2>
            <form action="../../post/speciality.php" method="post">
                <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?=$_SESSION['message'];?></div>
                <?php unset($_SESSION['message']); endif; ?>
                <div class="form-group">
                    <label for="specialtyName">Specialty Name</label>
                    <input type="text" name="name" class="form-control" id="specialtyName" name="specialtyName" required>
                </div>
                <br>
                <button type="submit" name="add" class="btn btn-primary">Add Specialty</button>
                <br>
            </form>
            <br>
            <br>
        </div>
        <!-- Table displaying specialties -->
        <?php 
        if(!isset($_GET['update'])):
        ?>
        <div class="col-md-8">
        <?php if(isset($_SESSION['messagee'])): ?>
                    <div class="alert alert-info"><?=$_SESSION['messagee'];?></div>
                <?php unset($_SESSION['messagee']); endif; ?>
            <h2>Specialties</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($list as $specialty): ?>
                        <tr>
                            <td><?php echo $specialty->id; ?></td>
                            <td><?php echo $specialty->name; ?></td>
                            <td>
                            <a href="../../post/speciality.php?id=<?=$specialty->id;?>" class="btn btn-danger">Delete</a>
                            <a href="./home.php?section=speciality&id=<?=$specialty->id;?>&update=1" class="btn btn-primary">Update</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else :
        $speciality = getSpecialityById($_GET['id']);
        ?>
            <div class="col-md-8">
                <div class="container">
                    <form action="../../post/speciality.php" method="post">
                        <h2> Please Update and Save</h2>
                        <div class="mb-3">
                            <label for="name" class="form-label">Specialty Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="<?=$speciality->name?>" >
                            <input type="hidden" name="id" value="<?=$speciality->id;?>">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

