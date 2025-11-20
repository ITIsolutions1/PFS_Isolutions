<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExperienceDetail;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use App\Models\Proposal;

class DashboardController extends Controller
{

public function index()
{
    // Projects per category
    $categoryCounts = ExperienceDetail::select('category', DB::raw('COUNT(*) as total'))
        ->groupBy('category')
        ->get();

    $newLeads = Lead::where('status', 'new')->count();
    $contactedLeads = Lead::where('status', 'contacted')->count();
    $qualifiedLeads = Lead::where('status', 'qualified')->count();
    $totalLeads = Lead::count();

    // Projects per status
    $statusCounts = ExperienceDetail::select('status', DB::raw('COUNT(*) as total'))
        ->groupBy('status')
        ->get();

    // Projects per year (pakai date_project_start)
    $yearlyCounts = ExperienceDetail::select(
            DB::raw('YEAR(date_project_start) as year'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy(DB::raw('YEAR(date_project_start)'))
        ->orderBy('year', 'asc')
        ->get();

    // Total amount per year (convert amount string jadi integer)
    $amountPerYear = ExperienceDetail::select(
            DB::raw('YEAR(date_project_start) as year'),
            DB::raw('SUM(REPLACE(amount, ".", "")) as total_amount')
        )
        ->groupBy(DB::raw('YEAR(date_project_start)'))
        ->orderBy('year', 'asc')
        ->get();

         // Projects per category per year (NEW)
    $categoryPerYear = ExperienceDetail::select(
            'category',
            DB::raw('YEAR(date_project_start) as year'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('category', DB::raw('YEAR(date_project_start)'))
        ->orderBy('category')
        ->orderBy('year', 'asc')
        ->get();
    
          $proposalCounts = [
        'rfp'         => Proposal::where('status', 'rfp')->count(),
        'draft'       => Proposal::where('status', 'draft')->count(),
        'submitted'   => Proposal::where('status', 'submitted')->count(),
        'awaiting_po' => Proposal::where('status', 'awaiting_po')->count(),
        'awarded'     => Proposal::where('status', 'awarded')->count(),
        'decline'     => Proposal::where('status', 'decline')->count(),
        'lost'        => Proposal::where('status', 'lost')->count(),
    ];

     $statusPerYear = Proposal::select(
            DB::raw('YEAR(created_at) as year'),
            'status',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('year', 'status')
        ->orderBy('year')
        ->get();


        // Statistik singkat
        $totalProjects = ExperienceDetail::count();

    

    return view('dashboard.index', compact(
        'categoryCounts',
        'statusCounts',
        'yearlyCounts',
        'amountPerYear',
        'totalProjects',
        'categoryPerYear',
        'newLeads',
        'contactedLeads',
        'qualifiedLeads',
        'totalLeads',
        'proposalCounts',
        'statusPerYear'
    ));
}

// DashboardController.php
public function getProjectsByYear($year)
{
    $projects = ExperienceDetail::whereYear('date_project_start', $year)
        ->select('project_no', 'project_name', 'client_name', 'amount')
        ->get();

    return response()->json($projects);
}

public function getProjectsByStatus($status)
{
    $projects = ExperienceDetail::where('status', $status)
        ->select('project_no', 'project_name', 'client_name', 'amount')
        ->get();

    return response()->json($projects);
}



}



