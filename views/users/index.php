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
</head>
<body>
<div class="container">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Gender</th>
            <th scope="col">Status</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <form method="post" action="../../config/action.php">
                    <td>
                        <input readonly style="color: black; font-weight: bold; background: transparent; border: 0; width: 3rem"
                               name="user_id" type="text" value="<?= $user['id'] ?>"></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['gender'] ?></td>
                    <td><?= $user['status'] ?></td>
                    <td>
                            <input name="action" type="submit" class="btn btn-primary" value="edit">
                    </td>
                    <td>
                            <input name="action" type="submit" onclick="return confirm('Are you sure?')"
                                   class="btn btn-danger" value="delete">
                    </td>
                </form>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <form method="post" action="../../config/action.php">
        <input name="action" type="submit"
               class="btn btn-dark" value="create">
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"
        defer></script>
</body>
</html>



