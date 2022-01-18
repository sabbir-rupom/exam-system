<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Question\QuestionGroup;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::where('owner_id', session('owner')['id'])->paginate(10);

        return view('entity.group.index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('entity.group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
        ]);

        $name = trim($request->name);
        $slug = empty($request->slug) ? slug_create($request->name) : trim(strtolower($request->slug));

        $group = Group::where('owner_id', session('owner_id'))
            ->where(function ($query) use ($name, $slug) {
                $query->where('name', $name)->orWhere('slug', $slug);
            })->first();

        if ($group) {

            if ($group->name === $name) {
                return back()->with('status', 'Group name already exists');
            }
            $group->name = $name;
            $group->slug = $slug . rand(1, 999);
            $group->save();
        } else {
            Group::create([
                'name' => $name,
                'owner_id' => session('owner')['id'],
                'slug' => $slug,
            ]);
        }

        return redirect()->route('groups.index')->with('success', 'Group added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('entity.group.edit', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        if (empty($group) || $group->owner_id != session('owner_id')) {
            return back()->with('status', 'Group not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        if (empty($group) || $group->owner_id != session('owner_id')) {
            return back()->with('status', 'Group not found');
        }

        $name = trim($request->name);
        $slug = $request->slug;
        if ($group->slug !== $request->slug) {
            $slug = empty($request->slug) ? slug_create($request->name) : trim(strtolower($request->slug));
            $exist = Group::where([
                'owner_id' => session('owner_id'),
                'slug' => $slug,
            ])->first();

            if ($exist) {
                $slug .= rand(1, 999);
            }
        }

        $group->name = $name;
        $group->slug = $slug;
        $group->save();

        return back()->with('success', 'Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if (empty($group) || $group->owner_id != session('owner_id')) {
            return back()->with('status', 'Group not found');
        }

        QuestionGroup::where('group_id', $group->id)->delete();

        $group->delete();

        return redirect()->route('groups')->with('success', 'Group deleted successfully');
    }
}
