<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use QrCode;

use Carbon\Carbon;


class FrontendController extends Controller
{

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {   

        return view('welcome');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function about()
    {   

        return view('frontend.about');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function coming()
    {   

        return view('coming-soon');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function success()
    {   

        return view('frontend.successful');
    }

    public function qrcode()
    {   

        $qrcode = QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');
        return view('frontend.test.index', compact('qrcode'));
    }

    public function carbon(){

        printf("Right now is %s", Carbon::now()->toDateTimeString());
        printf("<br/>");


        printf("<br/>");
        $dt = Carbon::now();

        // var_dump($dt->toDateTimeString() == $dt);          // bool(true) => uses __toString()
        echo $dt->toDateString();

        printf("<br/>");

        printf("Right now in Vancouver is %s", Carbon::now('America/Vancouver'));  //implicit __toString()

        printf("<br/>");
        $tomorrow = Carbon::now()->addDay();
        $lastWeek = Carbon::now()->subWeek();

        printf("<br/>");

        printf($tomorrow);
        printf("<br/>");

        printf($lastWeek);
        printf("<br/>");

        $dt = Carbon::parse('1975-05-21 22:23:00.123456');
        // echo $dt->date; 
        printf("<br/>");

        $nextSummerOlympics = Carbon::createFromDate(2012)->addYears(4);
        printf($nextSummerOlympics);
        printf("<br/>");

        $officialDate = Carbon::now()->toRfc2822String();
        printf($officialDate);
        printf("<br/>");

        $datealone = Carbon::createFromFormat('Y-m-d', '1975-05-21')->toDateTimeString(); // 1975-05-21 22:00:00
        printf($datealone);
        printf("<br/>");


        $howOldAmI = Carbon::createFromDate(1960, 5, 21)->age;
        printf("This B Age:  ".$howOldAmI);
        printf("<br/>");

        $noonTodayLondonTime = Carbon::createFromTime(12, 0, 0, 'Europe/London');
        printf($noonTodayLondonTime);
        printf("<br/>");

        $worldWillEnd = Carbon::createFromDate(2012, 12, 21, 'GMT');
        printf($worldWillEnd);
        printf("<br/>");


        // Don't really want to die so mock now
        $dateformat = Carbon::setTestNow(Carbon::createFromDate(2000, 1, 1));
        printf($dateformat);
        printf("<br/>");

        // comparisons are always done in UTC
        if (Carbon::now()->gte($worldWillEnd)) {
            echo "Worlds End";
        }
        printf("<br/>");
        // Phew! Return to normal behaviour
        Carbon::setTestNow();

        if (Carbon::now()->isWeekend()) {
            echo 'Party!';
        }
        echo Carbon::now()->subMinutes(1)->diffForHumans(); // '2 minutes ago'

        // ... but also does 'from now', 'after' and 'before'
        // rolling up to seconds, minutes, hours, days, months, years
        printf("<br/>");

        $daysSinceEpoch = Carbon::createFromTimestamp(0)->diffInDays();
        printf($daysSinceEpoch);

    }

}