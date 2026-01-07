<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    /* Admin List */
    public function index()
    {
        $pages = CmsPage::latest()->paginate(10);
        return view('admin.cms.index', compact('pages'));
    }

    /* Create Form */
    public function create()
    {
        $parents = CmsPage::whereNull('parent_id')->get();
        return view('admin.cms.create', compact('parents'));
    }

    /* Store */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|unique:cms_pages,slug',
            'content' => 'required',
            'image' => 'nullable|image',
            'status' => 'required',
            'visibility' => 'required',
            'allowed_roles' => 'nullable|array',
            'parent_id' => 'nullable|exists:cms_pages,id',
            'menu_order' => 'nullable|integer',
            'template' => 'nullable|string',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['created_by'] = session('auth_user')->id ?? null;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cms','public');
        }

        CmsPage::create($data);

        return redirect()->route('cms.index')->with('success','Page created successfully');
    }

    /* Edit */
    public function edit($id)
    {
        $page = CmsPage::findOrFail($id);
        $parents = CmsPage::whereNull('parent_id')->where('id','!=',$id)->get();
        return view('admin.cms.edit', compact('page','parents'));
    }

    /* Update */
    public function update(Request $request, $id)
    {
        $page = CmsPage::findOrFail($id);

        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:cms_pages,slug,' . $id,
            'content' => 'required',
            'status' => 'required',
            'visibility' => 'required',
        ]);

        $data['updated_by'] = session('auth_user')->id ?? null;

        $page->update($data);

        return redirect()->route('cms.index')->with('success','Page updated');
    }

    /* Frontend Render */
    public function show($slug)
    {
        $page = CmsPage::where('slug',$slug)
            ->where('status','active')
            ->firstOrFail();

        return view('admin.cms.front', compact('page'));
    }
}
