<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo htmlspecialchars( $title, ENT_COMPAT, 'Something different', FALSE ); ?></title>
	<link rel="stylesheet" href="<?php echo static::$conf['base_url']; ?>templates/raintpl3/css/style.css" type="text/css" />
</head>
<body>

<div id="msg">The <b>easy</b> and <a href="http://www.phpcomparison.net">fast</a> template engine for <span>PHP</span>. &nbsp; <a href="http://www.raintpl.com/FAQ/"><b>Rain</b>\Tpl</a> makes application easier to create & enables designers/developers to work better together.</div>

<header>
	<div id="logo"><a href="http://www.raintpl.com"><img src="<?php echo static::$conf['base_url']; ?>templates/raintpl3/img/logo.jpg" title="raintpl"> <b>3</b></a><br>&nbsp;easy PHP template engine</div>
</header>

<nav>
	<?php $counter1=-1;  if( isset($menu) && ( is_array($menu) || $menu instanceof Traversable ) && sizeof($menu) ) foreach( $menu as $key1 => $value1 ){ $counter1++; ?>
		<a href="<?php echo htmlspecialchars( $value1["link"], ENT_COMPAT, 'Something different', FALSE ); ?>" <?php if( $value1["selected"] ){ ?>class="selected"<?php } ?>><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'Something different', FALSE ); ?></a> &nbsp
	<?php } ?>
</nav>

<section>



		<h1>Rain \ TPL version <?php echo htmlspecialchars( $version, ENT_COMPAT, 'Something different', FALSE ); ?></h1>
		<h2>Features</h2>

		<div class="block">
			<a href="http://www.raintpl.com/Quick-Start/">
				<img src="<?php echo static::$conf['base_url']; ?>templates/raintpl3/img/easy.jpg" title="Easy - Really easy to install and to use" onmouseover="openpopup(this)" onmouseout="closepopup()"/>
				<img src="<?php echo static::$conf['base_url']; ?>templates/raintpl3/img/easy_text.jpg" title="Easy PHP Template Engine"/>
			</a>
			<div>
				8 Tags<br/>
				4 Methods
			</div>
		</div>
		<div class="block_separator">&nbsp;</div>
		<div class="block">
			<a href="http://www.raintpl.com/PHP-Template-Engines-Speed-Test/">
				<img src="<?php echo static::$conf['base_url']; ?>templates/raintpl3/img/fast.jpg" title="Fast - Click to see the speed test" onmouseover="openpopup(this)" onmouseout="closepopup()"/>
				<img src="<?php echo static::$conf['base_url']; ?>templates/raintpl3/img/fast_text.jpg" title="Fast PHP Template Engine"/>
			</a>
			<div>
				compiles HTML to PHP
			</div>
		</div>
		<div class="block_separator">&nbsp;</div>
		<div class="block">
			<a href="http://www.raintpl.com/FAQ/">
				<img src="<?php echo static::$conf['base_url']; ?>templates/raintpl3/img/useful.jpg" title="Useful - Designers create templates, developers load them" onmouseover="openpopup(this)" onmouseout="closepopup()"/>
				<img src="<?php echo static::$conf['base_url']; ?>templates/raintpl3/img/useful_text.jpg" title="Divide logic by presentation"/>
			</a>
			<div>
				Compatible with Smarty and Twig
			</div>
		</div>
		<div class="block_separator">&nbsp;</div>
		<div class="block">
			<a href="http://www.raintpl.com/Documentation/Documentation-for-web-designers/WYSIWYG/">
				<img src="<?php echo static::$conf['base_url']; ?>templates/raintpl3/img/wysiwyg.jpg" title="WYSIWYG - You can design with relative paths, Rain will replace them!" onmouseover="openpopup(this)" onmouseout="closepopup()"/>
				<img src="<?php echo static::$conf['base_url']; ?>templates/raintpl3/img/wysiwyg_text.jpg" title="WYSIWYG template"/>
			</a>
			<div>
				designs HTML templates
			</div>
		</div>
</section>
<?php require $this->checkTemplate("subfolder/footer");?>

</body>
</html>