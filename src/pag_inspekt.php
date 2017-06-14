<?php
function paginate($count) {
    $page = (int) (!isset($_REQUEST['page']) ? 1 :$_REQUEST['page']);
    $page = ($page == 0 ? 1 : $page);
    $recordsPerPage = 100;
    $adjacents = "2";
    $lastpage = ceil($count/$recordsPerPage);
    $lpm1 = $lastpage - 1;
    $pagination = "";
    if($lastpage > 1) {
        if ($page > 1)
            $pagination .= "<li id=\"inspekt-prev\">
                                <a href=\"#\" id=\"pagePrev\">
                                    <i class=\"fa fa-arrow-left\"></i>
                                </a>
                           </li>";
        else
            $pagination .= "<li id=\"inspekt-prev\" class=\"disabled\">
                                <a href=\"#\" id=\"pagePrev\" tabindex=\"-1\">
                                    <i class=\"fa fa-arrow-left\"></i>
                                </a>
                           </li>";

        if ($lastpage < 7 + (intval($adjacents) * 2)) {
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page)
                    $pagination .= "<li id=\"inspekt-" . $counter . "\" class=\"active-primary\">
                                        <a href=\"#\" class=\"pageInspekt\">$counter</a>
                                    </li>";
                else
                    $pagination .= "<li id=\"inspekt-" . $counter . "\">
                                        <a href=\"#\" class=\"pageInspekt\">$counter</a>
                                    </li>";

            }
        }

        elseif($lastpage > 5 + (intval($adjacents) * 2))
        {
            if($page < 1 + (intval($adjacents) * 2))
            {
                for($counter = 1; $counter < 4 + (intval($adjacents) * 2); $counter++)
                {
                    if($counter == $page)
                        $pagination .= "<li id=\"inspekt-" . $counter . "\" class=\"active-primary\">
                                        <a href=\"#\" class=\"pageInspekt\">$counter</a>
                                    </li>";
                    else
                        $pagination .= "<li id=\"inspekt-" . $counter . "\">
                                        <a href=\"#\" class=\"pageInspekt\">$counter</a>
                                    </li>";
                }
                $pagination.= "<li class=\"paggination-dots\"><span><i class=\"fa fa-ellipsis-h fa-lg\" style=\"color:black;\"></i></span></li>";
                $pagination .= "<li id=\"inspekt-" . $lpm1 . "\">
                                        <a href=\"#\" class=\"pageInspekt\">$lpm1</a>
                                    </li>";
                $pagination .= "<li id=\"inspekt-" . $lastpage . "\">
                                        <a href=\"#\" class=\"pageInspekt\">$lastpage</a>
                                    </li>";

            }
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
            {
                $pagination .= "<li id=\"inspekt-1\">
                                        <a href=\"#\" class=\"pageInspekt\">1</a>
                                    </li>";
                $pagination .= "<li id=\"inspekt-2\">
                                        <a href=\"#\" class=\"pageInspekt\">2</a>
                                    </li>";
                $pagination.= "<li class=\"paggination-dots\"><span><i class=\"fa fa-ellipsis-h fa-lg\" style=\"color:black;\"></i></span></li>";
                for($counter = $page - $adjacents; $counter <= $page + intval($adjacents); $counter++)
                {
                    if($counter == $page)
                        $pagination .= "<li id=\"inspekt-" . $counter . "\" class=\"active-primary\">
                                        <a href=\"#\" class=\"pageInspekt\">$counter</a>
                                    </li>";
                    else
                        $pagination .= "<li id=\"inspekt-" . $counter . "\">
                                        <a href=\"#\" class=\"pageInspekt\">$counter</a>
                                    </li>";
                }
                $pagination.= "<li class=\"paggination-dots\"><span><i class=\"fa fa-ellipsis-h fa-lg\" style=\"color:black;\"></i></span></li>";
                $pagination .= "<li id=\"inspekt-" . $lpm1 . "\">
                                        <a href=\"#\" class=\"pageInspekt\">$lpm1</a>
                                    </li>";
                $pagination .= "<li id=\"inspekt-" . $lastpage . "\">
                                        <a href=\"#\" class=\"pageInspekt\">$lastpage</a>
                                    </li>";
            }
            else
            {
                $pagination .= "<li id=\"inspekt-1\">
                                        <a href=\"#\" class=\"pageInspekt\">1</a>
                                    </li>";
                $pagination .= "<li id=\"inspekt-2\">
                                        <a href=\"#\" class=\"pageInspekt\">2</a>
                                    </li>";
                $pagination.= "<li class=\"paggination-dots\"><span><i class=\"fa fa-ellipsis-h fa-lg\" style=\"color:black;\"></i></span></li>";
                for($counter = $lastpage - (2 + (intval($adjacents) * 2)); $counter <= $lastpage; $counter++)
                {
                    if($counter == $page)
                        $pagination .= "<li id=\"inspekt-" . $counter . "\" class=\"active-primary\">
                                        <a href=\"#\" class=\"pageInspekt\">$counter</a>
                                    </li>";
                    else
                        $pagination .= "<li id=\"inspekt-" . $counter . "\">
                                        <a href=\"#\" class=\"pageInspekt\">$counter</a>
                                    </li>";
                }
            }
        }
        if($page < $counter - 1)
            $pagination.= "<li id=\"inspekt-next\">
                                <a href=\"#\" id=\"pageNext\">
                                    <i class=\"fa fa-arrow-right\"></i>
                                </a>
                          </li>";
        else
            $pagination.= "<li id=\"inspekt-next\" class=\"disabled\">
                                <a href=\"#\" id=\"pageNext\" tabindex=\"-1\">
                                      <i class=\"fa fa-arrow-right\"></i>
                                </a>
                           </li>";

    }
    return $pagination;
}