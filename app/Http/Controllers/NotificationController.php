<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Post;
use App\Image;
use App\User;
use App\Category;
use App\Comment;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller {

	public function __construct() {
        $this->middleware('auth');
    }

    public function timeAgo ( $time_ago ) {
        $time_ago       = strtotime($time_ago);
        $cur_time       = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds        = $time_elapsed ;
        $minutes        = round($time_elapsed / 60 );
        $hours          = round($time_elapsed / 3600);
        $days           = round($time_elapsed / 86400 );
        $weeks          = round($time_elapsed / 604800);
        $months         = round($time_elapsed / 2600640 );
        $years          = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60){
            return "just now";
        }
        //Minutes
        else if($minutes <=60){
            if($minutes==1){
                return "one minute ago";
            }
            else{
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "an hour ago";
            }else{
                return "$hours hrs ago";
            }
        }
        //Days
        else if($days <= 7){
            if($days==1){
                return "yesterday";
            }else{
                return "$days days ago";
            }
        }
        //Weeks
        else if($weeks <= 4.3){
            if($weeks==1){
                return "a week ago";
            }else{
                return "$weeks weeks ago";
            }
        }
        //Months
        else if($months <=12){
            if($months==1){
                return "a month ago";
            }else{
                return "$months months ago";
            }
        }
        //Years
        else{
            if($years==1){
                return "one year ago";
            }else{
                return "$years years ago";
            }
        }
    }

    public function index(){
    	$user_id = Auth::user()->id;
		$data = [];

        $notifications = DB::table('comment')
        	->select('comment.*', 'post.id AS id_post', 'users.name', 'users.name_second', 'users.image_profile')
            ->join('users', 'users.id', '=', 'comment.user_id')
            ->join('post', 'post.id', '=', 'comment.post_id')
            ->where('post.user_id', '=', $user_id)
            ->where('comment.user_id', '!=', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($notifications as $notification) {

            $data[] = [
                'id'=> $notification->id,
                'post_id'=> $notification->post_id,
                'user_id'=> $notification->user_id,
                //'comment_content'=> $notification->comment_content,
                'comment_status'=> $notification->comment_status,
                'comment_type'=> $notification->comment_type,
                'name'=> $notification->name,
                'name_second'=> $notification->name_second,
                'image_profile'=> $notification->image_profile,
                'created_at'=> $this->timeAgo($notification->created_at),
                'updated_at'=> $notification->updated_at
            ];
        }

        $notif_id = array_count_values(array_column($data, 'post_id'));

        //dd($data);

        //return $notifications;

        //print_r($notif_id);

        return view('page.notifications')
                ->with('notifications', $data)
                ->with('notif_id', $notif_id);
    }
    
    public function notifications ( $notif ){

        $user_id = Auth::user()->id;

        switch ($notif) {

            case 'notification-count':

	            $notifications = DB::table('comment')
		        	->select('comment.*', 'post.id', 'users.name', 'users.name_second', 'users.image_profile')
		            ->join('users', 'users.id', '=', 'comment.user_id')
		            ->join('post', 'post.id', '=', 'comment.post_id')
		            ->where('post.user_id', '=', $user_id)
		            ->where('comment.user_id', '!=', $user_id)
		            ->where('comment.comment_status', '=', 0)
		            ->orderBy('created_at', 'desc')
		            ->get();

                return count($notifications);
                break;

            case 'notification-list':            

            	$notifications = DB::table('comment')
		        	->select('comment.*', 'post.id', 'users.name', 'users.name_second', 'users.image_profile')
		            ->join('users', 'users.id', '=', 'comment.user_id')
		            ->join('post', 'post.id', '=', 'comment.post_id')
		            ->where('post.user_id', '=', $user_id)
		            ->where('comment.user_id', '!=', $user_id)
		            ->orderBy('created_at', 'desc')
		            ->limit(5)
		            ->get();

		        $data = [];

		        foreach ($notifications as $notification) {

		            $data[] = [
		                'id'=> $notification->id,
		                'post_id'=> $notification->post_id,
		                'user_id'=> $notification->user_id,
		                'comment_content'=> $notification->comment_content,
		                'comment_status'=> $notification->comment_status,
		                'comment_type'=> $notification->comment_type,
		                'name'=> $notification->name,
		                'name_second'=> $notification->name_second,
		                'image_profile'=> $notification->image_profile,
		                'created_at'=> $this->timeAgo($notification->created_at),
		                'updated_at'=> $notification->updated_at
		            ];
		        }

                return $data;
                break;

            case 'notification-clear':  
                
                $update_status = array(
                    'comment_status' => 1
                );
                
                $notif = DB::table('comment')
                    ->join('users', 'users.id', '=', 'comment.user_id')
                    ->join('post', 'post.id', '=', 'comment.post_id')
                    ->where('post.user_id', '=', $user_id)
                    ->where('comment.user_id', '!=', $user_id)
                    ->where('comment.comment_status', '=', 0)
                    ->select('comment.*', 'post.id', 'users.name', 'users.name_second')
                    ->update($update_status);
            
                break;

        }

    }
}
