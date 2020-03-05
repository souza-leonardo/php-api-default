<?php

class Utilities
{
    public function getPaging($page, $totalRows, $recordsPerPage, $pageUrl)
    {
        $pagingArr = [];

        $pagingArr['first'] = $page > 1 ? "{$pageUrl}page=1" : "";

        $totalPages = ceil($totalRows / $recordsPerPage);

        $range = 2;

        $initialNum = $page - $range;
        $conditionLimitNum = ($page + $range) + 1;

        $pagingArr['pages'] = [];
        $pageCount = 0;

        for ($x = $initialNum; $x < $conditionLimitNum; $x++) {
            if (($x > 0) && ($x <= $totalPages)) {
                $pagingArr['pages'][$pageCount]['page'] = $x;
                $pagingArr['pages'][$pageCount]['url'] = "{$pageUrl}page={$x}";
                $pagingArr['pages'][$pageCount]['current_page'] = $x == $page ? 'yes' : 'no';

                $pageCount++;
            }
        }

        $pagingArr['last'] = $page < $totalPages ? "{$pageUrl}page={$totalPages}" : "";

        return $pagingArr;
    }
}