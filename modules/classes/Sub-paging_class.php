<?

require_once dirname(__file__) . "/Main-paging_class.php";
require_once dirname(__file__) . "/../zincludethis.php";

class zpaging extends paging
{
    function print_link($InternalVar = "")
    {
//echo "<br />  inter var is [$InternalVar] <br />";
//exit;
        $parentlink = parent::print_link($InternalVar);
        $scriptname = basename($_SERVER['SCRIPT_NAME']);

        $pageinfo = $this->print_info();
        $LastPageNo = $pageinfo["total_pages"];

        //by khadim
        if (($LastPageNo <= 5)) {
            //echo "<br />  paranet link is [[$parentlink]] <br />";
            return $parentlink;
//exit;
        }

        $FirstPage = "<a href=\"$scriptname?page=1\">[First Page]</a>\n\r";
        $LastPage = "<a href=\"$scriptname?page=$LastPageNo\">[Last Page]</a>\n\r";

        $FirstPage = "";
        $LastPage = "";

        $return = $FirstPage . $parentlink . $LastPage;
        //echo "<br />return var is   $return <br />";
        //exit;
        return $return;
    }
}