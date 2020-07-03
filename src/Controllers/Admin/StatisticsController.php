<?php


namespace Azuriom\Plugin\Vote\Controllers\Admin;


use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Vote\Models\Vote;

class StatisticsController extends Controller
{

    /**
     * Open view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        return view("vote::admin.statistics", [
            'voteAmount' => Vote::all()->count(),
            'voteAmountMonth' => $this->getVoteMonth(),
            'voteAmountWeek' => $this->getVoteWeek(),
            'voteAmountDay' => $this->getVoteDay(),
            'voteMonth' => $this->getVoteMonthChar(),
        ]);

    }

    /**
     * @return mixed
     */
    private function getVoteMonth()
    {
        return Vote::whereDate('created_at', '>=', now()->startOfMonth())->count();
    }

    /**
     * @return mixed
     */
    private function getVoteWeek()
    {
        return Vote::whereDate('created_at', '>=', now()->startOfWeek())->count();
    }

    /**
     * @return mixed
     */
    private function getVoteDay()
    {
        return Vote::whereDate('created_at', '>=', now()->startOfDay())->count();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function getVoteMonthChar(){

        $date = now()->subMonths(1);
        $votes = [];

        $queryVotes = Vote::whereDate('created_at', '>=', $date)
            ->get(['id', 'created_at'])
            ->countBy(function ($vote) {
               return $vote->created_at->translatedFormat('D M');
            });

        for ($i = 0; $i < 30; $i++) {
            $date->addDay();
            $time = $date->translatedFormat('D M');
            $votes[$time] = $queryVotes->get($time, 0);
        }

        return collect($votes);
    }

}
