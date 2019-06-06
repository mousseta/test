<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>association medianet</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
		<div class="container
		content">
		<div class="main block">
			<article class="post">
				<h2>enregistrement</h2>
				<p class="meta"></p>
				<p>
			    <form action="index.php/login" method="GET">
			    	 <p><label for="login">login</label> <input type="text" name="login" id="login"/></p>
			    	 <p><label for="password">password</label> <input type="text" name="password" id="password"/></p>
			    	 <input type="hidden" value="login" name="action" />
			     <?php if ($existe==0){?>
			    <a href="index.php/enregistrer">enregistrez vous</a>
			    <?php }?>
			    	 <p><input type="submit" value="enregistrer" /></p>
			    </form>
				</p>
			<div>
			<div class="container">
				<footer class="main-footer">
					<div class="f_left">
						<p>&amp;copy; 2017 - association medianet</p>
					</div>
				</footer>
			</div>
		</div>
	</body>
	</html>
