<?php

namespace App\Http\Controllers; 

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Deadline;
use App\Models\DeadlineType;
use App\Models\DocType;
use App\Models\Document;
use App\Models\Employee;
use App\Models\FollowupType;
use App\Models\SecurityLevel;
use App\Models\Status;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        
        if ($request->ajax()) {
            return (new Document)->getDocuments($request);
        }
        return view('document.index');
        // return Document::all();

        // $query = Document::with(['tracks' => function ($query) use ($request) {
        //     if (!empty($request->doc_type_id)) {
        //         $query->where('doc_type_id', $request->doc_type_id);
        //     }
        // }]);
        // $query = Document::query();
        // if (!empty($request->title)) {
        //     $query->where('title', 'like', '%' . $request->title . '%');
        // }
        
        // if (!empty($request->remark)) {
        //     $query->where('remark', 'like', '%' . $request->remark . '%');
        // }
        // if (!empty($request->doc_type_id)) {
        //    return $query;
        // }
        
        // $documents = $query->paginate(10);
        
        // return DocumentResource::collection($documents);
    }
    public function create()
    {
       $data['employees'] = Employee::all();
       $data['deadlines'] = Deadline::all();
       $data['deadline_types'] = DeadlineType::all();

       $data['statuses'] = Status::all();
       $data['security_levels'] = SecurityLevel::all();
       $data['followup_types'] = FollowupType::all();
       $data['document_types'] = DocType::all();

       return view('document.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    { 
       
        $document = Document::create($request->validated());
        return response()->json([
            'document_id' => $document->id,
            'status' => 200,
            'message' => __('general_words.record_saved'),
        ]);
    }

   

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $document->load('trackers');
        $document->load([
            'trackers.sender',
            'trackers.receiver',
            'trackers.docType',
            'trackers.deadline',
            'trackers.deadlineType',
            'trackers.followupType',
            'trackers.securityLevel',
            'trackers.status'
        ]);
        return view('document.show', ['document' => $document]);
    }



    public function edit(Document $document)
    { 
        $document->load('trackers');
        $document->load([
            'trackers.sender',
            'trackers.receiver',
            'trackers.docType',
            'trackers.deadline',
            'trackers.deadlineType',
            'trackers.followupType',
            'trackers.securityLevel',
            'trackers.status'
        ]);
        $data['document'] = $document;
        $data['employees'] = Employee::all();
        $data['deadlines'] = Deadline::all();
        $data['deadline_types'] = DeadlineType::all();
        $data['statuses'] = Status::all();
        $data['security_levels'] = SecurityLevel::all();
        $data['followup_types'] = FollowupType::all();
        $data['document_types'] = DocType::all();
        return view('document.edit', $data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $document->update($request->validated());
        return response()->json([
            'status' => '200',
            'message' => __('general_words.record_updated') 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $deleted = $document->delete();
        if($deleted){
         return response()->json([
             'status' => '200',
             'message' => __('general_words.record_deleted'),
         ]);
        }
    }
}
