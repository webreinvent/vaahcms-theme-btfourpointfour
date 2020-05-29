<?php  namespace VaahCms\Themes\BtFourPointFour\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ExtendController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public static function sidebarMenu()
    {
        $links = [
            [
                'link' => route('btfourpointfour.index'),
                'label' => 'Bt 4.4'
            ]
        ];

        $response['status'] = 'success';
        $response['data'] = $links;

        return $response;

    }

    //----------------------------------------------------------
    public static function topRightUserMenu()
    {
        $links = [];

        $response['status'] = 'success';
        $response['data'] = $links;

        return $response;
    }

    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------

}
