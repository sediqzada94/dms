<?php
use App\library\Dateconverter;
use App\Models\User;
use Carbon\Carbon;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use Illuminate\Http\Request;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Language;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Os;

function generateFormNumber($f, $fiscal_year)
   {
    $modelName = '';
    $columnName = '';

    if($f == 'meem7'){
        $f = 'm7';
        $modelName = '\App\Models\Meem7';
        $columnName = 'meem7_number';
        }
    elseif($f == 'fc9'){
        $modelName = '\App\Models\Fecen9';
        $columnName = 'fecen9_number';
    }
    elseif($f == 'fc5'){
        $modelName = '\App\Models\Fecen5';
        $columnName = 'fecen5_number';
    }
    elseif($f == 'fc8'){
        $modelName = '\App\Models\Fecen8';
        $columnName = 'fecen8_number';
    }
    elseif($f == 'fc4'){
        $modelName = '\App\Models\Fecen4';
        $columnName = 'fecen4_number';
    }
    elseif($f == 'fc1'){
          $modelName = '\App\Models\Fecen1';
          $columnName = 'fecen1_number';
    }
    elseif($f == 'fc1'){
          $modelName = '\App\Models\Fecen1';
          $columnName = 'fecen1_number';
    }
    elseif($f == 'sejel'){
          $modelName = '\App\Models\Sejel';
          $columnName = 'sejel_number';
    }
    elseif($f == 'ctc'){
        $modelName = '\App\Models\CardToCard';
        $columnName = 'card_to_card_number';
  }
    else{
           return 'unknown form name';
      }
     return generateFormNum($f, $modelName, $columnName, $fiscal_year);
   }
   function generateFormNum($formName, $modelName, $columnName, $fiscal_year){
            $like_query = $formName.'-'.$fiscal_year.'%';
            $columnData = $modelName::where($columnName, 'like', $like_query )->get();
            if(count($columnData)>0){

                $latestFormNumber = $columnData->sortByDesc('id')->first()->$columnName;
                $latestFormNumberArray = explode('-', $latestFormNumber);
                return $formName.'-'.$fiscal_year.'-'.($latestFormNumberArray[2]+1);
            }
            else{
                return $formName.'-'.$fiscal_year.'-1';
            }

   }
    function currentDate() {
        return miladiToHijriOrJalali(Carbon::now()->format('Y-m-d'));
    } 
    function dateToMiladi($inputeDate){
        if(!$inputeDate) {
            return $inputeDate;
        }
        if(isset($_COOKIE['localStorageDateType'])) {
            $defaultDate = $_COOKIE['localStorageDateType'];
            if ($defaultDate === 'gregorian') {
                return $inputeDate;
            }
            if (!Str::contains($inputeDate, '/')) {
                return $inputeDate;
            }
            $inputeDate = explode('/', $inputeDate);
            $y = $inputeDate[0];
            $m = $inputeDate[1];
            $d = $inputeDate[2];
            if ($defaultDate === 'jalali') {
                return (new Jalalian($y, $m, $d))->toCarbon()->toDateString() ;
            }
            else if ($defaultDate === 'hijri') {
                return hijriToMiladiDate($y, $m, $d);
            } else {
                return 'date type is not specified';
            }
        } else {
            return 'Please set date type';
        }
    }

    function miladiToHijriOrJalali($inputeDate){
        if (!$inputeDate) {
            return $inputeDate;
        }
        if(isset($_COOKIE['localStorageDateType'])) {
            $defaultDate = $_COOKIE['localStorageDateType'];
            if ($defaultDate === 'gregorian') {
                return $inputeDate;
            }
            if ($defaultDate === 'jalali') {
                return Jalalian::fromCarbon(Carbon::parse($inputeDate))->format('Y/m/d');
            }
            else if ($defaultDate === 'hijri') {
                return dateMiladiToHijriQamari($inputeDate);
            } else {
                return 'date type is not specified';
            }
        } else {
            return 'Please set date type';
        }
    }

    function hijriToMiladiDate($y, $m, $d) {
            $date =  (int)((11 * $y + 3) / 30) + 354 * $y +
            30 * $m - (int)(($m - 1) / 2) + $d + 1948440 - 385;
            $miladiDate = explode('/', jdtogregorian($date));
            $miladiDate = $miladiDate[2].'-'.$miladiDate[0].'-'.$miladiDate[1];
                return $miladiDate;
        }

    function dateMiladiToHijriQamari($miladiDate)
    {
        $miladiDate = explode('-', $miladiDate);
        if (count($miladiDate) > 1) {
        $year = $miladiDate[0];
        $month = $miladiDate[1];
        $day = $miladiDate[2];
        if ($month < 3)
            {
                $year -= 1;
                $month += 12;
            }

            $a = floor($year / 100.0);
            $b = ($year === 1582 && ($month > 10 || ($month === 10 && $day > 4)) ? -10 :
                ($year === 1582 && $month === 10 ? 0 :
                    ($year < 1583 ? 0 : 2 - $a + floor($a / 4.0))));

            $julianDay = floor(365.25 * ($year + 4716)) + floor(30.6001 * ($month + 1)) + $day + $b - 1525;


            $y = 10631.0 / 30.0;
            $epochAstro = 1948084;
            $shift1 = 8.01 / 60.0;

            $z = $julianDay - $epochAstro;
            $cyc = floor($z / 10631.0);
            $z = $z - 10631 * $cyc;
            $j = floor(($z - $shift1) / $y);
            $z = $z - floor($j * $y + $shift1);

            $year = 30 * $cyc + $j;
            $month = (int)floor(($z + 28.5001) / 29.5);
            if ($month === 13)
            {
                $month = 12;
            }

            $day = $z - floor(29.5001 * $month - 29);
            return $year.'/'.$month.'/'.$day;
        } else {
            return '';
        }
    }

    function perPage($returnPerPageArray=false)
    {

        if($returnPerPageArray)
        {
            $appPerPage= [5,10,20,50,100];
            return json_encode($appPerPage);
        }
        return 10;
    }
    function lang(){
        return app()->getLocale();
    }
//    This is function get name and id from every master table
    function getRecordFromTable($table, $id=null, $ids=[])
    {
        $query = \DB::table($table)->select($table.'.name_'.lang().' '.'as name',$table.'.id');
        if ($id !== null) {
            return $query->where('id', $id)->first();
        }
        if (count($ids)>0) {
            return $query->whereIn('id', $ids)->get();
        }
        return $query->get();
    }
    // if user has passed permissions
    function hasPermission($permission=array(),$booleanResult=true)
    {
        if(!is_array($permission))
        {
            $permission=[$permission];
        }
        $user=auth()->user();
        if($user)
        {
            return (new User())->userPermissionsCheck($user->id,$permission,$booleanResult);
        }
    }

    function updateCreatedByOrUpdatedBy($table,$column,$id=null)
    {
        $rowUpdate   = ($id==null)?DB::table($table)->orderBy('created_at','desc')->first():
            DB::table($table)->where('id',$id)->first();
        DB::table($table)->where('id',$rowUpdate->id)->update([
            $column  =>auth()->user()->id
        ]);
    }

    function checkSlug($slug)
    {
        $user   = Auth()->user()->id;
        $roles  = DB::table('user_roles')->leftJoin('roles','roles.id','user_roles.role_id')
            ->where('user_roles.user_id',$user)
            ->get(['roles.slug'])->toArray();
        if (array_search($slug, array_column($roles, 'slug')) !== FALSE) {
            return true;
        }
        else {
            return false;
        }
    }
    /**
     * check the flow of a table
     *
     */


    /**
     * Update or insert the follow for specific table.
     *
     */

    function insertFlow($table,$column,$id)
    {
        $user   = auth()->user()->id;
        DB::table($table)->insert([
            $column           => $id,
            'status_slug'     => 'new',
            'date'            => Carbon::now(),
            'updated_by'      => $user,
            'created_by'      => $user,
        ]);
    }

    function insertLog($table,$log_type,$url,$form_name,$form_id,$data=null,$old_data=null,$request)
    {
        $browser = new Browser();
        $language = new Language();
        $browser_details = $browser->getName() . $browser->getVersion();
        $device = new Device();
        $os = new Os();

        $userData = [
            'browser'           => $browser_details,
            'operating_system'  => $os->getName(),
            'ip_address'        => getOriginalClientIp($request),
            'device_name'       => $device->getName(),
        ];
        $user   = auth()->user()->id;
        DB::table('logs')->insert([
            'table'      => $table,
            'date'       => Carbon::now(),
            'log_type'   => $log_type,
            'form_name'  => $form_name,
            'form_id'    => $form_id,
            'url'        => $url,
            'user_id'    => $user,
            'user_data'  => json_encode($userData),
            'old_data'  => $old_data?json_encode($old_data):null,
            'data'       => $data?json_encode($data):null,
        ]);
    }
    function getOriginalClientIp($request): string
    {
        $request = $request ?? request();
        $xForwardedFor = $request->header('x-forwarded-for');
        if (empty($xForwardedFor)) {
            $ip = $request->ip();
        } else {
            $ips = is_array($xForwardedFor) ? $xForwardedFor : explode(', ', $xForwardedFor);
            $ip = $ips[0];
        }
        return $ip;
    }

    //coded by naim
    // function getRecordFromTable1($table)
    // {
    //     return \DB::table($table)->select($table.'name',$table.'.id')->get();
    // }
?>
