<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    private $table = "";
    private $header = "";
    private $is_vote = false;

    function index()
    {
        $redirect = $this->thief();
        if ($redirect) {
            return $redirect;
        }


        return view('index');
    }

    function thief()
    {
        if (!Session::has('user')) {
            return redirect()->route('sign_in')->with('oops', 'oops');
        }

        if (Session::has('user_email')) {
            $email = Session::get('user_email');
            $user_data = DB::table('userdbs')->where('email', $email)->first();

            if (is_null($user_data->is_it) || is_null($user_data)) {
                return redirect()->to(route('check'));
            }
        }

        $voteData = DB::table('votes')->where('email', Session::get('user_email'))->first();

        $shirt_voted = false;
        $logo_voted = false;

        if ($voteData) {
            $shirt_voted = !is_null($voteData->shirt_voted) && $voteData->shirt_voted != 0;
            $logo_voted = !is_null($voteData->logo_voted) && $voteData->logo_voted != 0;
        }

        Session::put('shirt_voted', $shirt_voted);
        Session::put('logo_voted', $logo_voted);

        return null;
    }

    function check_deadline($event)
    {
        $now = time();

        $logo_start = strtotime("July 11, 2024 06:00:00");
        $logo_stop = strtotime("July 14, 2024 23:59:59");
        $shirt_start = strtotime("July 15, 2024 01:00:00");
        $shirt_stop = strtotime("July 15, 2024 23:59:59");

        if ($event === "logo") {
            if ($now < $logo_start || $now > $logo_stop) {
                return redirect()->route('index');
            }
        } else if ($event === "shirt") {
            if ($now < $shirt_start || $now > $shirt_stop) {
               // return redirect()->route('index');
               
            }
        }
    }


    function sign_in()
    {
        if (Session::get('user')) {
            return redirect()->route('index');
        }
        return view('sign_in');
    }

    function sign_in_check(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        return redirect()->back()->with("Invalid", "ไม่เชื่อครับโม้");
    }

    function sign_out()
    {
        Session::flush();
        return redirect(route('sign_in'));
    }

    function vote($event)
    {
        $redirect = $this->thief();
        if ($redirect) {
            return $redirect;
        }

        $dead_line = $this->check_deadline($event);
        if ($dead_line) {
            return $dead_line;
        }

        $where = "";
        if ($event === "logo") {
            $table = "logos";
            $header = "โลโก้สาขา";
            $where = 'logo_vote';
        } else if ($event === "shirt") {
            $table = "shirts";
            $header = "เสื้อสาขา";
            $where = "shirt_vote";
        } else {
            return abort(404);
        }

        $array_data = array();
        $all_data = DB::table('votes')
        ->select($where, DB::raw("COUNT(*) as count"))
        ->whereNotNull($where)
        ->groupBy($where)
        ->havingRaw("COUNT(*) >= 0")
        ->orderBy('count', 'DESC')
        ->get();

        $array_data["name"] = [];
        $array_data["count"] = [];
        foreach ($all_data as $data) {
            $array_data["name"][] = $data->$where;
            $array_data["count"][] = $data->count;
        }

        $score_board = array();
        $return_data = array();
        $score = array();
        $count = 0;

        for ($i = 0; $i < count($array_data["name"]); $i++) {
            $return_data[$i] = DB::table($table)->where('name', $array_data["name"][$i])->first();
            $score[$i] = $array_data["count"][$i];
            if ($i > 2) {
                $score_board[$return_data[$i]->name] = [DB::table($table)->where('name', $array_data["name"][$i])->first(), $array_data["count"][$i]];
            }
        }
        return view('vote', compact('event', 'header', 'return_data', 'score_board', 'score'));
    }

    function vote_check($event, $id,$color)
    {
        $dead_line = $this->check_deadline($event);
        if ($dead_line) {
            return $dead_line;
        }

        $voted = '';
        $vote = '';
        if ($event === "logo") {
            $table = "logos";
            $voted = 'logo_voted';
            $vote = 'logo_vote';
        } else if ($event === "shirt") {
            $table = "shirts";
            $voted = 'shirt_voted';
            $vote = 'shirt_vote';
        } else {
            return abort(404);
        }

        $user_data = DB::table('votes')->where('email', Session::get('user_email'))->first();
        $vote_data = DB::table($table)->where('id', $id)->first();

        if ($user_data) {
            if($color === "" || $color === "logo"){
                $update_data = [
                    $vote => $vote_data->name,
                    $voted => true
                ];
    
                DB::table('votes')->update($update_data);
            }else{
                $update_data = [
                    $vote => $vote_data->name,
                    $voted => true,
                    "shirt_color" => $color
                ];

                DB::table('votes')->update($update_data);
            }
        } else {
            if($color === "" || $color === "logo"){
                $insert_data = [
                    'email' => Session::get('user_email'),
                    $vote => $vote_data->name,
                    $voted => true,
                ];
    
                DB::table('votes')->insert($insert_data);
            }else{
                $insert_data = [
                    'email' => Session::get('user_email'),
                    $vote => $vote_data->name,
                    $voted => true,
                    "shirt_color" => $color
                ];

                DB::table('votes')->insert($insert_data);
            }
        }

        return redirect()->back();
    }

    function vote_list($event)
    {
        $redirect = $this->thief();
        if ($redirect) {
            return $redirect;
        }

        $dead_line = $this->check_deadline($event);
        if ($dead_line) {
            return $dead_line;
        }

        if ($event === "logo") {
            $table = "logos";
            $is_vote = Session::get('logo_voted');
            $header = "โลโก้สาขา";
        } else if ($event == "shirt") {
            $table = "shirts";
            $is_vote = Session::get('shirt_voted');
            $header = "เสื้อสาขา";
        } else {
            return abort(404);
        }

        $data = DB::table($table)->get();

        return view('vote_list', compact('data', 'event', 'is_vote', 'header'));
    }

    function vote_detail($event, $id)
    {
        $redirect = $this->thief();
        if ($redirect) {
            return $redirect;
        }

        $dead_line = $this->check_deadline($event);
        if ($dead_line) {
            return $dead_line;
        }


        $where = "";
        if ($event === "logo") {
            $table = "logos";
            $is_vote = Session::get('logo_voted');
            $header = "โลโก้สาขา";
            $where = "logo_vote";
        } else if ($event === "shirt") {
            $table = "shirts";
            $is_vote = Session::get('shirt_voted');
            $header = "เสื้อสาขา";
            $where = "shirt_vote";
        } else {
            return abort(404);
        }

        $data = DB::table($table)->where('id', $id)->first();
        $vote = DB::table('votes')
            ->select(DB::raw("COUNT(*) as count"))
            ->where($where, $data->name)
            ->first();

        if (is_null($data)) {
            return abort(404);
        }

        return view('vote_detail', compact('data', 'is_vote', 'event', 'id', 'header', 'vote'));
    }

    function check()
    {
        if (!Session::has('user')) {
            return redirect()->route('sign_in')->with('oops', 'oops');
        }
        try {
            $user_data = DB::table('userdbs')->where('email', Session::get('user_email'))->first();

            if (!is_null($user_data->is_it)) {
                return redirect()->route('index');
            } else {
                return view("it_check");
            }
        } catch (\Throwable $th) {
            return view("it_check");
        }
    }

    function it_check(Request $request, $email)
    {
        $id = DB::table('student_ids')->where('id', $request->input('id'))->first();
        $is_it = false;
        if ($id == null) {
            $data = [
                "is_it" => $is_it,
                "std_id" => $request->input('id')
            ];
            DB::table('userdbs')->where('email', $email)->update($data);
            return view('it_check', compact('is_it'));
        }

        $is_brat = true;
        $check_brat = DB::table('userdbs')->where('std_id', $request->input('id'))->first();
        if ($check_brat) {
            return view('it_check', compact('is_it', 'is_brat'));
        }

        if ($request->input('id') == $id->id) {
            $is_it = true;
        }
        $data = [
            "is_it" => $is_it,
            "std_id" => $request->input('id')
        ];
        DB::table('userdbs')->where('email', $email)->update($data);

        $user_data = DB::table('userdbs')->where('email', $email)->first();
        Session::put('is_it', $user_data->is_it);


        return view('it_check', compact('is_it'));
    }

    function again(){
        try {
            $user_data = DB::table('userdbs')->where('email', Session::get('user_email'))->first();

            if ($user_data->is_it === 1) {
                return redirect()->route('index');
            } else {
                DB::table('userdbs')->where('email',Session::get('user_email'))->insert(["is_it"=>null]);
                return redirect()->view("it_check");
            }
        } catch (\Throwable $th) {
            return view("it_check");
        }
    }
}
