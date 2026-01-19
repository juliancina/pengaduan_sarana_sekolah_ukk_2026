<!DOCTYPE html>
<html>
<head>
    <title>Login Aplikasi Pengaduan</title>
    <style>
        body { font-family: sans-serif; background: #eee; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .box { background: white; padding: 20px; width: 300px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="box">
    <h2 style="text-align:center;">Login Pengaduan</h2>
    
    <form action="index.php?page=auth_proccess" method="POST">
        <label>Username / NIS</label>
        <input type="text" name="username" placeholder="Masukkan Admin atau NIS" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password (Admin Only)">
        
        <button type="submit">LOGIN</button>
    </form>
    
    <p style="font-size:12px; color:gray; text-align:center; margin-top:10px;">
        *Siswa gunakan NIS sebagai Username
    </p>
</div>

</body>
</html>