<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ThreadRepository as Thread;
use App\Repositories\ForumRepository as Forum;
use Carbon\Carbon;
use App\User;

class HomeController extends Controller
{
    private $thread;

    /**
     * 初始化控制器配置
     * @tpp: 每页显示帖子数
     */
    public function __construct(Thread $thread, Forum $forum)
    {
        $this->middleware('auth'); //设置必须登录才能访问
        $this->thread = $thread;
        $this->forum = $forum;
        $this->tpp = 20;
        $this->now = Carbon::now();
        $this->forumInfo = $this->forum->getForumInfo();
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $type = $request->get('type') ? $request->get('type') : 'all';
        $page = $request->get('page') ? $request->get('page') : 1;
        $threadList = $this->thread->getThreadList($type, $page, $this->tpp);
        //该在列表中包含圈子名，避免复杂的联合查询
        foreach ($threadList as $k => $thread) {
            $thread->lastpostdate = $this->now->diffForHumans(Carbon::createFromTimeStamp($thread->lastpost));
        }
        return view('home/index', [
            'threadList' => $threadList,
            'forumInfo'  => $this->forumInfo,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
