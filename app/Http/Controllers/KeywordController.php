<?php

namespace App\Http\Controllers;


    use Illuminate\Http\Request;
    use Illuminate\Validation\Rule;
    use Illuminate\Support\Facades\Auth; 
    use Illuminate\Pagination\Paginator;
    use Illuminate\Support\Facades\DB; 
    use App\Models\Keyword;
    use App\Http\Requests\StoreKeywordRequest;
    use App\Http\Requests\UpdateKeywordRequest;

    class KeywordController extends Controller
    
    {

        public function __construct() 
        { 
            $this->middleware('preventBackHistory'); 
            $this->middleware('auth'); 
        
        }
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            if (request('search')) {
                $keywords = Keyword::where('keyword', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            } else {
                $keywords = Keyword::paginate(10);
            }
    
            return view('keywords_layout.keywords_list', ['keywords' => $keywords]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */

        public function create()
{
    return view('keywords_layout.create_keyword'); // Assuming you have a view for creating a new keyword
}


        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(StoreKeywordRequest $request)
        {
            Keyword::create($request->all());
            return redirect()->route('keywords.index');
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit(Keyword $keyword)
        {
            return view('keywords_layout.edit_keyword', compact('keyword'));
        }
        

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateKeywordRequest $request, Keyword $keyword)
        {
            $keyword->update($request->all()); 

                return redirect()->route('keywords.index')->with('success','Keyword successfully updated!');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Keyword $keyword)
        {
            $keyword->delete();

            return redirect()->route('keywords.index')->with('success', 'Keyword deleted!');
        }
    }
