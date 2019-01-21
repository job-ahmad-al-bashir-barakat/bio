<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Notifications\InboxMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\User;

class ContactController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth']);
    }

    function index ()
    {
        return view('site.page.contact');
    }

    function mailToAdmin (ContactFormRequest $message)
    {
        $admin = User::where('is_admin','=',true)
            ->where('id','=',User::SUPER_ADMIN_ID)
            ->first();

        $admin->notify(new InboxMessageNotification($message));

        return redirect()->back()->with('message', 'thanks for the message! We will get back to you soon!');
    }
}
