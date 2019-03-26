<?php

namespace App;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;

class GameItemInfo {

    function selectGameInfo($query, $input) {
        $returnInfos = [];

        $competences = Competence::all();
        $competences = $competences->keyBy('id');

        $users = User::with('userItems')->where('user_responsable_id', $input->user_responsable_id)->get();

        foreach ($users as $user) {

            $returnInfo = new \stdClass();
            $returnInfo->id = $user->id;
            $returnInfo->name = $user->name;

            if ($user->game_status == 0)  $returnInfo->status = "views.game.states.pending-init";
            else if ($user->game_status == 1) $returnInfo->status = "views.game.states.pending-validation";
            else if ($user->game_status == 2) $returnInfo->status = "views.game.states.playing";
            else if ($user->game_status == 3) $returnInfo->status = "views.game.states.pending-review";
            else $returnInfo->status = "views.game.states.finished";

            $alliesCounter = 0;
            $resourcesCounter = 0;
            $competencesCounter = 0;
            $maxCompetences = 0;

            foreach ($user->userItems as $item) {
                if ($item->item == "allie") $alliesCounter++;
                else if ($item->item == "resource") $resourcesCounter++;
                else {
                    $competence = $competences->get($item->item_id); 
                    $maxCompetences += $competence->max_level;
                    $competencesCounter += $item->level;
                }
            }
            $returnInfo->allies = $alliesCounter;
            $returnInfo->resources = $resourcesCounter;
            $returnInfo->competences = $maxCompetences > 0 ? 100 * $competencesCounter / $maxCompetences : 0;

            $returnInfos[] = $returnInfo;
        }

        return $returnInfos;
    }

    function selectOwned($query, $input) {
        return $this->selectOwnedNotOwned($query, $input)->owned;
    }

    function selectNotOwned($query, $input) {
        return $this->selectOwnedNotOwned($query, $input)->notOwned;
    }

    // private
    private function selectOwnedNotOwned($query, $input) {
        $queryValues = Helper::getQueryValues($query);

        $items = new \StdClass();

        $items->owned = [];
        $items->notOwned = [];

        $name = 'App\\' . ucfirst($query->inputs[1]->value);

        $owned = UserItem::select('item_id')->where('user_id', $input->user_id)->where('item', $queryValues->type)->get();
        $allItems = $name::select('id', 'name', 'image')->get();

        foreach($allItems as $item) {
            if (ModelHelper::containsItem($owned, $item->id)) $items->owned[] = $item;
            else $items->notOwned[] = $item;
        }

        return $items;
    }


}