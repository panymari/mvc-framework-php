<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <style><?php include VIEW_ROOT_USERS . '/custom.css'; ?></style>
</head>
<body>
<div class="container">
    <form method="post" action="">
        <div class="form-group field">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required>
        </div>
        <div class="form-group field">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
        </div>
        <label for="gender">Gender</label>
        <select id="gender" class="form-select field" name="gender">
            <option value="male">male</option>
            <option value="female">female</option>
        </select>
        <label for="status">Status</label>
        <select id="status" class="form-select field" name="status">
            <option value="active">active</option>
            <option value="inactive">inactive</option>
        </select>
        <input name="create" type="submit" class="btn btn-primary" value="Create">
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>



