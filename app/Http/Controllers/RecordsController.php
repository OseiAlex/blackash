<?php

namespace App\Http\Controllers;

use App\Models\AgeGroup;
use App\Models\Branch;
use App\Models\ProductCategory;
use App\Models\Record;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class RecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today_month = Carbon::now()->format('Y-m');
        $ages = AgeGroup::orderBy('title', 'asc')->get();
        $products = ProductCategory::orderBy('title', 'asc')->get();
        $branches = Branch::orderBy('title', 'asc')->get();
        return Inertia::render('Records', compact(
            'today_month',
            'ages',
            'products',
            'branches'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function fetch(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $data = Record::when($from_date, function ($q) use ($from_date) {
            $q->whereMonth('updated_at', '>=', Carbon::parse($from_date)
                ->format('m'))
                ->whereYear('updated_at', '>=', Carbon::parse($from_date)
                    ->format('Y'));
        })
            ->when($to_date, function ($q) use ($to_date) {
                $q->whereMonth('updated_at', '<=', Carbon::parse($to_date)
                    ->format('m'))
                    ->whereYear('updated_at', '<=', Carbon::parse($to_date)
                        ->format('Y'));
            })
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btnClasses = 'flex items-center justify-center p-1 bg-gray-800 text-white font-normal text-sm leading-tight rounded-sm shadow-sm hover:bg-gray-700 hover:shadow-lg focus:bg-gray-700 focus:shadow-md focus:outline-none focus:ring-0 active:bg-gray-800 active:shadow-md transition duration-150 ease-in-out';
                return '
                <div class="flex items-center gap-4">
                <button type="button" data-id="' . $row->id . '" class="view ' . $btnClasses . '">
                <span class="material-symbols-outlined">
                visibility
                </span>
                </button>
                
                <button type="button" data-id="' . $row->id . '" class="edit ' . $btnClasses . '">
                <span class="material-symbols-outlined">
                edit
                </span>
                </button>
               
                <button type="button" data-id="' . $row->id . '" class="delete flex items-center justify-center p-1 w-10 h-10 bg-red-600 text-white font-normal text-sm leading-tight rounded-sm shadow-sm hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-md focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-md transition duration-150 ease-in-out">
                <span class="material-symbols-outlined">
                delete
                </span>
                </button>
                </div>';
            })
            ->addColumn('recorded_at', function ($row) {
                return '<span class="hidden">' . strtotime($row->updated_at) . '</span>' . Carbon::parse($row->updated_at)->format('d/m/Y H:i');
            })
            ->addColumn('age_group', function ($row) {
                return $row->age_group->title;
            })
            ->addColumn('product_category', function ($row) {
                return $row->product_category->title;
            })
            ->addColumn('branch', function ($row) {
                return $row->branch->title;
            })
            ->rawColumns(['recorded_at', 'action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function download(Request $request)
    {

        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $data = Record::when($from_date, function ($q) use ($from_date) {
            $q->whereMonth('updated_at', '>=', Carbon::parse($from_date)
                ->format('m'))
                ->whereYear('updated_at', '>=', Carbon::parse($from_date)
                    ->format('Y'));
        })
            ->when($to_date, function ($q) use ($to_date) {
                $q->whereMonth('updated_at', '<=', Carbon::parse($to_date)
                    ->format('m'))
                    ->whereYear('updated_at', '<=', Carbon::parse($to_date)
                        ->format('Y'));
            })
            ->latest()
            ->get();

        $from = $from_date ? Carbon::parse($from_date)->format('j, Y') : '- -';
        $to = $to_date ? Carbon::parse($to_date)->format('j, Y') : '- -';

        try {
            $pdf = Pdf::loadView('reports', compact('from', 'to', 'data'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download('report.pdf');
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('PDF generation failed: ' . $e->getMessage());
            // Return a response indicating failure
            return response()->json(['error' => 'PDF generation failed'], 500);
        }
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'                    => 'required',
                'phone'                   => ['required', 'digits_between:10,16', Rule::unique('records')],
                'location'                => 'required',
                'age_group_id'            => 'required',
                'product_category_id'     => 'required',
                'branch_id'               => 'required',
                'remarks'                 => 'required',
            ],
            [
                'age_group_id.required'           => 'The age group field is required.',
                'product_category_id.required'    => 'The product category field is required.',
                'branch_id.required'        => 'The branch field is required.'
            ]
        );

        $input = $request->all();
        $input['name'] = ucwords($input['name']);

        Auth::user()->record()->create($input);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = Record::with([
            'user',
            'age_group',
            'product_category',
            'branch'
            ])
            ->find($request->id);

            $data['recorded_at']  = Carbon::parse($data->updated_at)->format('d/m/Y H:i');

        return response()->json([
            'row'   => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $data = Record::find($request->id);

        return response()->json([
            'row' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Record $record)
    {
        $request->validate(
            [
                'name'                    => 'required',
                'phone'                   => ['required', 'digits_between:10,16', Rule::unique('records')->ignore($record)],
                'location'                => 'required',
                'age_group_id'            => 'required',
                'product_category_id'     => 'required',
                'branch_id'               => 'required',
                'remarks'                 => 'required',
            ],
            [
                'age_group_id.required'           => 'The age group field is required.',
                'product_category_id.required'    => 'The product category field is required.',
                'branch_id.required'        => 'The branch field is required.'
            ]
        );

        $input = $request->all();
        $input['name'] = ucwords($input['name']);
        $record->fill($input);

        Auth::user()->record()->save($record);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = Record::find($request->id);

        $data->delete();
    }
}
