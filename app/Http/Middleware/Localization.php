<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Language;
use App\Models\Setting;
use App\Models\TicketStatus;
use App\Models\Permission;
use Illuminate\Support\Facades\Schema;
use DB;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $uri =  \Request::getRequestUri();
        $iSinstallRoute = false;
        if(substr( $uri, 0, 8 ) === "/install") {
            $iSinstallRoute = true;
        }

        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
        if (!$iSinstallRoute) {

            if(!file_exists(storage_path('installed'))) {
                // if app is not installed.
                return redirect()->route('LaravelInstaller::welcome');
            }

            View::share('languages', Language::all());
            View::share('imap_enables', Setting::where('id', 1)->first());
            View::share('statuses', TicketStatus::all());
            View::share('extension', Setting::where('id', 2)->value('value'));
            View::share('statusPermission', Permission::where('name', 'ticket_status_management')
                ->where('role', 'staff')
                ->value('status'));
            View::share('departmentPermission', Permission::where('name', 'departments_management')
                ->where('role', 'staff')
                ->value('status'));
            View::share('kbPermission', Permission::where('name', 'knowledge_base_management')
                ->where('role', 'staff')
                ->value('status'));
            View::share('tagsPermission', Permission::where('name', 'tags_management')
                ->where('role', 'staff')
                ->value('status'));


            $app_name = Setting::where('name', 'app_name')->value('value');
            $words = explode(" ", $app_name);
            $app_name_short = "";
            if($words[0]!=null) {
                foreach ($words as $w) {
                $app_name_short .= $w[0];
                }
            }
            View::share('app_name_short', $app_name_short);
            View::share('app_name', $app_name);
            View::share('logo', Setting::where('name', 'system_logo')
                ->value('value'));
            View::share('footer_text', Setting::where('name', 'footer_text')
                ->value('value'));

        }
        return $next($request);
    }
}
