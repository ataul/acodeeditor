<html>
	<head>
		<title>Admin Panel</title>
		<link rel="stylesheet" type="text/css" href="resources/css/ext-all.css" />
		<link rel="stylesheet" type="text/css" href="resources/css/custom-tree.css" />
		<script type="text/javascript" src="resources/js/ext-base.js" ></script>
		<script type="text/javascript" src="resources/js/ext-all.js" ></script>
		<script type="text/javascript" src="resources/js/admin_lib.js" ></script>
		
		<script type="text/javascript" src="resources/js/editable_tree_lib.js"></script>
		<script type="text/javascript">
		<?
			
			echo "treeNodes = [";
			require('resources/query/get_admin_panel_tree.php');
			echo "];";
			
		?>
		</script>
		<script type="text/javascript" src="resources/js/admin_panel.js" ></script>
		<script type="text/javascript" src="resources/js/admin_lib.js" ></script>
		
		
	</head>
	<body>
	<div id="west">
		<div id="tree-ct"></div>
	</div>
  <div id="north">
    <center> <h1>Administrative Control Panel</h1></center>
  </div>
	<div id="center2">
        
	</div>	
  <div id="center1">
    <div id="admin_edit_form"></div>    

  </div>
  
  <div id="south">
    <p>Help Center at the right.</p>
  </div>	
	</body>
</html>