<?php


namespace Azuriom\Plugin\Vote\Controllers\Admin;


use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Azuriom\Plugin\Vote\Models\Vote;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Support\Facades\DB;

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
            'voteYear' => $this->getVoteYearChar(),
            'voteLastYear' => $this->getVoteLastYearChar(),
            'months' => $this->getMonthAsString(),
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
    private function getVoteMonthChar()
    {

        $date = now()->subMonths(1);
        $votes = [];

        $queryVotes = Vote::whereDate('created_at', '>=', $date)
            ->get(['id', 'created_at'])
            ->countBy(function ($vote) {
                return $vote->created_at->translatedFormat('l j F Y');
            });

        for ($i = 0; $i < 30; $i++) {
            $date->addDay();
            $time = $date->translatedFormat('l j F Y');
            $votes[$time] = $queryVotes->get($time, 0);
        }

        return collect($votes);
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    private function getVoteYearChar()
    {

        $date = now()->firstOfYear();
        $votes = [];

        $queryVotes = Vote::whereDate('created_at', '>=', $date)
            ->get(['id', 'created_at'])
            ->countBy(function ($vote) {
                return $vote->created_at->translatedFormat('M Y');
            });

        for ($i = 0; $i < 12; $i++) {
            $time = $date->translatedFormat('M Y');
            $votes[$date->translatedFormat('F')] = $queryVotes->get($time, 0);
            $date->addMonth();
        }

        return collect($votes);
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    private function getVoteLastYearChar()
    {

        $date = now()->firstOfYear()->subYears(1);
        $votes = [];

        $queryVotes = Vote::whereDate('created_at', '>=', $date)
            ->get(['id', 'created_at'])
            ->countBy(function ($vote) {
                return $vote->created_at->translatedFormat('M Y');
            });

        for ($i = 0; $i < 12; $i++) {
            $time = $date->translatedFormat('M Y');
            $votes[$date->translatedFormat('F')] = $queryVotes->get($time, 0);
            $date->addMonth();
        }

        return collect($votes);
    }

    /**
     * @return array
     */
    private function getMonthAsString()
    {
        $months = [];

        $date = now()->firstOfYear();
        for ($i = 0; $i < 12; $i++) {
            array_push($months, $date->translatedFormat('F'));
            $date->addMonth();
        }

        return $months;
    }
}
