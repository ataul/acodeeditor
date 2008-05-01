<html>
	<head>
		<title>Code Editor</title>
		<script src="../codepress/codepress.js" type="text/javascript"></script>
		
	<link rel="stylesheet" href="../css/mocha.css" type="text/css" />
	<script type="text/javascript" src="../js/mootools-trunk-1475.js" charset="utf-8"></script>
	<!--[if IE]>
		<script type="text/javascript" src="scripts/excanvas-compressed.js"></script>		
	<![endif]-->
	<script type="text/javascript" src="../js/mocha-events.js" charset="utf-8"></script>	
	<script type="text/javascript" src="./js/mocha.js" charset="utf-8"></script>	
	
	</head>
	<body>
	<div id="mochaDesktop">
		<div id="mochaDesktopHeader">
			<div id="mochaDesktopTitlebar">
				<h1>Code Editor<span class="version"> v 0.2</span></h1>
			</div>
	
<div id="mochaDesktopNavbar">
<ul>
	<li>
	<script type="text/javascript">
		function changeLang(f){			
			switch(f){
				case 'php':						
					code.edit('','php');						
				break;
				case 'java':						
					code.edit('','java');						
				break;
				case 'javascript':						
					code.edit('','javascript');						
				break;
				case 'sql':						
					code.edit('','sql');						
				break;
				case 'html':						
					code.edit('','html');						
				break;
			}
		}
		
		function changeView(){
			code.toggleLineNumbers();		
		}
	</script>
	<a class="returnFalse" href="">View</a>	
		<ul>
			<li><a id="Toggle_Line_no" href="" onclick="changeView()">Toggle Line no</a></li>
				
		</ul>
	</li>
	<li>
		<a class="returnFalse" href="">Language</a>
			<ul>
				<li><a href="" onclick="changeLang('php');">PHP</a></li>
				<li><a href="" onclick="changeLang('java');">Java</a></li>
				<li><a href="" onclick="changeLang('sql');">SQL</a></li>
				<li><a href="" onclick="changeLang('html');">HTML</a></li>							
				<li><a href="" onclick="changeLang('javascript');">Javascript</a></li>							
			</ul>
			
	</li>
	<li>
			<a class="returnFalse" href="">Help</a>
			<ul>
				<li style="padding: 1px 9px;" onclick="alert('Created by Atul\nV 0.2 (13/04/08)');">About</li>				
			</ul>
			
	</li>
</div><!-- mochaDesktopNavbar end -->

</div><!-- mochaDesktopHeader end -->
	
				<textarea id="code" rows="10" col="20" class="codepress java" style="width:900px;height:500px;" >
   
</textarea>	

	</body>
</html>
