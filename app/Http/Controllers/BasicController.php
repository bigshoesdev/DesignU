<?php namespace App\Http\Controllers;

use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Sentinel;
use View;

class BasicController extends Controller {

    /**
     * Message bag.
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $messageBag = null;

    /**
     * Initializer.
     *
     */
    public function __construct()
    {
        $this->messageBag = new MessageBag;

    }

    public function showHome()
    {
        if(Sentinel::check())
            return view('admin.index');
        else
            return redirect('admin/signin')->with('error', 'You must be logged in!');
    }

    public function showView($name=null)
    {
        if(View::exists('admin/'.$name))
        {
            if(Sentinel::check())
                return view('admin.'.$name);
            else
                return redirect('admin/signin')->with('error', 'You must be logged in!');
        }
        else
        {
            abort('404');
        }
    }

    public function downloadImage(Request $req) {
        $url = $req->get('url');

        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );

        $response = response()->download($url, null, $headers);

        ob_end_clean();

        return $response;
    }

}