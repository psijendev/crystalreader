<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Catalog;
use App\Models\Document;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCatalogRequest;
use App\Http\Requests\UpdateCatalogRequest;
use App\Http\Resources\V1\CatalogResource;
use App\Http\Resources\V1\CatalogCollection;
use App\Http\Resources\V1\DocumentResource;
use App\Http\Resources\V1\DocumentCollection;

class CatalogController extends Controller
{
    public function __construct()
    {

    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CatalogCollection(Catalog::paginate());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCatalogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

     public function showDocumentsOfCatalog(Request $request)
     {
        return new DocumentCollection(Document::where('catalog_id',$request->id)->where('isCatalog',true)->get());
     }


     public function show(Catalog $catalog)
    {
        return new CatalogResource($catalog);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Catalog $catalog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCatalogRequest $request, Catalog $catalog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Catalog $catalog)
    {
        //
    }

}


?>
