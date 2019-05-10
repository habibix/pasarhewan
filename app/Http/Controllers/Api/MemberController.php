<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use JWTAuthException;

use App\Models\User;
use App\Models\Match;
use App\Models\MatchScore;
use App\Models\MemberPoint;
use App\Models\Winner;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->match = new Match();
    }

    public function getMemberProfile(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
	    $point = $user->point['point'];


            return response()->json([
                'status' => 200,
                'data' => $user,
		'point' => $point,
                'message' => 'Profile Data'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function postMemberProfileUpdate(Request $request)
    {
        $user = JWTAuth::toUser($request->token);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users,phone, ' .$user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'data' => null,
                'message' => 'No HP Sudah Digunakan'
            ]);
        }

        try {
            $oldPassword = $request->old_password;

            if (!$oldPassword == NULL){

                $checkPassword = Hash::check($request->old_password, $user->password);

                if ($checkPassword){
                    $validator = Validator::make($request->all(), [
                        'password' => 'required|string|min:6|confirmed'
                    ]);

                    if ($validator->fails()) {
                        $data = [
                            'name' => $request->name,
                            'phone' => $request->phone
                        ];

                        return response()->json([
                            'status' => '422',
                            'data' => $data,
                            'message' => 'Isi Password Baru'
                        ]);
                    }

                    $userUpdate = [
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'password' => bcrypt($request->password)
                    ];

                    $data = User::findOrFail($user->id);
                    $data->update($userUpdate);

                    return response()->json([
                        'status' => 200,
                        'data' => $data,
                        'message' => 'Updated successful'
                    ]);
                } else {
                    $data = [
                        'name' => $request->name,
                        'phone' => $request->phone
                    ];

                    return response()->json([
                        'status' => 406,
                        'data' => $data,
                        'message' => 'Error! Password lama tidak tepat!'
                    ]);
                }

            }

            $userUpdate = [
                'name' => $request->name,
                'phone' => $request->phone
            ];

            $data = User::findOrFail($user->id);
            $data->update($userUpdate);

            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => 'Data profile updated successful!'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function postPoint(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'point' => 'required'
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
            $memberPoint = MemberPoint::where('user_id', $user->id)->first();
            $data = [
                'user_id' => $user->id,
                'point' => $request->point
            ];

            if (!$memberPoint == null){
                $lastPoint = $memberPoint->point;
                $newPoint = $request->point;
                $totalPoint = $lastPoint + $newPoint;
                $memberPoint->point = $totalPoint;
                $memberPoint->save();

                return response()->json([
                    'status' => 200,
                    'data' => $memberPoint,
                    'message' => 'Point berhasil diupdate'
                ]);
            } else {
                $memberPoint = MemberPoint::create($data);
                return response()->json([
                    'status' => 200,
                    'data' => $memberPoint,
                    'message' => 'Point berhasil ditambah'
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

    public function getUserPredict(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
            $matchScore = MatchScore::where('user_id', $user->id)->orderBy('created_at', 'dsc')->get();
            $data = [];

            foreach ($matchScore as $row){
                $match = Match::findOrFail($row->match_id);
                $data[] = [
                    'id' => $row->id,
                    'name_club_1' => $this->match->club($match->club_id_1)->club_name,
                    'logo_club_1' => $this->match->club($match->club_id_1)->image,
                    'score_club_1' => $row->score_1,
                    'name_club_2' => $this->match->club($match->club_id_2)->club_name,
                    'logo_club_2' => $this->match->club($match->club_id_2)->image,
                    'score_club_2' => $row->score_2,
                    'date_predict' => $row->created_at->format('l, d F Y h:m')
                ];
            }

            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => 'Data Match Predict User'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getUserPredictTrue(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
            $winner = Winner::where('user_id', $user->id)->orderBy('created_at', 'dsc')->get();
            $data = [];

            //return $winner;

            foreach ($winner as $row){
                $match = Match::findOrFail($row->match_id);
                $matchScore = MatchScore::where('match_id', $row->match_id)->first();
                
                if ($match->score_club_1 == $matchScore->score_1 && $match->score_club_2 == $matchScore->score_2){
                    $data[] = [
                        'id' => $row->id,
                        'hadiah' => $row->hadiah,
                        'status_hadiah' => $row->status_hadiah,
                        'name_club_1' => $match->club($match->club_id_1)->club_name,
                        'logo_club_1' => $match->club($match->club_id_1)->image,
                        'score_club_1' => $matchScore->score_1,
                        'name_club_2' => $match->club($match->club_id_2)->club_name,
                        'logo_club_2' => $match->club($match->club_id_2)->image,
                        'score_club_2' => $matchScore->score_2,
                        'date_predict' => $match->created_at->format('l, d F Y h:m')
                    ];
                }
            }

            //return $matchScore;

            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => 'Data Match Predict User True'
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
