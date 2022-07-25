<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php ROOT_REF ?>/users-form/views-form/views/users/custom.css" type="text/css">
</head>
<body>
<div class="container">
    <form method="post" action="">
        <div class="form-group field">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="<?= $user['name'] ?>" placeholder="Enter name">
        </div>
        <div class="form-group field">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="<?= $user['email'] ?>" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <label for="gender">Gender</label>
        <select id="gender" class="form-select field" name="gender">
            <?php
            $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($genders));
            foreach ($it as $v) {
                $selected = ($v === $user['gender']) ? 'selected="selected"' : '';
                echo '<option value="'. $v .'" ' . $selected . ' >'. $v .'</option>';
            }
            ?>
        </select>
        <label for="status">Status</label>
        <select id="status" class="form-select field" name="status">
            <?php
            $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($statuses));
            foreach ($it as $v) {
                $selected = ($v === $user['status']) ? 'selected="selected"' : '';
                echo '<option value="'. $v .'" ' . $selected . ' >'. $v .'</option>';
            }
            ?>
        </select>
        <input name="edit" type="submit" class="btn btn-primary" value="Edit">
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>



