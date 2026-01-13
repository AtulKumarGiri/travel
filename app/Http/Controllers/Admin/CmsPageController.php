<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\CmsPage;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    /* Admin List */
    public function index(){
        $pages = CmsPage::latest()->paginate(10);
        return view('admin.cms.page.index', compact('pages'));
    }

    /* Create Form */
    public function create(){
        $parents = CmsPage::whereNull('parent_id')->get();
        return view('admin.cms.page.create', compact('parents'));
    }

    /* Store */
    public function store(Request $request){
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
    public function edit($id){
        $page = CmsPage::findOrFail($id);
        $parents = CmsPage::whereNull('parent_id')->where('id','!=',$id)->get();
        return view('admin.cms.page.edit', compact('page','parents'));
    }

    /* Update */
    public function update(Request $request, $id){
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
    public function show($slug){
        $page = CmsPage::where('slug',$slug)
            ->where('status','active')
            ->firstOrFail();

        return view('admin.cms.page.front', compact('page'));
    }

    public function destroy($id){
        $page = CmsPage::find($id);

        if (!$page) {
            return redirect()->back()->with('error', 'Page not found.');
        }

        $page->delete();

        return redirect()->back()->with('success', 'Page deleted successfully.');
    }

    public function bannerindex(){
        $banners = Banner::latest()->paginate(10);
        return view('admin.cms.banner.index', compact('banners'));
    }

    public function createbanner(){
        $parents = CmsPage::whereNull('parent_id')->get();
        return view('admin.cms.banner.create', compact('parents'));
    }

    public function storebanner(Request $request){
        $request->validate([
            'slides.*.image' => 'required|image|max:2048',
            'slides.*.heading' => 'required|string|max:255',
            'slides.*.subheading' => 'nullable|string',
            'slides.*.status' => 'required|in:draft,active',
        ]);

        foreach ($request->slides as $slide) {
            $imagePath = $slide['image']->store('banners', 'public');

            Banner::create([
                'image' => $imagePath,
                'heading' => $slide['heading'],
                'subheading' => $slide['subheading'] ?? null,
                'status' => $slide['status'],
            ]);
        }

        return redirect()->back()->with('success', 'Slider created successfully.');
    }

    public function editbanner($id){
        $banner = Banner::findOrFail($id);
        return view('admin.cms.banner.edit', compact('banner'));
    }

    public function updatebanner(Request $request, $id){
        $banner = Banner::findOrFail($id);

        $data = $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string',
            'status' => 'required|in:draft,active',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('cms.banner.index')->with('success', 'Banner updated successfully.');
    }

    public function destroybanner($id){
        $banner = Banner::find($id);

        if (!$banner) {
            return redirect()->back()->with('error', 'Banner not found.');
        }

        $banner->delete();

        return redirect()->back()->with('success', 'Banner deleted successfully.');
    }

    public function showbanner()
    {
        $banners = Banner::where('status', 'active')->orderBy('created_at', 'desc')->get();

        return view('admin.cms.banner.front', compact('banners'));
    }


}
