<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background: #f4f4f4;
        }
        .sidebar {
            width: 250px;
            background: #222;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100%;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px;
            margin: 10px 0;
            background: #333;
            text-align: center;
            border-radius: 5px;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: block;
        }
        .sidebar ul li:hover {
            background: #444;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
        }
        .main-content h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="{{route('admin.logout')}}">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>This is a simple dashboard layout with a sidebar menu.</p>
    </div>
</body>
</html>