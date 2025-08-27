<?php

namespace App\Http\Controllers;

use App\Models\Apiary;
use App\Models\Inspection;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    /**
     * Display the scan page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $apiaries = Apiary::where('user_id', auth()->id())->get();

        $queenStatusOptions = Inspection::getQueenStatusOptions();
        $pestsAndDiseasesOptions = Inspection::getPestsAndDiseasesOptions();
        $treatmentsOptions = Inspection::getTreatmentsOptions();
        $anomaliesOptions = Inspection::getAnomaliesOptions();
        $socialStatesOptions = Inspection::getSocialStatesOptions();
        $seasonStatesOptions = Inspection::getSeasonStatesOptions();
        $adminStatesOptions = Inspection::getAdminStatesOptions();

        return view('scan.index', compact(
            'apiaries',
            'queenStatusOptions',
            'pestsAndDiseasesOptions',
            'treatmentsOptions',
            'anomaliesOptions',
            'socialStatesOptions',
            'seasonStatesOptions',
            'adminStatesOptions'
        ));
    }
}
