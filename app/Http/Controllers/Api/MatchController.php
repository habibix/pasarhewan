<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use JWTAuthException;

use App\Models\User;
use App\Models\Match;
use App\Models\MatchScore;
use App\Models\MemberPoint;
use App\Models\Winner;
use Yajra\DataTables\DataTables;

class MatchController extends Controller
{
    public function __construct()
    {
        $this->match = new Match();
    }

    public function index()
    {
        return response()->json([
           'status' => 200,
           'data' => Match::all(),
           'message' => 'Data match berhasil diambil'
        ]);
    }

    public function getMatchActive()
    {
        //$match = Match::where('status', 1)->get();
        $match = Match::all()->sortByDesc('created_at');
        $data = [];

        foreach ($match as $row){
            $data[] = [
                'id' => $row->id,
                'name_club_1' => $this->match->club($row->club_id_1)->club_name,
                'logo_club_1' => $this->match->club($row->club_id_1)->image,
                'name_club_2' => $this->match->club($row->club_id_2)->club_name,
                'logo_club_2' => $this->match->club($row->club_id_2)->image,
                'date_time' => $row->date_match->format('l, d M Y'),
                'kickoff' => $row->kickoff,
                'status' => $row->status
            ];
        }

        return response()->json([
           'status' => 200,
           'data' => $data,
           'message' => 'Data match active'
        ]);
    }

    public function getMatchDetail(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
            $match = Match::findOrFail($request->id);

            $accessTime = time(); //Waktu sekarang
            $kickoff = strtotime($match->date_match); //Waktu KickOff Pertandingan
            $kickoff30 = strtotime('+30 minutes', $kickoff); //Waktu KickOff Pertandingan ditambah 30 Menit

            if ($accessTime <= $kickoff30){ // Jika waktu sekarang lebih kecil dari kickoff + 30menit = true

                $matchScore = MatchScore::where('match_id', $match->id)->where('user_id', $user->id)->first();
                $data = [
                    'id' => $match->id,
                    'name_club_1' => $this->match->club($match->club_id_1)->club_name,
                    'logo_club_1' => $this->match->club($match->club_id_1)->image,
                    'name_club_2' => $this->match->club($match->club_id_2)->club_name,
                    'logo_club_2' => $this->match->club($match->club_id_2)->image,
                    'date_time' => $match->date_match->format('l, d F Y'),
                    'kickoff' => $match->kickoff,
                    'status' => $match->status == 1 ? 'Aktif' : 'Selesai',
                    'status_user' => $matchScore == null ? '0' : '1'
                ];

                return response()->json([
                    'status' => 200,
                    'data' => $data,
                    'message' => 'Data Match Detail'
                ]);

            } else { // Sebaliknya

                $data = NULL;
                $status = 406;
                $msg = 'Waktu habis untuk akses detail match';

                return response()->json([
                    'status' => 406,
                    'data' => NULL,
                    'message' => $msg
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getWinner(Request $request)
    {

        try {

            $data = [];
            $match = Match::findOrFail($request->id);
            $id = $request->id;

            $winner = Winner::where('match_id', $id)
                ->orderBy('point', 'dsc')
                ->get();

            if(count($winner) > 0){
                foreach ($winner AS $row) {
                    $user = User::where('id', $row->user_id)->first();
                    $data[] = [
                        'id' => $row->id,
                        'username' => $user->name,
                        'point' => $row->point,
                        'hadiah' => $row->hadiah == 1 ? 'Pulsa 20.000' : '+30 Poin',
                    ];
                }

                return response()->json([
                   'status' => 200,
                   'data' => $data,
                   'message' => 'success',
                   'name_club_1' => $match->club($match->club_id_1)->club_name,
                   'logo_club_1' => $match->club($match->club_id_1)->image,
                   'name_club_2' => $match->club($match->club_id_2)->club_name,
                   'logo_club_2' => $match->club($match->club_id_2)->image,
                   'score_1' => $match->score_club_1,
                   'score_2' => $match->score_club_2,
                   'date' => $match->date_match->format('D, d F Y')
                ]);

            } else {
                return response()->json([
                    'status' => 500,
                    'data' => null
                ]);
            }
            
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function postMatchPredict(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'match_id' => 'required',
            'score_1' => 'required',
            'score_2' => 'required',
            'curent_point' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'data' => null,
                'message' => $validator->getMessageBag()->toArray()
            ]);
        }

        try {
            $user = JWTAuth::toUser($request->token);
            $match = Match::findOrFail($request->match_id);

            $matchScore = MatchScore::where('match_id', $match->id)->where('user_id', $user->id)->first();
            
            if ($matchScore) {
                return response()->json([
                    'status' => 406,
                    'data' => NULL,
                    'message' => 'User has been predicted this match'
                ]);
            }

            $predictTime = time(); //Waktu sekarang
            $kickoff = strtotime($match->date_match); //Waktu KickOff Pertandingan
            $kickoff30 = strtotime('+30 minutes', $kickoff); //Waktu KickOff Pertandingan ditambah 30 Menit

            if ($predictTime <= $kickoff30){ // Jika waktu sekarang lebih kecil dari kickoff + 30menit = true
                $insertData = [
                    'match_id' => $match->id,
                    'user_id' => $user->id,
                    'date' => date('Y-m-d'),
                    'score_1' => $request->score_1,
                    'score_2' => $request->score_2,
                    'curent_point' => $request->curent_point
                ];

                //return $insertData;

                $data = MatchScore::create($insertData);
                $status = 200;
                $msg = 'Post match predict success';

            } else { // Sebaliknya

                $data = NULL;
                $status = 406;
                $msg = 'Waktu habis untuk menebak';
            }

            return response()->json([
                'status' => $status,
                'data' => $data,
                'message' => $msg
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }

    }
}
