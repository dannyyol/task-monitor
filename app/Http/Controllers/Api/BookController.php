<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Request as RequestFacade;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $books = Book::latest()->get();
        return response()->json(['status_code'=>200, 'status'=>'success', 'data' => new BookCollection($books)], 200);
    }

    function booKProp($book){
        $data['name']= $book->name;
        $data['authors']= array($book->authors);
        $data['number_of_pages']= $book->numberOfPages;
        $data['publisher']= $book->publisher;
        $data['country']= $book->country;
        $data['release_date']= $book->released;

        return $data;

    }

    public function externalBooks()
    {
        //
        $client = new \GuzzleHttp\Client();
        $requestBooks = $client->get('https://www.anapioficeandfire.com/api/books');

        $response = $requestBooks->getBody()->getContents();

        $responseToJson = collect(json_decode($response));

        $data = $responseToJson->map(
            function($book){

                $remove_spaces_from_name = str_replace(' ', '', strtolower(RequestFacade::get('name')));
                $remove_spaces_from_name2 = str_replace(' ', '', strtolower($book->name));

                $remove_spaces_from_country = str_replace(' ', '', strtolower(RequestFacade::get('country')));
                $remove_spaces_from_country2 = str_replace(' ', '', strtolower($book->country));


                $remove_spaces_from_publisher = str_replace(' ', '', strtolower(RequestFacade::get('publisher')));
                $remove_spaces_from_publisher2 = str_replace(' ', '', strtolower($book->publisher));


                $remove_spaces_from_date = date("Y", strtotime(RequestFacade::get('released')));
                $remove_spaces_from_date2 = date("Y", strtotime($book->released));

                // filter by name
                if($remove_spaces_from_name == $remove_spaces_from_name2){
                    $data = $this->booKProp($book);
                    return $data;
                }

                // filter by country
                elseif($remove_spaces_from_country == $remove_spaces_from_country2){
                    $data = $this->booKProp($book);
                    return $data;
                }

                // filter by publisher
                elseif($remove_spaces_from_publisher == $remove_spaces_from_publisher2){
                    $data = $this->booKProp($book);
                    return $data;
                }

                // filter by date
                elseif($remove_spaces_from_date == $remove_spaces_from_date2){
                    $data = $this->booKProp($book);
                    return $data;
                }
            }
        );

        return response()->json(['status_code' => '200', 'status'=>'success', 'data'=>$data->filter()], 200);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'name' => 'required',
            'isbn' => 'required',
            "authors.*"  => "required",
            'country' => 'required',
            'publishers' => 'required',
            'release_date' => 'required',
            'number_of_pages' => 'required|numeric',

        ]);
        $get_authors = $request->get('authors');

        if (count($get_authors) == count($get_authors, COUNT_RECURSIVE)){
            $authors = $request->get('authors');
        }
        else{
            foreach($get_authors as $author_name){
                $authors[] = $author_name['name'];
            }
        }

        $book = Book::create([
            'name'=>$request->get('name'),
            'isbn'=> $request->get('isbn'),
            'authors' => serialize($authors), //To save an array of authors in the database
            'country' => $request->country,
            'number_of_pages' => $request->number_of_pages,
            'publishers' => $request->publishers,
            'release_date' => $request->get('release_date')

        ]);
        return response()->json(['status_code'=>201, 'status'=>'success', 'data' => new BookResource($book)], 201);

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
        try{
            $book = Book::findOrFail($id);
            return response()->json(['status_code'=>200, 'status'=>'success', 'data' => new BookResource($book)], 200);
        }
        catch(ModelNotFoundException $err){
            return response()->json(['status_code'=>404, 'status'=>'error', "message" => "The requested book was not found"], 404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        try{
            $book = Book::findOrFail($id);

            return response()->json(new BookResource($book), 200);

        }
        catch(ModelNotFoundException $err){
            return response()->json(["status_code"=> 404, 'status'=>'error', "message" => "The requested book was not found"], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'isbn' => 'required',
            "authors.*"  => "required",
            'country' => 'required',
            'publishers' => 'required',
            'release_date' => 'required',
            'number_of_pages' => 'required',

           ]);
        try{
            //Find the user object from model if it exists
            $book= Book::findOrFail($id);

            $book->update([
                'name'=>$request->get('name'),
                'isbn'=> $request->get('isbn'),
                'authors' => serialize($request->get('authors')), //To save an array of authors in the database
                'country' => $request->country,
                'number_of_pages' => $request->number_of_pages,
                'publishers' => $request->publishers,
                'release_date' => $request->get('release_date')

            ]);

            return response()->json(["status_code" => 200, 'status'=>'success', "message" => 'The book ' . $book->name . ' was updated successfully', 'data' => new BookResource($book)], 200);
        }
        catch(ModelNotFoundException $err){
            return response()->json(["status_code" => 404,'status'=>'error', "message" => "The requested book was not found"], 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try{
            $book= Book::findOrFail($id);
            $deleteBook = $book->delete();
            return response()->json(["status_code" => 204, 'status'=>'success', "message" => 'The book ' . $book->name . ' was deleted successfully', 'data' => $deleteBook], 204);
        }
        catch(ModelNotFoundException $err){
            return response()->json(["status_code" => 404, 'status'=>'error', "message" => "The requested book was not found"], 404);
        }
    }

    public function search(Request $request){
        $q = $request->get( 'query' );
        $books = Book::where ( 'name', 'LIKE', '%' . $q . '%' )->orWhere ( 'country', 'LIKE', '%' . $q . '%' )
                    ->orWhere ( 'publishers', 'LIKE', '%' . $q . '%' )
                    ->orWhere ( 'authors', 'LIKE', '%' . $q . '%' )
                    ->orWhere ( 'release_date', 'LIKE', '%' . $q . '%' )->get();

        if(count($books) > 0){
            return response()->json(['status_code' => '200', 'status'=>'success', 'data'=>$books], 200);
        }
        else{
            return response()->json(['status_code' => '404', 'status'=>'success', 'message'=>"No Book is Found"], 404);
        }

    }
}
