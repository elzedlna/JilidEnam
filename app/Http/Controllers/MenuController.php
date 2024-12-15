<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function showmenu()
    {
        $categories = Category::with(['menus' => function ($query) {
            $query->orderBy('menuname', 'asc');
        }])->orderBy('catname', 'desc')->get();
        return view('menu', compact('categories'));
    }

    public function index()
    {
        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('menus.create', compact('categories'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'menuid'      => ['required'],
            'menuname'    => ['required'],
            'menuprice'   => ['required'],
            'menudesc'   => ['required'],
            'catid'       => ['required'],
            'menupicture' => ['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:4096'],
        ]);

        if ($request->hasFile('menupicture')) {
            // Get the original file name
            $originalName = $request->file('menupicture')->getClientOriginalName();

            // Move the file to the desired location
            $request->file('menupicture')->move(public_path('storage/menupictures'), $originalName);

            // Store the path in the database
            $validatedData['menupicture'] = 'storage/menupictures/' . $originalName;
        }


        Menu::create($validatedData);

        return redirect()->route('menus.index')
                ->with('success', 'Menu Created Successfully.');
    }

    public function show($menuid)
    {
        $menu = Menu::with('category')->where('menuid', $menuid)->firstOrFail();
        return view('menus.show', compact('menu'));
    }

    public function edit($menuid)
    {
        $menu = Menu::where('menuid', $menuid)->firstOrFail();
        $categories = Category::all(); // Fetch all categoriesz
        return view('menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, $menuid)
    {
        $request->validate([
            'menuname' => 'required',
            'menuprice' => 'required',
            'menudesc' => 'required',
            'catid' => 'required',
            'menupicture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $menu = Menu::where('menuid', $menuid)->firstOrFail();

        if ($request->hasFile('menupicture')) {
            $destinationPath = public_path('storage/menupictures');
            if ($menu->menupicture && File::exists(public_path($menu->menupicture))) {
                File::delete(public_path($menu->menupicture));
            }
            $picture = $request->file('menupicture');
            $originalName = $picture->getClientOriginalName();

            // Ensure the directory exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $picture->move($destinationPath, $originalName);
            $menu->menupicture = 'storage/menupictures/' . $originalName;
        }

        $menu->menuname = $request->get('menuname');
        $menu->menuprice = $request->get('menuprice');
        $menu->menudesc = $request->get('menudesc');
        $menu->catid = $request->get('catid');
        $menu->save();

        return redirect()->route('menus.index')
            ->with('success', 'Menu Updated Successfully.');
    }

    public function destroy($menuid)
    {
        $menu = Menu::where('menuid', $menuid)->firstOrFail();
        if ($menu->menupicture && File::exists(public_path($menu->menupicture))) {
            File::delete(public_path($menu->menupicture));
        }
        $menu->delete();

        return redirect()->route('menus.index')
            ->with('success', 'Menu Deleted Successfully.');
    }
}
