<?php

namespace Carddb\View\Helper;
use Zend\View\Helper\AbstractHelper;

class QueryString extends AbstractHelper
{
    public function __invoke()
    {
    		$string = http_build_query($this->view->query);
        return $string;
    }

/*    public function fooMethod( $test ){
        echo $test;
    }

    public function barMethod(){
        echo 'hai';
    } */

}
