<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\V1\StoreBookmarkRequest;
use App\Http\Requests\V1\UpdateBookmarkRequest;
use App\Http\Resources\V1\BookmarkResource;
use App\Http\Resources\V1\BookmarkCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class BookmarkController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new BookmarkCollection(Bookmark::paginate()->where('user_id', auth('sanctum')->user()->id));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookmarkRequest $request)
    {
        $uid = auth('sanctum')->user()->id;
        $request->validated($request->all());
        $bookmark = Bookmark::create([
            'user_id' => $uid,
            'document_id' => $request->document_id,
            'status' => "Active",
        ]);
        $res = new BookmarkResource($bookmark);
        return response()->json(["data"=> "Bookmark Created", $res]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Bookmark $bookmark)
    {

        $uid = auth('sanctum')->user()->id;
        if($uid !== $bookmark->user_id){
            return response()->json(["data"=> "You are not authorized to view the bookmark"]);
            abort(403);
        }else{
            $bookmarks = Bookmark::where('id',$bookmark->id)->where('user_id', $uid)->get();
            return response()->json(["data" => $bookmarks]);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Bookmark $bookmark)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookmarkRequest $request, Bookmark $bookmark)
    {
        $uid = auth('sanctum')->user()->id;
        if($uid !== $bookmark->user_id){
            return response()->json(["data"=>"You are not authorized to edit this"]);
            abort(403);
        }else{
            $bookmark->update([
                'user_id' => $uid,
                'status' => $request->status
            ]);
            $res = new BookmarkResource($bookmark);
            return response()->json(["data"=> "Bookmark Updated!", $res]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookmark $bookmark)
    {
        $uid = auth('sanctum')->user()->id;
        if($uid !== $bookmark->user_id){
            return response()->json(["data"=>"You are not authorized to Delete this"]);
            abort(403);
        }else{
            $bookmark->delete($bookmark);
            return response()->json(["data"=> "Bookmark :".$bookmark->id." Deleted!"]);
        }

    }
}

