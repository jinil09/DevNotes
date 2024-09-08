<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commit;

class CommitController extends Controller
{
    public function create()
    {
        return view('commits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required',
            'commit_message' => 'required',
            'file_path' => 'required',
            'date' => 'required|date',
        ]);

        $filePathsArray = explode("\n", trim($request->file_path));
        $userId = auth()->id(); 

        if ($request->has('id')) {
            // Update existing record
            $commit = Commit::findOrFail($request->id);
            $commit->update([
                'branch_name' => $request->branch_name,
                'commit_message' => $request->commit_message,
                'file_path' => json_encode($filePathsArray, JSON_UNESCAPED_SLASHES),
                'date' => $request->date,
                'user_id' => $userId,
            ]);

            return redirect('/commits')->with('success', 'Commit updated successfully.');
        } else {
            // Create new record
            Commit::create([
                'branch_name' => $request->branch_name,
                'commit_message' => $request->commit_message,
                'file_path' => json_encode($filePathsArray, JSON_UNESCAPED_SLASHES),
                'date' => $request->date,
                'user_id' => $userId,
            ]);

            return redirect('/commits')->with('success', 'Commit added successfully.');
        }
    }

    public function index()
    {
        $commits = Commit::where('user_id', auth()->id())->get();
        return view('commits.index', compact('commits'));
    }


    public function home()
    {
        $commits = Commit::where('user_id', auth()->id())
                     ->orderBy('created_at', 'desc')
                     ->take(5)
                     ->get();
        return view('home', compact('commits'));
    }

    public function editCommit($id){
        $commit = Commit::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();
        return view('commits.create', compact('commit'));
    }
}
