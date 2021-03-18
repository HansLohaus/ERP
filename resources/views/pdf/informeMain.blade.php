<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style>
			@page { 
				margin: 1cm; 
			}
			html, body {
				font-family: "Poppins", sans-serif;
				font-size: 10px;
			}
			table {
				border-collapse: collapse;
				border-radius: 5px;
				overflow: hidden;
				width: 100%;
			}
			.bg-headers {
				background-color: #1E88E5;
				color: #FFFFFF;
			}
			tr:nth-child(even) {background-color: #f2f2f2}
			tr:nth-child(odd) {background-color: #FBFBFB}
			tr:nth-child(even) th {background-color: #DCDCDC}
			tr:nth-child(odd) th {background-color: #EEEEEE}
			.intercalar td:nth-child(even) {background-color: #DEDEDE}
			.intercalar tr:nth-child(odd) td:nth-child(even) {background-color: #EDEDED}
			.intercalar th {background-color: #D9D9D9}
			th, td {
				padding: 10px;
			}
			th {
				width: 33%;
			}
			.page-break { page-break-inside:avoid; page-break-after:always; }
			.footer { position: absolute; width:100%; border-top:1px solid gray; bottom: -20px;}
			.header { position: absolute; width:100%; border-bottom:1px solid gray; top: -20px;}
			.circle {
				display: inline-block;
				width: 8px;
	      height: 8px;
	      border-radius: 4px;
	      background: #2C2C2C;
	      margin: 0 auto;
			}

			.tabla-portada .col-3 {
				width: 100% !important;
			}
			.tabla-portada {
				font-size: 14px;
			}

			.fix-pad tr > th {
				padding-left: 1px;
				padding-right: 1px;
			}
		</style>
	</head>
	<body>
		@yield("page")
	</body>
</html>