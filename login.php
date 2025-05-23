<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/CSS/HomePage/layout/Login.css"> 
</head>
<body>
<div w3-include-html="header.html"></div>
<div class="body">
  <h2>Login</h2>
  <form action="php/login_action.php" method="post">
    <input type="email" name="email" id="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <?php if(isset($_GET['error'])) { ?>
      <div class="error">Invalid email or password!</div>
    <?php } ?>
    <a href="#" class="forgot-password">Forgot your password?</a>
    <button type="submit">Sign in</button>
    <a href="CreateAccount.html" class="forgot-password">Create account</a>
  </form>
</div>
<div w3-include-html="footer.html"></div>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script>
  w3.includeHTML();
</script>
</body>
</html>