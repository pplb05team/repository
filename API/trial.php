<html>
<body>

<form action="login.php" method="post">
	Name: <input type="text" name="username"><br>
	Password: <input type="text" name="password"><br>
<input type="submit">
</form>

<form action="register.php" method="post">
	Name: <input type="text" name="username"><br>
	E-mail: <input type="text" name="email"><br>
	Password: <input type="text" name="password"><br>
	Role: <input type="text" name="role"><br>
<input type="submit">
</form>

<form action="getMenu.php" method="post">
	Name: <input type="text" name="username"><br>
<input type="submit">
</form>

<form action="getCounter.php" method="post">
	Counter: <input type="text" name="counter"><br>
<input type="submit">
</form>

<form action="getPesanan.php" method="post">
	username pemesan: <input type="text" name="username"><br>
<input type="submit">
</form>

<form action="getPemasukanCounter.php" method="post">
	username Penjual: <input type="text" name="username"><br>
<input type="submit">
</form>

<form action="bayar.php" method="post">
	username counter mau dibayar: <input type="text" name="username"><br>
<input type="submit">
</form>


<form action="tambahKreditPembeli.php" method="post">
	username pembeli: <input type="text" name="username"><br>
	uang: <input type="text" name="jumlahUang"><br>

<input type="submit">
</form>


<form action="getPemasukanPembeli.php" method="post">
	username untuk cek pemasukan pembeli: <input type="text" name="username"><br>

<input type="submit">
</form>


</body>
</html>