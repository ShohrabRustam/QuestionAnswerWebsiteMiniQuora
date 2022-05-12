<?php

namespace App\Http\Controllers;

use App\Notifications\WelcomeEmailNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
// use Session;
use Illuminate\Contracts\Session\Session as SessionSession;

use Illuminate\Support\Facades\Validator;

class CustomAuthController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    public function registration()
    {
        return view("auth.registration");
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:12'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->password = Hash::make($request->password);
        $res = $user->save();

        if ($res) {
            $user->notify(new WelcomeEmailNotification($user));
            return back()->with('success', 'You have registered successfully');
        } else {
            return back()->with('fail', 'Something wrong');
        }
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:12'
        ]);
        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('user', $user);
                return redirect('/');
            } else {
                return back()->with('fail', 'Wrong password');
            }
        } else {
            return back()->with('fail', 'Email not Registered.');
        }
    }

    public function dashboard(Request $request)
    {
        // $userInfo = User::find(session()->get('loginID'))->first();
        $topQues = Question::orderBy('views', 'DESC')->take(5)->get();

        // dd($userInfo->name);
        $Questions = Question::all()->sortByDesc('que_id');
        // dd($Question);
        // return view('dashboard')->with('Questions', $Question);
        return view('dashboard', compact('Questions', 'topQues'));
    }

    public function logout()
    {
        if (Session::has('user')) {
            session()->forget('user');
            return redirect('/login')->with('success', 'Logout Successfully');
        } else {
            return redirect('/login')->with('success', 'Logout Successfully');
        }
    }

    public function search(Request $request)
    {
        $topQues = Question::orderBy('views', 'DESC')->take(5)->get();

        // Get the search value from the request
        $search = $request->input('search');
        // Search in the title and body columns from the add_question table
        $Questions = Question::query()
            ->where('add_question', 'LIKE', "%{$search}%")
            ->get();
        // Return the search view with the resluts compacted
        return view('dashboard', compact('Questions', 'topQues'));
    }

    public function autocompleteSearch(Request $request)
    {
        $query = $request->get('query');
        $filterResult = Question::where('add_question', 'LIKE', '%' . $query . '%')->get();
        $testarr = [];
        foreach ($filterResult as $sata) {
            $testarr[] = array("name" => $sata->add_question);
        }
        return response()->json($testarr);
    }

    public function question($que_id)
    {
        Question::find($que_id)->increment('views');
        $queA = Question::All()
            ->where('que_id', $que_id)
            ->first();
            $user = User::where('id',$queA->add_User_id)->first();
            // return $user;
        $Answers = Answer::where('ans_Que_id', $que_id)->get();
        $aid = Answer::where('ans_Que_id', $que_id)->value('a_id');
        $comments = Comment::where('ans_id', $aid)->orderBy('created_at')->get();
        return view('answer', compact('Answers', 'queA', 'comments','user'));
    }

    public function comment(Request $req)
    {
        // return $req->all();
        if (Session::has('user'))
        {
            $validate = Validator::make($req->all(), [
                'comment' => 'required',
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'message' => $validate->errors(),
                    'status' => '406',
                ]);
            } else {
                $data = new Comment;
                $data->ans_id = $req->ans_id;
                $data->user_id = Session::get('user')['id'];
                $data->comment = $req->comment;
                $data->save();
                $username = User::where('id', $req->user_id)->select('name')->get()->first();
                return back();
                return response()->json([
                    'status' => '200',
                    'message' => $data,
                    'name' => $username,
                    'cmtTime' => $data->created_at->diffForHumans(),
                ]);
            }
        } else {
            return redirect('/login')->with('fail', 'For comment You have to login First !!');
        }
    }


    public function AddQuestion(Request $req)
    {
        if (Session::has('user')) {
            // return Session::get('user');
            // return $req->all();
            $data = new Question();
            $data->add_question = $req->des;
            $cat_name = $req->category;
            $cat_id = category::select('category_id')
                ->where('category_name', '=', $cat_name)
                ->get();
            // $result='' ;
            // return $cat_id;

            foreach ($cat_id as $temp) {
                $result = $temp->category_id;
            }
            $data->cat_Que_id = $result;
            $data->add_User_id = Session::get('user')['id'];
            $data->save();
            return redirect()->back()->with('status', 'Question added successfully');
        } else {
            return redirect('/login')->with('fail', 'For Add Question You have to login First !!');
        }
    }

    public function AddAnswer(Request $req)
    {
        if (Session::has('user')) {
            $answer = new Answer();
            $answer->ans_Que_id = $req->id;
            $answer->add_answer = $req->Summernote;
            $answer->ans_User_id = Session::get('user')['id'];
            $answer->save();
            return redirect()->back()->with('Astatus', 'Answer added successfully');
        } else {
            return redirect('/login')->with('fail', 'For Add Answer You have to login First !!');
        }
    }

    public function unAnswered()
    {
        // $noAns=Question::all();
        $noAns = DB::select(DB::raw("SELECT * FROM questions WHERE que_id NOT IN (SELECT ans_Que_id FROM answers);"));
        // return $noAns;

        $photo = User::where('id', $noAns[0]->add_User_id)->first()['photo'];
        // return $photo;
        return view('unAnswered', ['results' => $noAns]);
    }

    public function profile()
    {
        if (Session::has('user')) {
            $user = Session::get('user')['id'];
            $details = User::where('id', '=', $user)->get();
            $data = DB::select(DB::raw("SELECT count(*) as no FROM `questions` as q WHERE q.add_User_id=$user;"));
            $ans = DB::select(DB::raw("SELECT count(*) as no FROM `answers` as a WHERE a.ans_User_id=$user;"));
            $res = $data[0]->no;
            $a = $ans[0]->no;
            $que = Question::where('add_User_id', '=', $user)->get();
            $ans = Answer::where('ans_User_id', '=', $user)->get();
            return view('profile', compact("details", "res", "a", "que", "ans"));
        } else {
            return redirect('/login')->with('fail','For Profile you have to login !');
        }
    }

    public function profileUpdate(Request $req)

    {
        // return $user;
        // $req->session()->put('user', $user);

        // return $req->file('image');
        // return Session::get('user')['id'];
        if ($req->file('image')) {
            $filename = time() . "." . $req->file('image')->getClientOriginalExtension();
            // return  $filename;

            $affected = DB::table('users')
                ->where('id', $req->id)
                ->update([
                    'name' => $req->name,
                    'email' => $req->email,
                    'contact' => $req->phone,
                    'designation' => $req->designation,
                    'photo' => $filename
                ]);
                // return $user;
                $user = User::where('id',Session::get('user')['id'])->first();
                $req->session()->put('user', $user);

        } else {
            $affected = DB::table('users')
                ->where('id', $req->id)
                ->update([
                    'name' => $req->name,
                    'email' => $req->email,
                    'contact' => $req->phone,
                    'designation' => $req->designation
                ]);
                $user = User::where('id',Session::get('user')['id'])->first();
                $req->session()->put('user', $user);
        }
        if ($req->file('image')) {

            $req->file('image')->storeAs('/public/photo', $filename);
        }
        return redirect()->back()->with('status1', 'details updated successfully');
    }

    public function main()
    {
        return view('main2');
    }

    public function getQuesAccCat(Request $request)
    {
        $getData = Question::where('cat_Que_id', $request['category'])
            ->leftjoin('users as u', 'u.id', 'questions.add_User_id')
            ->select('u.name', 'questions.que_id as tt', 'questions.cat_Que_id', 'questions.add_User_id', 'questions.add_question', 'questions.slug', 'questions.views', 'questions.created_at')
            ->get();
        // $getAnsCount = $getData->tt;
        // $getAnsCount = count(Answer::where('ans_Que_id',(Question::select('que_id')))->get());

        return response()->json([
            'data' => $getData,
            //    'count'=>$getAnsCount,
        ]);
    }

    function showUserProfile($id){
        $user= User::where('id',$id)->get();
        //  return $details;
            $details = User::where('id', '=', $id)->get();
            $data = DB::select(DB::raw("SELECT count(*) as no FROM `questions` as q WHERE q.add_User_id=$id;"));
            $ans = DB::select(DB::raw("SELECT count(*) as no FROM `answers` as a WHERE a.ans_User_id=$id;"));
            $res = $data[0]->no;
            $a = $ans[0]->no;
            $que = Question::where('add_User_id', '=', $id)->get();
            $ans = Answer::where('ans_User_id', '=', $id)->get();
        return view('userDetails', compact("details", "res", "a", "que", "ans"));
    }
}
