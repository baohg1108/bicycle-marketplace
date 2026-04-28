<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\AlertService;
// use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;

class TagController extends Controller implements HasMiddleware
{

    public static function Middleware(): array
    {
        return [
            new Middleware("permission: Tags Management"),
        ];
    }
    //
    public function index()
    {
        $tags = Tag::paginate(20);
        return view("admin.tag.index", compact("tags"));
    }

    //
    public function create()
    {
        return view("admin.tag.create");
    }

    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => ["required", "string", "max:255", "unique:tags,name"],
        ]);
        $tag         = new Tag();
        $tag->name   = $request->name;
        $tag->slug   = Str::slug($request->name);
        $tag->status = $request->has("status") ? 1 : 0;
        $tag->save();

        AlertService::created();
        return redirect()->route("admin.tags.index");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Tag $tag)
    {
        //
        return view("admin.tag.edit", compact("tag"));
    }

    public function update(Request $request, Tag $tag)
    {
        //
        $request->validate([
            'name' => ["required", "string", "max:255", "unique:tags,name," . $tag->id],
        ]);
        $tag->name      = $request->name;
        $tag->slug      = Str::slug($request->name);
        $tag->is_active = $request->has("status") ? 1 : 0;
        $tag->save();

        AlertService::updated();
        return redirect()->route("admin.tags.index");
    }

    public function destroy(Tag $tag)
    {
        //
        $tag->delete();
        AlertService::deleted();
        return response()->json([
            "status"  => "success",
            "message" => "Tag deleted successfully",
        ]);
    }
}
