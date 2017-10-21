<?php
/**
 * pagination
 * Method helper that calculates the pagination
 *
 * @param $uri
 * @param $page
 * @param $data
 * @return string $html
 */
function pagination( $uri, $page, $data ){
    $last  = ceil($data->total / $data->limit);
    $start = (($page - 2) > 0) ? $page - 2 : 1;
    $end   = (($page + 2) < $last) ? $page + 2 : $last;

    $html = '<ul class="pagination">';

    if ($page > 1) {
        $html .= '<li class="page-item">
                    <a class="page-link" href="' . Config::BASE_URL . '/' . $uri . '?p=' . ($page - 1) . '" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>';
    }

    for ($i=$start; $i<=$end; $i++) {
        $active = "";

        if ($i == $page) {
            $active = " active";
        }

        $html .= '<li class="page-item' . $active . '"><a class="page-link" href="' . Config::BASE_URL. '/' . $uri . '?p=' . $i . '">' . $i . '</a></li>';
    }

    if ($page != $last) {
        $html .= '<li class="page-item">
                <a class="page-link" href="' . Config::BASE_URL . '/' . $uri . '?p=' . ($page + 1) . '" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>';
    }

    $html .= '</ul>';
    return $html;
}
?>