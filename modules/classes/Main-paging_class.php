<?
##############################################
# Shiege Iseng paging Class
# 04 Feb 2004
# shiegege at yahoo.com
# http://shiege.com/scripts/paging/
################
# Thanks to :
# Yngve Bergheim <yngvewb at hotmail.com>
##############################################

class paging
{
	var $koneksi;
	var $p;
	var $page;
	var $q;
	var $query;
	var $next;
	var $prev;
	var $number;

	function paging($baris=5, $langkah=5, $prev="[prev]", $next="[next]", $number="[%%number%%]")
	{
		$this->next=$next;
		$this->prev=$prev;
		$this->number=$number;
		$this->p["baris"]=$baris;
		$this->p["langkah"]=$langkah;
		$_SERVER["QUERY_STRING"]=preg_replace("/&page=[0-9]*/","",$_SERVER["QUERY_STRING"]);
		if (empty($_GET["page"])) {
			$this->page=1;
		} else {
			$this->page=$_GET["page"];
		}
	}

	function db($host="",$username="",$password="",$dbname=""){	
	
		$this->koneksi=mysql_pconnect($host, $username, $password) or die("Connection Error");
		mysql_select_db($dbname);
		return $this->koneksi;
	}

	function query($query)
	{
		$kondisi=false;
		// only select
		if (!preg_match("/^[\s]*select*/i",$query)) {
			$query="select ".$query;
		}

		$querytemp = mysqlquery_z($query);
		$this->p["count"]= mysql_num_rows($querytemp);

		// total page
		$this->p["total_page"]=ceil($this->p["count"]/$this->p["baris"]);

		// filter page
		if  ($this->page<=1)
			$this->page=1;
		elseif ($this->page>$this->p["total_page"])
			$this->page=$this->p["total_page"];

		// awal data yang diambil
		$this->p["mulai"]=$this->page*$this->p["baris"]-$this->p["baris"];

		$query=$query." limit ".$this->p["mulai"].",".$this->p["baris"];

		$query=mysqlquery_z($query);
		$this->query=$query;
	}
	
	function result()
	{
		return $result=mysql_fetch_object($this->query);
	}

	function result_assoc()
	{
		return mysql_fetch_assoc($this->query);
	}

	function print_no()
	{
		$number=$this->p["mulai"]+=1;
		return $number;
	}
	
	function print_color($color1,$color2)
	{
		if (empty($this->p["count_color"]))
			$this->p["count_color"] = 0;
		if ( $this->p["count_color"]++ % 2 == 0 ) {
			return $color=$color1;
		} else {
			return $color=$color2;
		}
	}

	function print_info()
	{
		$page=array();
		$page["start"]=$this->p["mulai"]+1;
		$page["end"]=$this->p["mulai"]+$this->p["baris"];
		$page["total"]=$this->p["count"];
		$page["total_pages"]=$this->p["total_page"];
			if ($page["end"] > $page["total"]) {
				$page["end"]=$page["total"];
			}
			if (empty($this->p["count"])) {
				$page["start"]=0;
			}

		return $page;
	}

    /**
     * custom function added by zain
     */
    function link_template($vHref, $vTitle)
    {
        return "<a href='$vHref'>". $vTitle ."</a>\n";
    }

	function print_link($InternalVar="")
	{
		
		//generate template
		
		$print_link = false;

		if ($this->p["count"]>$this->p["baris"]) {

			// print prev
			if ($this->page>1){
			$print_link .= $this->link_template($_SERVER["PHP_SELF"]."?$InternalVar&".$_SERVER["QUERY_STRING"]."&page=".($this->page-1),
                $this->prev);

			// set number
			$this->p["bawah"]=$this->page-$this->p["langkah"];
				if ($this->p["bawah"]<1) $this->p["bawah"]=1;

			$this->p["atas"]=$this->page+$this->p["langkah"];
				if ($this->p["atas"]>$this->p["total_page"]) $this->p["atas"]=$this->p["total_page"];

			// print start
			if ($this->page<>1)
			{
				for ($i=$this->p["bawah"];$i<=$this->page-1;$i++)
//					$print_link .=$this->link_template($_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"]."&page=$i" ,
//					numberK($i,$this->number));
					$print_link .="<a href=\"".$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"]."&page=$i\">".numberK($i,$this->number)."</a>\n";
			//echo "<br />  and internal var is  [$InternalVar] <br />";
			}
			
			// print active
			$TotalPages=$this->p["total_page"];
			if ($TotalPages>1)
			//echo "<br /> <pre> <br />";
			//print_r($this->p["total_page"]);
			//echo "<br /> </pre> <br />";
			//echo "<br /> this->page=$this->page, this->number=$this->number <br />";
			$PageK=$this->page;
			$PageNumberK=$this->number;
			$PrintLinkK=$this->numberK($PageK,$PageNumberK);
				$print_link .= "<b>".$PrintLinkK."</b>\n";
				

			// print end
			$_SERVER["QUERY_STRING"].="&$InternalVar";
			for ($i=$this->page+1;$i<=$this->p["atas"];$i++)
			$print_link .= $this->link_template($_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"]."&page=$i",
			    $this->numberK($i,$this->number));
//                "<a href=\"".$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"]."&page=$i\">".$this->numberK($i,$this->number)."</a>\n";
//echo "<br />  parent links are [$print_link] <br />";
//exit;
			// print next
			if ($this->page<$this->p["total_page"])
			$print_link .= $this->link_template($_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"]."&page=".($this->page+1),
			    $this->next);
//			$print_link .= "<a href=\"".$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"]."&page=".($this->page+1)."\">".$this->next."</a>\n";

			return $print_link;
		}
	}
}

    function numberK($i, $number)
    {
        return ereg_replace("^(.*)%%number%%(.*)$", "\\1$i\\2", $number);
    }
}