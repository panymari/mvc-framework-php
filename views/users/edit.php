<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- CSS only -->


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
            integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"
            defer></script>
</head>
<body>
<div class="container">
    <form method="post" action="">
        <div class="form-group" style="margin-bottom: 1rem">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="<?= $user['name'] ?>" placeholder="Enter name">
        </div>
        <div class="form-group" style="margin-bottom: 1rem">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="<?= $user['email'] ?>" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <label for="gender">Gender</label>
        <select id="gender" class="form-select" name="gender" style="margin-bottom: 1rem">
            <option value="male" <?php if ($user['gender'] === 'male') { ?> selected="selected"<?php } ?>>male</option>
            <option value="female" <?php if ($user['gender'] === 'female') { ?> selected="selected"<?php } ?>>female</option>
        </select>
        <label for="status">Status</label>
        <select id="status" class="form-select" name="status" style="margin-bottom: 1rem">
            <option value="active" <?php if ($user['status'] === 'active') { ?> selected="selected"<?php } ?>>active</option>
            <option value="inactive" <?php if ($user['status'] === 'inactive') { ?> selected="selected"<?php } ?>>inactive</option>
        </select>
        <input name="edit" type="submit" class="btn btn-primary" value="Edit">

    </form>
</div>
</body>
</html>



