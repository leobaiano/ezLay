<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ezLay - Intermediate demo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1>ezLay intermediate demo</h1>
		<p class="lead">With ezLay, you can easily repeat HTML blocks and replace contents inside it</p>
		<table class="table">
			<thead>
				<tr>
					<th>Colors</th>
					<th>Hex</th>
				</tr>
			</thead>
			<tbody>
				<loopexample>
					<tr>
						<td>{color_name}</td>
						<td><span style="display: inline-block; width: 10px; height: 10px; background-color: {hex_code};"></span></td>
					</tr>
				</loopexample>
			</tbody>
		</table>
	</div>
</body>
</html>