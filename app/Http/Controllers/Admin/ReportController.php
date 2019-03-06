<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ReportRepository;

class ReportController extends Controller
{
    protected $report;

    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
    }

    public function index()
    {
        $reports = $this->report->with('story', 'user')->get();

        return view('backend.reports.index', compact('reports'));
    }

    public function edit($id)
    {
        $report = $this->report->with('story', 'user')->findOrFail($id);

        return view('backend.reports.update', compact('report'));
    }
    public function update($id, Request $request)
    {
        $report = $this->report->findOrFail($id);
        $note = $request->get('note');
        $status = $request->get('status');
        $report->update([
            'note' => $note,
            'status' => $status,
        ]);

        return redirect()->back()->with('status', __('tran.report_update_status'));
    }

    public function destroy($id)
    {
        $report = $this->report->findOrFail($id);
        $report->delete();

        return redirect()->back()->with('status', __('tran.report_delete_status'));
    }
}
