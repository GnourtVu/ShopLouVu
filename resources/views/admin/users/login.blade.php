<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="/template/admin/dist/css/admin.css">
</head>

<body class="hold-transition login-page">
    <div class="loginBox">
        <h2>LouVu Admin</h2>
        @include('admin.alert')
        <form action="/admin/users/login/store" method="post">
            <p>Email</p>
            <input type="email" name="email" placeholder="Enter Email">
            <p>Password</p>
            <input type="password" name="password" placeholder="••••••••">
            <input type="submit" name="" value="LOGIN">
            <a href="#" class="a">Forgot Password?</a>
            <h4>Create account? <a class="txt2" href="#">Sign Up</a></h4>
            @csrf
        </form>
    </div>
</body>

</html>
