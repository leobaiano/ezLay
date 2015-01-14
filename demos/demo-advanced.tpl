<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ezLay - Advanced demo - Hello {word}</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1>Hello {word}</h1>
		<p class="lead">This is a quick demo {message}</p>
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th>E-mail</th>
					<th>City</th>
				</tr>
			</thead>
			<tbody>
				<loopthis>
					<tr>
						<td>{name}</td>
						<td>{email}</td>
						<td>{city} <nonus>(US)</nonus></td>
					</tr>
				</loopthis>
			</tbody>
		</table>
		<h2>Another example</h2>
		<table class="table">
			<thead>
				<tr>
					<th>Colors</th>
					<th>Hex</th>
				</tr>
			</thead>
			<tbody>
				<loopthistoo>
					<tr>
						<td>{color_name}</td>
						<td><span style="display: inline-block; width: 10px; height: 10px; background-color: {hex_code};"></span></td>
					</tr>
				</loopthistoo>
			</tbody>
		</table>
		<hidethis>	
			<h3>Some text that must be hidden</h3>
		</hidethis>
	</div>
</body>
</html>