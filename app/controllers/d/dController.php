<?php
/**
 * @author awei.tian
 * date: 2013-9-18
 * 说明:
 */
class dController extends appController{
	public static function _checkPrivilege(message $msg,identityToken $it){
		return true;
	}
	public function welcomeAction(){
		echo "<form action='/sea/d/q'>
				<table>
				<tr><td>npslid:</td><td><input name='npsid'></td></tr>
				<tr><td>nssid:</td><td><input name='nssid'></td></tr>
				<tr><td>dsnsid:</td><td><input name='dsnsid'></td></tr>
				</table>
				<input type='submit' value='query'>
				</form>
				";
	}
	public function qAction(message $msg){
		require_once ENTRY_PATH."/app/datasrc/path2sid.php";
		require_once ENTRY_PATH."/app/datasrc/DataSrcPath.php";
		$i = new path2sid();
		if(isset($msg["?npsid"])){
			if(preg_match("/^\d+$/", $msg["?npsid"])){
				echo "npsid:".$i->getPathByNpsid($msg["?npsid"])."<br>";
			}else{
				if(($msg["?npsid"])){
					echo "npsid:".$i->getNpsidByPath($msg["?npsid"])."<br>";
				}
			}
		}
		if(isset($msg["?nssid"])){
			if(preg_match("/^\d+$/", $msg["?nssid"])){
				echo "nssid:".$i->getPathkeyByNssid($msg["?nssid"])."<br>";
			}else{
				if(($msg["?nssid"])){
					$d = new DataSrcPath($msg["?nssid"]);
					echo "nssid:".$i->getNssidByPathKey($d->getNodePath(), $d->getNameSpaceId())."<br>";
				}
			}
		}
		if(isset($msg["?dsnsid"])){
			if(preg_match("/^\d+$/", $msg["?dsnsid"])){
				echo "dsnsid:".$i->getPathkeypathByDsnsid($msg["?dsnsid"])."<br>";
			}else{
				if(($msg["?dsnsid"])){
					$d = new DataSrcPath($msg["?dsnsid"]);
					echo "dsnsid:".$i->getDsnsidByPathKeyPath($d->getNodePath(), $d->getNameSpaceId(), $d->getNameSpacePath());//($msg["?dsnsid"])."<br>";
				}
			}
		}
		echo "<br><a href='/sea/d'>back</a>";
	}
	public function hypAction(message $msg){
		echo $msg["?aa"];
	}
}