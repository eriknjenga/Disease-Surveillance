<head>
	<link rel="stylesheet" href="css.css" />
	<script src="js/jquery.js"></script>
	<script>
		$(document).ready(function() {
			$('#show-alert').click(function() {
				$('<div class="quick-alert">Alert! Watch me before it\'s too late!</div>').insertAfter($(this)).fadeIn('slow').animate({
					opacity : 1.0
				}, 3000).fadeOut('slow', function() {
					$(this).remove();
				});
			});
		});

	</script>
	<title>Forgotten Passowrd Resolution</title>
</head>
<body>
	<div class="quick-alert">
		Alert! Watch me before it's too late!
	</div>
	<input type="submit" id="show-alert" value="Show Alert" />
</body>

