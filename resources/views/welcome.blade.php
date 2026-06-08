<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <ul>
        <li>
            <a href="{{ route('users.index') }}">Users</a>
        </li>
        <li>
            <a href="{{ route('customers.index') }}">Customers</a>
        </li>
        <li>
            <a href="{{ route('categories.index') }}">Categories</a>
        </li>
        <li>
            <a href="{{ route('products.index') }}">Products</a>
        </li>
    </ul>
</body>

</html>
